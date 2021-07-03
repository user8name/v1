<?php
/**
 * products category template
 */
$cid = get_query_var('cat');
$cat = get_category($cid);
$page = $_REQUEST["page"];
if ($page == null) {
    $page = 1;
}

$pagesize = 10;

global $wpdb;
$total = intval($wpdb->get_var($wpdb->prepare('SELECT COUNT(*) FROM `wp_products` WHERE `cid`=%d AND `isdel`=%d', [$cat->cat_ID,0])));
$rows = $wpdb->get_results($wpdb->prepare('SELECT `id`,`cid`,`cat`,`productname`,`description`,`seo_url`,`particlesize`,`mw` FROM `wp_products` WHERE `cid`=%d AND `isdel`=%d order by substring_index(cat,"-",-1)+0 asc limit ' . (($page - 1) * $pagesize) . ',' . $pagesize, [$cat->cat_ID,0]));
//$rows = $wpdb->get_results($wpdb->prepare("SELECT `id`,`cid`,`cat`,`productname`,`description`,`seo_url`,`particlesize`,`mw`,`jsontxt`->'$.Description' FROM `wp_products` inner join `wp_products_json` on `wp_products`.id=`wp_products_json`.productid WHERE `cid`=%d order by substring_index(cat,'-',-1)+0 asc limit " . (($page - 1) * $pagesize) . "," . $pagesize, $cat->cat_ID));
//var_dump($rows);
$cats = get_categories(array('hide_empty' => false, 'parent' => 3));
$bannerImage = trim(get_option("banner-pic-".$cid));
if($bannerImage==''){
    $bannerImage = '/images/inside_banner_products.png';
}
$pagenavstr='';
if ($total > $pagesize){
    $pager = new pager($total,$page,$pagesize); // $pager
    $pagenavstr = $pager->showpager();
}

get_header();
?>


 <!--banner start css html-->
 <div class="inside_banner" style="background:url(<?php echo get_template_directory_uri().$bannerImage ;?>);">
        <h2><?php echo $cat->cat_name; ?></h2>
        <p>Browse our wide selection of products for your research needs</p>
    </div>

    <div class="inside_nav">
        <div class="inside_nav_title"><?php get_breadcrumbs()?></div>
    </div>

    <!-- RESOURCE AREA -->
    <div class="container_center">
        <div class="product_title_name"><?php echo $cat->cat_name; ?></div>
        <div class="main_center_c2">

            <div class="inside_left">
                <div class="inside_left_body">
                <?php if ($cat->description != '') {echo $cat->description;}?>
                    <?php
                    $arg_ca=[
                        'type' => 'post',
                        'hide_empty'=>false,
                        'taxonomy'=>'category',
                        'orderby'=>'order',
                        'order' => 'ASC',
                        'parent'=>$cid,
                        'depth'=>1,            //类别深度。用于制表符缩进。默认值为0
                    ];
                    $cats=get_categories($arg_ca);

                    ?>
                    <?php if ($cats):?>
                            <?php foreach ($cats as $v):
                                $href= esc_url( get_term_link( $v->term_id, 'category' ) );
                                ?>
                                <div class="reg_services_links"><a href="<?php echo $href;?>"><?php echo $v->cat_name;?></a></div>

                            <?php endforeach;?>
                    <?php endif;?>

                <?php if (count($rows) > 0) {?>
                  <div class="table-list">
                        <table id="table-breakpoint">
                            <thead>
                                <tr>
                                    <th>CAT.NO.</th>
                                    <th>Product Name</th>
                                    <?php if($cid=='5'){
                                        ?>
                                        <th>Molecular Weight</th>
                                        <?php
                                    }else if($cid=='21'){
                                        ?>
                                        <th>Feature</th>
                                        <?php
                                    }else{
                                        ?>
                                        <th>Particle Size</th>
                                        <?php
                                    }
                                    ?> 
                                    <th>Inquiry</th>
                                </tr>
                            </thead>
                            <tbody>
            <?php
foreach ($rows as $obj) {
    $url = $obj->seo_url;
    if ($url == '') {
        $url = '/p/' . $obj->id . '/' .  sanitize_title(preg_replace( '/[^A-Za-z0-9\s\-]/', '-',$obj->productname)) . '/';
    }

    ?>
     <tr>
                                    <td>
                                    <?php echo $obj->cat ?>
                                    </td>
                                    <td><a href="<?php echo $url ?>" <?php if($cid==21){ echo 'rel="nofollow"';}?> ><?php echo $obj->productname?> </a></td>
                                    <?php if($cid=='5'){
                                        ?>
                                        <td><?php echo $obj->mw ?></td>
                                        <?php
                                    }else if($cid=='21'){
                                        ?>
                                       <td><?php
                                       $des = $obj->description;
                                           echo $des;
//                                       $res = "";
//                                       if(preg_match_all("/Pitch:(.*?)\n/",$des,$arr)){
//                                           $res.=$arr[0][0];
//                                       }
//                                       if(preg_match_all("/Surface feature:(.*?)\n/",$des,$arr)){
//                                        $res.=$arr[0][0];
//                                        }
//                                       echo $res;
                                       ?></td>
                                       <?php
                                    }else{
                                        ?>
                                       <td><?php echo $obj->particlesize ?></td>
                                        <?php
                                    }
                                    ?>
                                    
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
                <?php //echo v1_paging($page, $pagesize, $total); ?>
                <?php
                    echo $pagenavstr;
                ?>

          </div>
          <?php }?>
          <?php
} else {
    /**
     * no data
     */
    ?>
          <?php
}
?>

                </div>


            </div>

            <div class="inside_right">
                <div class="navsite">
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
                        <img src="<?php echo get_template_directory_uri(); ?>/images/adds-1.png"><img src="<?php echo get_template_directory_uri() ;?>/nosvg/n_add2.svg" height="44" style="padding: 15px 0 0 0;">
                    </p>
                                      <p>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/tel-1.png"><img src="<?php echo get_template_directory_uri() ;?>/nosvg/tel-black.svg" height="22" style="padding: 15px 0 0 0;">
                    </p>
                    <p>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/fax-1.png"><img src="<?php echo get_template_directory_uri() ;?>/nosvg/fax-black.svg" height="22" style="padding: 15px 0 0 0;">
                    </p>
                    <p>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/email-1.png">Email:
                        <a href="mailto:info@<?php echo do_shortcode('[v1_get_domain]'); ?>">info@<?php echo do_shortcode('[v1_get_domain]'); ?></a>
                    </p>

                </div>

            </div>

        </div>

    </div>
