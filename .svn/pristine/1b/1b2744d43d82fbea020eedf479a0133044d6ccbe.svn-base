<?php
/**
 * header template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes();?> xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="<?php bloginfo( 'charset' );?>">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="<?php echo get_template_directory_uri() ;?>/favicon.ico" type="image/x-icon">
    <title><?php 
    $title = trim(wp_get_document_title());
    $title = str_replace('&#8211;','-',$title);
    echo $title;
    ?></title>
   <?php wp_head();
   echo apply_filters('custom_get_canonical_url','');
?>
<?php
$description = '';
$st = $_REQUEST["st"];
if ($st == null) {
    $st = '1';
}
global $email;
if (is_home() || is_front_page()) {
    $vpid = get_query_var('vpid');
    if (empty($vpid)) {
        $description = "Matexcel provides products and services in polymer, nanoparticle and other materials for worldwide customers from both academia and industry. ";
    } else {
        $description = apply_filters('v1_meta_description', $description);
        global $wpdb;
        $product_cid = $wpdb->get_row($wpdb->prepare('SELECT `id`,`cid` FROM `wp_products` WHERE `id`=%d', $vpid));
        if ($product_cid != null && $product_cid->cid==21) {
            echo '<meta name="robots" content="noindex,follow" />';
        }
    }
} else if (is_page()) {
    $description1 = get_post_meta(get_the_ID(), "description", true);
    $description2 = get_post_meta(get_the_ID(), "summary", true);
    $description = $description1 ? $description1 : $description2;
} elseif (is_single()) {
    $description1 = get_post_meta($post->ID, "description", true);
    $description2 = str_replace("\n", "", mb_strimwidth(strip_tags($post->post_content), 0, 200, "…", 'utf-8'));
    $description = $description1 ? $description1 : $description2;
} elseif (is_category()) {
    $description = get_option("seo-des-".get_query_var('cat'));
    $description =  $description?$description:category_description();
} elseif (is_tag()) {
    $description = tag_description();
}
$description = trim(strip_tags($description));
if ($description != '') {
    ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php }
$noindex= get_post_meta(get_the_ID(), "noIndex", true);
if ($noindex=='noindex') {
    echo '<meta name="robots" content="noindex,nofollow" />';
}
//由于调用顺序问题，filters无法执行
$pagenavstr = apply_filters('v1_nav_filter',null);
if($pagenavstr!='') echo $pagenavstr;

// function v1_nav_action($args )
// {
//     echo $args;
// }
// add_action( 'v1_nav_action', 'v1_nav_action', 10, 2 );

?>
<?php if($email != 'cdcd2013@outlook.com' && $email!= 'test@it.abace-biology.com'){?>

<!-- Google Tag Manager -->
<script>
dataLayer = [{'ip':'<?php echo get_ip(); ?>'}];
(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WH3M87D');</script>
<!-- End Google Tag Manager -->
<?php } ?>
    <script src="https://www.recaptcha.net/recaptcha/api.js?render=<?php echo CustomConfig::RECAPTCHAHTML;?>&hl=en" async defer></script>


</head>
<body <?php body_class();
?>>
<?php if($email != 'cdcd2013@outlook.com' && $email!= 'test@it.abace-biology.com'){?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WH3M87D&ip=<?php echo get_ip(); ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php } ?>
    <div class="hearder-line">
        <div class="hearder-top">
            <span class="adds" id="left"><div id="xload-header-add" data-file="<?php echo v1_get_template_directory_uri(); ?>/nosvg/ajax/14b2beb717e0f5dd" data-scroll="false"></div>
<script>$(function () { $("#xload-header-add").xload(); });</script></span>
            <span class="tel" id="left"><div id="xload-f1" data-file="<?php echo v1_get_template_directory_uri(); ?>/nosvg/ajax/14b2beb717e0f5d4" data-scroll="false"></div>
<script>$(function () { $("#xload-f1").xload(); });</script></span>
            <span class="fax" id="left"><div id="xload-header-fax" data-file="<?php echo v1_get_template_directory_uri(); ?>/nosvg/ajax/14b2beb717e0f5df" data-scroll="false"></div>
<script>$(function () { $("#xload-header-fax").xload(); });</script></span>
            <span class="email" id="left"><div id="xload-header-email" data-file="<?php echo v1_get_template_directory_uri(); ?>/nosvg/ajax/14b2beb717e0f5de" data-scroll="false"></div>
<script>$(function () { $("#xload-header-email").xload(); });</script></span>
<!--            <a href="<?php echo v1_get_option( array('type'=>'facebook')) ?>"><img src="<?php echo get_template_directory_uri() ;?>/images/f.png"></a>
            <a href="<?php echo v1_get_option( array('type'=>'twitter')) ?>"><img src="<?php echo get_template_directory_uri() ;?>/images/t.png"></a>
            <a href="<?php echo v1_get_option( array('type'=>'googleplus')) ?>"><img src="<?php echo get_template_directory_uri() ;?>/images/g.png"></a>
            <a href="<?php echo v1_get_option( array('type'=>'linkedin')) ?>"><img src="<?php echo get_template_directory_uri() ;?>/images/in.png"></a>
-->        </div>
    </div>

    <div class="site_nav">
        <div class="logo">
            <a href="/"><img src="<?php echo get_template_directory_uri() ;?>/images/logo.png" border="0"></a>
        </div>

        <div class="top_search">
            <form id="searchform" action="/" method="get">
            <select name="st" class="searchinput3">   
            <option value="1" <?php if($st=="1")echo 'selected'?>>Products</option>   
        <option value="2" <?php if($st=="2")echo 'selected'?>>Services</option>   
      </select>   
                <input name="s" id="s" type="text" class="searchinput2" placeholder="cat#, product name, abbr, or keywords" value="" required>
                <input id="searchbutton" type="button" class="searchButton2"><button type="submit" style="display:none;"></button>
            </form>
        </div>
        <div id='cssmenu'>
        <?php if ( has_nav_menu( 'top' ) ) : ?>
        <?php wp_nav_menu( array(
            'theme_location' => 'top',
            'menu_id'        => 'top-menu',
            'container' => 'ul'
            ) );
        ?>
        <?php endif; ?>
        </div>
    </div>
<script type="text/javascript">
        $(window).scroll(function () {
            var st = $(this).scrollTop();
            if (st > 100) {
                $(".logo img").attr("src","<?php echo get_template_directory_uri() ;?>/images/logo-1.png");
            }
            else {
			  
			   $(".logo img").attr("src","<?php echo get_template_directory_uri() ;?>/images/logo.png");
            }
        });
		
    </script>
