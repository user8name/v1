<?php
/**
 * echo v1_get_domain(array('type'=>'link'))
 */
function v1_get_domain($atts=null, $content = null){
	$a = shortcode_atts( array(
        'type' => 'domain',
        // ...etc
	), $atts );
	
	$domain=$_SERVER['HTTP_HOST'];
	if(preg_match('/matexcel\.com/i', $domain)){
		$domain = 'matexcel.com';
	}else{
		$domain = 'material-cell.com';
	}

	if($a['type']=='email'){
		$domain = 'info@'.$domain;
	}else if($a['type']=='link'){
		$domain = '<a href="mailto:info@'.$domain.'">info@'.$domain.'</a>';
	}
	return $content.$domain;
}
/**
 * [v1_get_domain type="link"]
 * [v1_get_domain type="email"]
 * [v1_get_domain]
 * [v1_get_domain]Domain:[/v1_get_domain]
 * 
 * 主题里面使用
 * <?php echo do_shortcode("[v1_get_domain]"); ?>
 */
add_shortcode('v1_get_domain', 'v1_get_domain'); 


/**
 * 获取模板目录地址
 */
function v1_get_template_directory_uri($atts=null, $content = null){
    return get_template_directory_uri() ;
}

add_shortcode('v1_get_template_directory_uri', 'v1_get_template_directory_uri'); 

/**
 * 获取主题选项
 * 
 */
function v1_get_option($atts=null, $content = null){
    $a = shortcode_atts( array(
        'type' => '',
        // ...etc
    ), $atts );
    
    return get_option( 'v1_theme_options' )[$a['type']];

}

add_shortcode('v1_get_option', 'v1_get_option'); 

/** 支持在widget中使用 */
add_filter('widget_text', 'do_shortcode');

?>