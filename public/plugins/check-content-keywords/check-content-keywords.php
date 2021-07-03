<?php

/*
Plugin Name: check-content-keywords
Plugin URI: 
Version:V1.01
Author: zhy
Author URI:
Description:Check the service page for specific keywords
*/


global $words;
if(is_admin()){
	$act = strrchr($_SERVER['PHP_SELF'], "/");
	if($act=="/post-new.php"||$act=="/post.php"){
        $GLOBALS['$words']=file_get_contents('http://dellogsys.cd-web.org/api/getipblacklist.ashx?token=awq*L*U43tDkAZd'); 
	}else{
		$GLOBALS['$words']="";
	}
}else{
	$GLOBALS['$words']="";
}


add_action( 'admin_print_footer_scripts', 'duplicate_titles_enqueue_scripts', 100 );
function duplicate_titles_enqueue_scripts() {
?>
	<script>
	jQuery(function($){	
	var str=<?php if($GLOBALS['$words']==""){echo '""';}else{echo($GLOBALS['$words']);};?>;
	$("#post").prepend('<input type="hidden" id="compulsoryinput" name="compulsoryinput" value="false">')
	$("#publishing-action").append('<span class="button button-primary button-large" id="Subm">Submit</span>');
	$("#poststuff").after('<span class="button button-primary button-large" id="compulsory">compulsory Submit</span>')
	$("#postdivrich").after("<div class='updated updateword' style='display:none;border:1px solid red'><p style='color:red' ></p></div>")
	$("#poststuff").before("<div class='updated updateword' style='display:none;border:1px solid red'><p style='color:red' ></p></div>")
	$("#publish").hide();
	$("#publishing-action #Subm").click(function () {
	var cons=$("#post #title").val()+$("#post #content").val()+$("#metaTitle").val()+$("#metaKeyword").val()+$("#metaDescription").val()+$("#bannerImg").val()+$("#coverImg").val()+$("#bannerTitle").val()+$("#bannerText").val();
	var kstr='';
	for(var i=0;i<str.msg.length;i++){
		var std=str.msg[i];
        var nstr = cons.toLowerCase().indexOf(std.toLowerCase());     
        if(nstr != -1){
        	kstr=kstr+std+' | ';
        }
    }
    if (kstr=='') {
    	$(".updateword").stop(true).animate({"height":"hide",})
	    $(".updateword p").html('');
	    $("#publish").click();
    } else{
    	kstr=kstr+"<br>"+"--These words are not allowed to be saved, please check title、content、Page Custom Fields!";
	    $(".updateword").stop(true).animate({"height":"show",});
	    $(".updateword p").html(kstr);
    }
	})
	$("#compulsory").click(function () {
		$("#compulsoryinput").val("true");
		$("#publish").click();
	})
	});
	</script>
<?php
} 
function KeyWordsFilter($data , $postarr ) {
	$compulsory = $_REQUEST['compulsoryinput'];
	$word=json_decode(file_get_contents('http://dellogsys.cd-web.org/api/getipblacklist.ashx?token=awq*L*U43tDkAZd'));
	$word=$word->msg;
	$num=count($word);
	$strs=$data['post_title'].$data['post_content'].$postarr['metaTitle'].$postarr['metaKeyword'].$postarr['metaDescription'].$postarr['bannerImg'].$postarr['coverImg'].$postarr['bannerTitle'].$postarr['bannerText'];
	$str=array();
    for($i=0;$i<$num;$i++){
        $new_str = stripos($strs,$word[$i]);
        if($new_str){
        	array_push($str,$word[$i]);
        }
    }
    if($compulsory=="false"){
    	if(empty($str)){
	    	return $data;
	    }else{
	    	$str=json_encode($str);
			return false;
	    }
    }else{
    	return $data;
    }
    
}

add_filter( 'wp_insert_post_data', 'KeyWordsFilter', 99, 2 );


define('plugin_ROOT_URL', rtrim(plugin_dir_url(__FILE__), '/'));
function my_add_pages() {
    add_menu_page('check-content-keywords', 'check keywords', 'manage_options', __FILE__, 'my_toplevel_page', plugin_ROOT_URL.'/check.svg');
}
function my_toplevel_page() { 
	global $wpdb;
	$table_prefix = $wpdb->prefix;
	$a=$wpdb->query('SHOW TABLES LIKE "'.$table_prefix.'products"');
    echo '
    <div class="wrap">
    <h2>check keywords</h2>
    <p style="font-size: 15px;">Click to check the page&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="spinner spinnerpage"></span><a href="javascript:;" id="checkbtn">start</a></p>
    <div id="resources"></div>
    <p id="say"></p>
    ';
    if($a){
    	echo '
    	<p style="font-size: 15px;">Click to check the product&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="spinner spinnerproduct"></span><a href="javascript:;" id="checkproduct">start</a></p>
        Product Url Rule：<input class="" id="urlrule" type="text" name="" value="home_url().\'/\'.sanitize_title(preg_replace( \'/[^A-Za-z0-9\\-\\s\\-]/\', \'\', strip_tags($v[\'productname\']))) .\'.html\'" placeholder="Please input the URL rule " required="">
	    <div id="product"></div>
	    <p id="productsay"></p>
    	';
    };
    echo '
    </div>
    <style>
    	#urlrule{width:60%;}
    	.spinner{float:none;margin: 0px 10px 0;}
    	table td{border: 1px solid #cacaca;padding:10px;}
    	table { border-collapse: collapse;margin: 1.25em 0 0;width: 100%;border: 1px solid #cacaca;}
    </style>
    ';
}
add_action('admin_menu', 'my_add_pages');

add_action( 'admin_print_footer_scripts', 'checkajax', 100 );
function checkajax() {
?>
	<script>
	jQuery(function($){	
		$("#checkbtn").click(function () {
			$(".spinnerpage").css({'visibility': 'unset',})
			$.ajax({
                type:'post',
                url:ajaxurl,
                data:{'action':'checktext'},
                cache:false,
                dataType:'json',
                success:function(result){
                	var table=[];
                	if(result.length==0){
                		$('#resources').html('<p style="color:#0073aa;">Found '+result.length+' resources</p>');
                	}else{
                		$('#resources').html('<p style="color:#0073aa;">Found '+result.length+' resources&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" id="export">page export</a></p>');
						for(var i=0;i<result.length;i++){
						 table[i]="<tr><td>"+result[i]['title']+"</td><td>"+result[i]['url']+"</td><td>"+result[i]['keyword']+"</td></tr>";
						}
                    	$('#say').html('<table id="tableExcel" width="100%" border="1" cellspacing="0" cellpadding="0" style="border: 1px solid #cacaca;"><tr><td colspan="5" align="center">Page List</td></tr><tr><td style="width:30%;">title</td><td>url</td><td>keywords</td></tr>'+table.join("")+'</table>');
                	}
                	$(".spinnerpage").css({'visibility': 'hidden',});
                	
                },
                error:function(data){
                    alert('erro');
                    $(".spinnerpage").css({'visibility': 'hidden',});
                }
            });  
        
	    })
	    $("#checkproduct").click(function () {
	    	$(".spinnerproduct").css({'visibility': 'unset',});
			$.ajax({
                type:'post',
                url:ajaxurl,
                data:{'action':'checkproducts','urlrule':$("#urlrule").val()},
                cache:false,
                dataType:'json',
                success:function(result){
                	var table=[];
                	if(result.length==0){
                		$('#product').html('<p style="color:#0073aa;">Found '+result.length+' resources</p>');
                	}else{
                		$('#product').html('<p style="color:#0073aa;">Found '+result.length+' resources&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" id="product_export">product export</a></p>');
						for(var i=0;i<result.length;i++){
						 table[i]="<tr><td>"+result[i]['title']+"</td><td>"+result[i]['url']+"</td><td>"+result[i]['keyword']+"</td></tr>";
						}
                    	$('#productsay').html('<table id="productExcel" width="100%" border="1" cellspacing="0" cellpadding="0" style="border: 1px solid #cacaca;"><tr><td colspan="5" align="center">Product List</td></tr><tr><td style="width:30%;">title</td><td>url</td><td>keywords</td></tr>'+table.join("")+'</table>');
                	}
                	$(".spinnerproduct").css({'visibility': 'hidden',});
                },
                error:function(data){
                    alert('erro');
                    $(".spinnerproduct").css({'visibility': 'hidden',});
                }
            });  
        
	    })
	    $("#wpbody .wrap").on('click', '#export', function(e) {
			method5('tableExcel')
	    })
	    $("#wpbody .wrap").on('click', '#product_export', function(e) {
			method5('productExcel')
	    })
	    var idTmr;
	    function getExplorer() {
	      var explorer = window.navigator.userAgent ;
	      //ie
	      if (explorer.indexOf("MSIE") >= 0) {
	        return 'ie';
	      }
	      //firefox
	      else if (explorer.indexOf("Firefox") >= 0) {
	        return 'Firefox';
	      }
	      //Chrome
	      else if(explorer.indexOf("Chrome") >= 0){
	        return 'Chrome';
	      }
	      //Opera
	      else if(explorer.indexOf("Opera") >= 0){
	        return 'Opera';
	      }
	      //Safari
	      else if(explorer.indexOf("Safari") >= 0){
	        return 'Safari';
	      }
	    }
	    function method5(tableid) {
	      if(getExplorer()=='ie')
	      {
	        var curTbl = document.getElementById(tableid);
	        var oXL = new ActiveXObject("Excel.Application");
	        var oWB = oXL.Workbooks.Add();
	        var xlsheet = oWB.Worksheets(1);
	        var sel = document.body.createTextRange();
	        sel.moveToElementText(curTbl);
	        sel.select();
	        sel.execCommand("Copy");
	        xlsheet.Paste();
	        oXL.Visible = true;
	        try {
	          var fname = oXL.Application.GetSaveAsFilename("Excel.xls", "Excel Spreadsheets (*.xls), *.xls");
	        } catch (e) {
	          print("Nested catch caught " + e);
	        } finally {
	          oWB.SaveAs(fname);
	          oWB.Close(savechanges = false);
	          oXL.Quit();
	          oXL = null;
	          idTmr = window.setInterval("Cleanup();", 1);
	        }
	      }
	      else
	      {
	        tableToExcel(tableid);
	      }
	    }
	    function Cleanup() {
	      window.clearInterval(idTmr);
	      CollectGarbage();
	    }
	    var tableToExcel = (function() {
	      var uri = 'data:application/vnd.ms-excel;base64,',
	          template = '<html><head><meta charset="UTF-8"></head><body><table>{table}</table></body></html>',
	          base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) },
	          format = function(s, c) {
	            return s.replace(/{(\w+)}/g,
	                function(m, p) { return c[p]; }) }
	      return function(table, name) {
	        if (!table.nodeType) table = document.getElementById(table)
	        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
	        window.location.href = uri + base64(format(template, ctx))
	      }
	    })()
	});
	</script>
<?php
} 

	

function checktext(){
	$word=json_decode(file_get_contents('http://dellogsys.cd-web.org/api/getipblacklist.ashx?token=awq*L*U43tDkAZd'));
	$word=$word->msg;
	global $wpdb;
	$table_prefix = $wpdb->prefix;
	$results = $wpdb->get_results("SELECT ID,post_title,post_content,guid,post_type,post_status FROM ".$table_prefix."posts");
	$results = json_encode($results);
	$results = json_decode($results,true);
	$custom_fields = $wpdb->get_results("SELECT post_id,meta_key,meta_value FROM ".$table_prefix."postmeta");
	$custom_fields = json_encode($custom_fields);
	$custom_fields = json_decode($custom_fields,true);
	$fields = [];
	foreach ($custom_fields as $key => $value) {
	    $fields[$value['post_id']][$value['meta_key']] = $value['meta_value'];
	}
	$list=array();
	for($i=0;$i<count($results);$i++){
		$results[$i]['post_content']=htmlspecialchars($results[$i]['post_content']);
		$seodes=$fields[$results[$i]['ID']];
		$strs=$results[$i]['post_title'].$results[$i]['post_content'].$seodes['metaTitle'].$seodes['metaKeyword'].$seodes['metaDescription'].$seodes['bannerImg'].$seodes['coverImg'].$seodes['bannerTitle'].$seodes['bannerText'];
		$num=count($word);
		$str=array();
	    for($j=0;$j<$num;$j++){
	        $new_str = stripos($strs,$word[$j]);
	        if($new_str){
	        	array_push($str,$word[$j]);
	        }
	    }
	    if(empty($str)){
//	    	echo 'Pass';
	    }else{
	    	$results[$i]['keyword']=$str;
	    	array_push($list,$results[$i]);
//			echo 'Has';
	    }
	}

	$lists2=array();
	foreach ($list as $k2 => $v2) {
	    if($v2['post_type']=='page'&&$v2['post_status']=='publish'){
	    	$url=get_page_link( $v2['ID'] );
	    	$lists['title']=$v2['post_title'];
	    	$lists['url']=$url;
	    	$lists['keyword']=$v2['keyword'];
	    	array_push($lists2,$lists);
	    }
	    if($v2['post_type']=='post'&&$v2['post_status']=='publish'){
	    	$url=get_page_link( $v2['ID'] );
	    	$lists['title']=$v2['post_title'];
	    	$lists['url']=$url;
	    	$lists['keyword']=$v2['keyword'];
	    	array_push($lists2,$lists);
	    }
//	    if($v2['post_type']=='revision'){
//	    	$url=get_page_link( $v2['ID'] );
//          $lists['title']=$v2['post_title'];
//	    	$lists['url']=$url;
//	    	array_push($lists2,$lists);
//	    }
//	    if($v2['post_type']=='nav_menu_item'){
//	    	$url=get_page_link( $v2['ID'] );
//          $lists['title']=$v2['post_title'];
//	    	$lists['url']=$url;
//	    	array_push($lists2,$lists);
//	    }
	    
	}
	$lists2 = json_encode($lists2);
	echo $lists2;
	wp_die();	
}	

add_action('wp_ajax_checktext', 'checktext');
add_action('wp_ajax_nopriv_checktext', 'checktext' );

function checkproducts(){
	$word=json_decode(file_get_contents('http://dellogsys.cd-web.org/api/getipblacklist.ashx?token=awq*L*U43tDkAZd'));
	$word=$word->msg;
	global $wpdb;
	$table_prefix = $wpdb->prefix;
	$a=$wpdb->query('SHOW TABLES LIKE "'.$table_prefix.'products"');
    if(!$a){
    	$a=array();
    	echo json_encode($a);
    	wp_die();
    }
	$urls=$_POST['urlrule'];
    $urlrule = stripslashes($urls).";";
	$results = $wpdb->get_results("SELECT * FROM ".$table_prefix."products");
	$results = json_encode($results);
	$results = json_decode($results,true);
	$list=array();
	for($i=0;$i<count($results);$i++){
		$res=array_values($results[$i]);
		$strs='';
		for($j=0;$j<count($res);$j++){
		  $strs=$strs.$res[$j];
	    }
		$num=count($word);
		$str=array();
	    for($t=0;$t<$num;$t++){
	        $new_str = stripos($strs,$word[$t]);
	        if($new_str){
	        	array_push($str,$word[$t]);
	        }
	    }
	    if(empty($str)){
//	    	echo 'Pass';
	    }else{
	    	$results[$i]['keyword']=$str;
	    	array_push($list,$results[$i]);
//			echo 'Has';
	    }
	}
	
	$lists2=array();
	foreach ($list as $k => $v) {
		if($urls==''){
    	    $url=home_url().'/'.sanitize_title(preg_replace( '/[^A-Za-z0-9\-\s\-]/', '', strip_tags($v['productname']))) .'.html';
		}else{
			$url=eval("return $urlrule");
		}
    	$lists['title']=$v['productname'];
    	$lists['url']=$url;
    	$lists['keyword']=$v['keyword'];
    	array_push($lists2,$lists);
	}
	
	$lists2 = json_encode($lists2);
	echo $lists2;
	wp_die();

}
add_action('wp_ajax_checkproducts', 'checkproducts');
add_action('wp_ajax_nopriv_checkproducts', 'checkproducts' );


?>