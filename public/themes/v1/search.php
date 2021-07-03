<?php
/**
 * search results template
 */
$s = get_search_query();
if (empty($s)) {
    echo 'Error';
    die;
}

$st = $_REQUEST["st"];
if ($st == null) {
    $st = '1';
}

$page = $_REQUEST["page"];
if ($page == null) {
    $page = 1;
}

$pagesize = 10;
$cats=null;

if ($st == '1') {
    global $wpdb;
//    $total = intval($wpdb->get_var($wpdb->prepare('SELECT COUNT(*) FROM `wp_products_search` WHERE MATCH(`searchtxt`) AGAINST("%s")', $s)));
    $total = intval($wpdb->get_var('SELECT COUNT(*) FROM `wp_products` WHERE `isdel`=0 AND `id` in('.$wpdb->prepare('SELECT productid FROM `wp_products_search` WHERE MATCH(`searchtxt`) AGAINST("%s")', $s).')'));

    $rows = $wpdb->get_results('SELECT `id`,`cid`,`cat`,`productname`,`description`,`seo_url`,`particlesize`,`mw` FROM `wp_products` WHERE `isdel`=0 AND `id` in (' . $wpdb->prepare('SELECT t.productid from (SELECT productid FROM `wp_products_search` WHERE MATCH(`searchtxt`) AGAINST("%s")) as t', $s) . ')  limit ' . (($page - 1) * $pagesize) . ',' . $pagesize);

    $cats = get_categories(array('hide_empty' => false, 'parent' => 3));
}else{
    $args = array(
        'posts_per_page' => 10,
        'numberposts' => 10,
        'offset' => 0,
        'category' => '',
        'orderby' => 'post_date',
        'order' => 'ASC',
        'include' => '',
        'exclude' => '',
        'meta_key' => '',
        'meta_value' => '',
        'post_type' => 'page',
        'post_mime_type' => '',
        'post_parent' => '80',
        'post_status' => 'publish',
        'suppress_filters' => true);
    
    $cats = get_posts($args);
}

get_header();?>

<!--banner start css html-->
<div class="inside_banner products_bgimg">
    <h2>Search Results for "<?php echo $s; ?>"</h2>
</div>

<div class="inside_nav">
    <div class="inside_nav_title"><?php get_breadcrumbs()?></div>
</div>

<div class="container_center">
        <div class="product_title_name">Search Results for "<?php echo $s;?>"</div>
        <div class="main_center_c2">

            <div class="inside_left">
                <div class="inside_left_body">

<?php if (have_posts() && $st == '2' || $st == '1' && count($rows) > 0): ?>

<?php else: ?>

        <?php _e('Nothing Found', 'v1');?>
        <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'twentyseventeen');?></p>
<?php
get_search_form();
?>

<?php
endif;
?>

<?php
if (have_posts() && $st == '2'):
/* Start the Loop */
    while (have_posts()): the_post();
        ?>
		    <div class="cell-md-12 searchunit">
		<h4> <a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
		<p><?php the_excerpt()?></p>
		</div>

				        <?php

    endwhile; // End of the loop.
endif;?>
<?php
if ($st == '1' && count($rows) > 0) {
    ?>
                     <div class="table-list">
                        <table id="table-breakpoint">
                            <thead>
                                <tr>
                                    <th>CAT.NO.</th>
                                    <th>Product Name</th>
                                    <th>Detail</th>
                                    <th>Inquiry</th>
                                </tr>
                            </thead>
                            <tbody>
            <?php
foreach ($rows as $obj) {
    $url = $obj->seo_url;
    if ($url == '') {
        $url = '/p/' . $obj->id . '/' . sanitize_title(preg_replace( '/[^A-Za-z0-9\s\-]/', '-',$obj->productname)) . '/';
    }

    ?>
     <tr>
                                    <td>
                                    <?php echo $obj->cat ?>
                                    </td>
                                    <td><a href="<?php echo $url ?>"><?php echo $obj->productname ?></a></td>
                                    <td><?php
                                    if($obj->particlesize!=""){
                                        echo 'Particle Size: '.$obj->particlesize;
                                    }else  if($obj->mw!=""){
                                        echo 'Molecular Weight: '.$obj->mw;
                                    }
                                    else{
                                       
                                    }
                                     
                                     ?></td>
                                    <td><a href="/inquiry/?q=(<?php echo $obj->cat ?>)<?php echo $obj->productname ?>" class="inquiry_btn">Inquiry</a></td>

                                </tr>

            <?php
}
    ?>
         </tbody>
                        </table>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#table').basictable();
                                $('#table-breakpoint').basictable({
                                    breakpoint: 768
                                });
                            });
                        </script>
                    </div>
          <?php if ($total > $pagesize) {?>
          <div class="pagenav">
          <?php //echo v1_paging($page, $pagesize, $total, '', false, 's=' . urlencode($s) . '&page'); ?>
          <?php
                    $pager = new pager($total,$page,10,'?st='.$st.'&s=' . urlencode($s) . '&page='); // $pager
                    echo $pager->showpager();
                ?>
          </div>
          <?php }?>
<?php }?>




</div>
</div>

<div class="inside_right">
    <div class="navsite">
    <?php if($st=="1"){ ?>
        <h2>Product Categories</h2>
        <ul>
        <?php foreach ($cats as $obj) {
    if (get_option("cat-is-show-$obj->term_id") != '1') {
        continue;
    }

    ?>
          <li>
          <a href="<?php echo get_category_link($obj->term_id) ?>">• <?php echo $obj->name ?></a>
            </li>

    <?php }?>

        </ul>
    <?php }else{ ?>
        <h2>Servcie Categories</h2>
                    <ul>
                    <?php foreach ($cats as $obj) {
    setup_postdata($obj);
    ?>
                      <li>
                      <a href="<?php echo get_permalink($obj->ID) ?>">• <?php echo $obj->post_title ?></a>
                        </li>

                <?php
}
wp_reset_postdata();
?>

                    </ul>

    <?php  } ?>

    </div>

<div class="navsite_right">
                    <a href="/online-order/"><img src="<?php echo get_template_directory_uri(); ?>/images/left_img.png" /></a>
                    <div class="right">
                        <span>
							<a href="/online-order/">Place the Order</a>
						</span>
                    </div>
                </div>

                <div class="navsite_right">
                    <a href="/order-faqs/"><img src="<?php echo get_template_directory_uri(); ?>/images/left_img_01.png" /></a>
                    <div class="right">
                        <span>
							<a href="/order-faqs/">FAQ</a>
						</span>
                    </div>
                </div>

    <div class="right_contact">
        <h2>Contact Us</h2>
        <p>
            <img src="<?php echo get_template_directory_uri(); ?>/images/adds-1.png"><img src="<?php echo get_template_directory_uri() ;?>/nosvg/n_add4.svg" height="22" style="padding: 15px 0 0 0;">
        </p>
        <p>
            <img src="<?php echo get_template_directory_uri(); ?>/images/tel-1.png">USA: <?php echo v1_get_option(array('type' => 'usatel1')) ?>
        </p>
        <p>
            <img src="<?php echo get_template_directory_uri(); ?>/images/fax-1.png">Fax: <?php echo v1_get_option(array('type' => 'fax1')) ?>
        </p>
        <p>
            <img src="<?php echo get_template_directory_uri(); ?>/images/email-1.png">Email:
            <a href="mailto:info@<?php echo do_shortcode('[v1_get_domain]'); ?>">info@<?php echo do_shortcode('[v1_get_domain]'); ?></a>
        </p>

    </div>

</div>

</div>

</div>

<?php get_footer();
