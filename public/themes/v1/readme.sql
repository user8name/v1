--用于实现从wp的分类里面提取指定父级的所有子类的函数

select `wp_terms`.`term_id` AS `term_id`,`wp_terms`.`name` AS `name`,`wp_terms`.`slug` AS `slug`,`wp_term_taxonomy`.`taxonomy` AS `taxonomy`,`wp_term_taxonomy`.`description` AS `description`,`wp_term_taxonomy`.`parent` AS `parent` from (`wp_terms` join `wp_term_taxonomy` on((`wp_terms`.`term_id` = `wp_term_taxonomy`.`term_id`))) where find_in_set(`wp_terms`.`term_id`,`getChildList`('3'))


DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `getChildList`(rootId VARCHAR(100)) RETURNS varchar(2000) CHARSET utf8
    NO SQL
BEGIN
    DECLARE str VARCHAR(2000);
    DECLARE cid VARCHAR(100);
    SET str = '$';
    SET cid = rootId;
    WHILE cid IS NOT NULL DO
	SET str = CONCAT(str, ',', cid);
	SELECT GROUP_CONCAT(term_id) INTO cid FROM `wp_term_taxonomy` WHERE FIND_IN_SET(`parent`, cid) > 0;
	END WHILE;
    RETURN str;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `getParentList`(rootId varchar(100)) RETURNS varchar(1000) CHARSET utf8
    NO SQL
BEGIN   
DECLARE fid varchar(100) default '';   
DECLARE str varchar(1000) default rootId;   
  
WHILE rootId is not null  do   
    SET fid =(SELECT parent FROM wp_term_taxonomy WHERE term_id = rootId);   
    IF fid is not null THEN   
        SET str = concat(str, ',', fid);   
        SET rootId = fid;   
    ELSE   
        SET rootId = fid;   
    END IF;   
END WHILE;   
return str;  
END$$
DELIMITER ;


--下面的储存过程目的是将这些数据格式化并导入到表，函数不支持反馈记录集，而phpmaker也不支持调用存储过程

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `createChildLst`(IN rootId INT,IN nDepth INT)
    NO SQL
BEGIN
  DECLARE done INT DEFAULT 0;
  DECLARE b INT;
  DECLARE cur1 CURSOR FOR SELECT term_id FROM wp_term_taxonomy where parent=rootId;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
  
  insert into tmpLst values (null,rootId,nDepth);
  
  OPEN cur1;
  
  FETCH cur1 INTO b;
  WHILE done=0 DO
      CALL createChildLst(b,nDepth+1);
      FETCH cur1 INTO b;
  END WHILE;
  
  CLOSE cur1;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `showChildLst`(IN `rootId` INT)
    NO SQL
BEGIN
    CREATE TEMPORARY TABLE IF NOT EXISTS tmpLst(
        sno INT PRIMARY KEY AUTO_INCREMENT,
        id INT,
        depth INT
    ); 
     set max_sp_recursion_depth=255;
    DELETE FROM tmpLst;
CALL createChildLst(rootId, 0);
DELETE FROM wp_products_categories;
INSERT INTO `wp_products_categories`(`id`, `name`, `fullname`, `slug`, `parent`, `depth`,`sno`)
SELECT
    tmpLst.id,
    wp_terms.name,
    concat('|--',REPEAT('-',tmpLst.depth*4),wp_terms.name) as fullname,
    wp_terms.slug,
    wp_term_taxonomy.parent,
    tmpLst.depth,
    tmpLst.sno
FROM
    tmpLst,
    wp_term_taxonomy,
    wp_terms
WHERE
    tmpLst.id = wp_term_taxonomy.term_id and tmpLst.id=wp_terms.term_id
ORDER BY
    tmpLst.sno;
    
END$$
DELIMITER ;


--产品模块需要建立3个表
--wp_products
CREATE TABLE `wp_products` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `cid` int(11) NOT NULL DEFAULT '0',
 `cat` varchar(30) NOT NULL,
 `productname` varchar(100) NOT NULL,
 `description` varchar(255) NOT NULL,
 `detail` json DEFAULT NULL,
 `tag` varchar(50) DEFAULT NULL,
 `sortnum` int(11) NOT NULL DEFAULT '0',
 `status` int(11) NOT NULL DEFAULT '0',
 `isdel` int(11) NOT NULL DEFAULT '0',
 `seo_title` varchar(255) DEFAULT NULL,
 `seo_keywords` varchar(255) DEFAULT NULL,
 `seo_description` varchar(512) DEFAULT NULL,
 `seo_url` varchar(512) DEFAULT NULL,
 `itime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `utime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 `searchtxt` text,
 PRIMARY KEY (`id`),
 UNIQUE KEY `cat` (`cat`) USING BTREE,
 KEY `cid` (`cid`),
 KEY `productname` (`productname`),
 KEY `description` (`description`),
 KEY `isdel` (`isdel`),
 KEY `tag` (`tag`),
 KEY `sortnum` (`sortnum`),
 KEY `status` (`status`),
 FULLTEXT KEY `searchtxt` (`searchtxt`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8
--wp_products_categories	
CREATE TABLE `wp_products_categories` (
 `id` int(11) NOT NULL,
 `name` varchar(255) NOT NULL,
 `fullname` varchar(255) NOT NULL,
 `slug` varchar(255) NOT NULL,
 `parent` int(11) NOT NULL,
 `depth` int(11) NOT NULL,
 `sno` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
--wp_products_tasks	
CREATE TABLE `wp_products_tasks` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `title` varchar(255) DEFAULT NULL,
 `filename` varchar(255) DEFAULT NULL,
 `filepath` varchar(255) DEFAULT NULL,
 `status` varchar(255) DEFAULT NULL,
 `userid` int(11) DEFAULT '0',
 `username` varchar(255) DEFAULT NULL,
 `itime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `utime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 `remark` text,
 `msg` text,
 PRIMARY KEY (`id`),
 KEY `title` (`title`),
 KEY `status` (`status`),
 KEY `filename` (`filename`),
 KEY `username` (`username`),
 KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

/*
phpmaker的代码，需要做一些调整，以便调用wp的方法和验证等
 在 ewcfg12.php 增加如下代码
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-config.php');

if(!is_user_logged_in() || !current_user_can('level_10')){
    echo 'Please log in.';
    die();
}


这不是必须的，可以直接在phpmaker的
Page_Loading hook里面增加以上代码，避免被覆盖
提取jsontxt的字段值
update `wp_products` set mw= (SELECT JSON_EXTRACT(jsontxt,'$."molecular weight  g/mol"') FROM `wp_products_json` WHERE wp_products.id = wp_products_json.productid)

update `wp_products` set mw= (SELECT trim(BOTH '"' FROM JSON_EXTRACT(jsontxt,'$."molecular weight  g/mol"')) FROM `wp_products_json` WHERE wp_products.id = wp_products_json.productid)
*/