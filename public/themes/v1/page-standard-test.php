<?php

/**
 * Template Name: standard test
 *
 */
list( $req_uri ) = explode( '?', $_SERVER['REQUEST_URI'] );
$req_uri = rtrim($req_uri, '/');
$product_url=get_permalink(get_the_ID());

$product_url=str_replace(home_url(),'',$product_url);

$product_url = rtrim($product_url, '/');

$query_string=$_SERVER["QUERY_STRING"]?"?".$_SERVER["QUERY_STRING"]:'';
if ($req_uri!=$product_url){
    status_header(404);
    get_template_part('404');
    die;
}
$curpost = get_post();
$bannerImage = trim(get_post_meta($curpost->ID, "bannerImage", true));
if ($bannerImage == '') {
    $bannerImage = '/images/inside_banner_services.png';
}
$seotitle = trim(get_post_meta($curpost->ID, "seoTitle", true));
$curpost = get_post();
$postparent = get_post($curpost->post_parent);

function v1_page_title($title)
{

    global $seotitle,$postparent,$curpost;
    $title['title'] = $seotitle ? $seotitle :$curpost->post_title;
    if(!is_null($postparent->post_title) && $postparent->ID!=$curpost->ID){
        $title['title'].=', '.$postparent->post_title;
    }
    return $title;
}
add_filter('document_title_parts', 'v1_page_title', 10, 1);
$ty=isset($_GET['ty'])?$_GET['ty']:1;
$val=isset($_GET['val'])?$_GET['val']:'';


$where='';
if ($ty && $val){
    switch ($ty){
        case 1:
            $where=' and `astm_designation` LIKE "%'.trim($val).'%"';
            break;
        case 2:
            $where=' and `objective`  LIKE "%'.trim($val).'%"';
            break;
        case 3:
            $where=' and `sub_classification` LIKE "%'.trim($val).'%"';
            break;
        case 4:
            $where=' and `item` LIKE "%'.trim($val).'%"';
            break;
    }

}

$page = $_REQUEST["pages"];

if ($page == null) {
    $page = 1;
}
global $wpdb;
$pagesize = 50;
$total=intval($wpdb->get_var('SELECT COUNT(1) FROM `'.$wpdb->prefix.'standard_test` WHERE `isdel`=0 '.$where.' order by objective'));
$rows = $wpdb->get_results('SELECT * FROM `'.$wpdb->prefix.'standard_test` WHERE `isdel`=0 '.$where.' order by objective limit ' . (($page - 1) * $pagesize) . ',' . $pagesize);



$new_rows=[];
$custom_1=[];
foreach ($rows as $k=>$v){
    $custom_1[$v->objective]['c']+=1;
    $custom_1[$v->objective][$v->sub_classification]['c']+=1;
    $new_rows[$v->objective][$v->sub_classification][]=$v;
}


get_header();
?>




<script type="text/javascript">
    jQuery(document).ready(function () {
        // binds form submission and fields to the validation engine
        jQuery("#formID").validationEngine();

        $("#formID").bind("jqv.form.validating", function (event) {
            $("#hookError").html("")
        })
        $("#formID").bind("jqv.form.result", function (event, errorFound) {
            if (errorFound) $("#hookError").append("There is some problems with your form");
        })
    });
</script>

<!--banner start css html-->
<div class="inside_banner" style="background:url(<?php echo get_template_directory_uri() . $bannerImage; ?>);">
    <h2><?php the_title();?></h2>
    <p><!--?php echo get_post_meta(get_the_ID(), "bannerText", true); ?>-->We provide the most professional service in materials science</p>
</div>

<div class="inside_nav">
    <div class="inside_nav_title"><?php get_breadcrumbs()?></div>
</div>

<div class="container_center">
    <div class="product_title_name"><?php the_title();?></div>
    <div class="main_center_c2">


        <div class="inside_left">
            <div class="inside_left_body">
                <div class="ser_search">
                    <form id="searchform" action="<?php echo get_permalink(get_the_ID()) ?>" method="get">
                        <select name="ty" class="ser_search1">
                            <option value="1" <?php if ($ty==1):?> selected=""<?php endif;?>>ASTM Designation</option>
                            <option value="2" <?php if ($ty==2):?> selected=""<?php endif;?>>Objective</option>
                            <option value="3" <?php if ($ty==3):?> selected=""<?php endif;?>>Sub Classification</option>
                            <option value="4" <?php if ($ty==4):?> selected=""<?php endif;?>>Item</option>
                        </select>
                        <input name="val" type="text" required="" class="ser_search2" placeholder="Search for..." value="<?php echo $val?>" size="50">
                        <button type="submit" style="border: 0;
                            cursor: pointer;
                            height: 35px;
                            width: 45px;
                            padding: 0 0 0 5px;
                            outline-style: none;
                            border-radius: 5px;
                            float: left;background: url(<?php echo get_template_directory_uri() ;?>/images/search.png) center center no-repeat #164982;"></button>
                    </form>
                </div>

                <table cellspacing="0" cellpadding="0" class="servicesother">
                    <tbody>
                    </tbody><thead>
                    <tr>
                        <th width="15%">Objective</th>
                        <th width="15%">Sub Classification</th>
                        <th width="15%">ASTM Designation</th>
                        <th width="55%">Item</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    foreach ($new_rows as $kk=>$vv):?>
                    <tr>
                        <td rowspan="<?php echo $custom_1[$kk]['c'];?>"><?php echo $kk; ?></td>
                        <?php
                        $c=0;
                        foreach ($vv as $kk1=>$vv1):?>
                            <?php if ($c==0):?>
                                <td rowspan="<?php echo $custom_1[$kk][$kk1]['c'];?>"><?php echo $kk1;?></td>
                        <?php else:?>
                                <tr>
                                <td rowspan="<?php echo $custom_1[$kk][$kk1]['c'];?>"><?php echo $kk1;?></td>
                        <?php endif;?>

                            <?php  $a=0; foreach ($vv1 as $kk2=>$vv2):

                                if ($a==0):?>
                                    <td><?php echo $vv2->astm_designation;?></td>
                                    <td><?php echo $vv2->item;?></td>
                                    </tr>
                                    <?php else:?>
                                    <tr><td><?php echo $vv2->astm_designation;?></td>
                                        <td><?php echo $vv2->item;?></td>
                                    </tr>
                                    <?php endif;?>

                            <?php $a++;
                            endforeach;?>
                        <?php endforeach;?>
                    <?php endforeach;?>
                    </tbody>
                </table>
                <?php if ($total > $pagesize) {?>
                <div class="pagenav">
                    <?php
                    if ($val!=''){
                        $pager = new pager_standard($total,$page,10,'?ty='.$ty.'&val=' . urlencode($val) . '&pages=',3,$pagesize); // $pager

                    }else{
                        $pager = new pager_standard($total,$page,10,'',3,$pagesize); // $pager

                    }

                    echo $pager->showpager();
                    ?>
                </div>

                <?php }?>
				
				<div style="background: #f3f3f3; padding: 10px; display: block; color: #666; margin-top: 20px;">Our products/services are For Research Use Only. Not For Clinical Use!</div>
<div class="inside_left">
<div class="online-inquiry-title">Online Inquiry</div>
<form id="formID" name="inquiryform" class="Inquiry_form" method="post" action="/pub/" autocomplete="off">
<ul>
<li>
<label>Name</label>
<input type="text" name="name1"  placeholder="Name">
</li>
<li>
<label>Phone Number</label>
<input type="text" name="phone" placeholder="Phone Number">
</li>
<li>
<label>* Email</label>
<input type="email" name="email" class="validate[required,custom[email]]" placeholder="Email">
</li>
<li>
<label>Address</label>
<input type="text" name="address" placeholder="Address">
</li>
<li>
<label>* Service & Products of Interest</label>
<input type="text" name="services" placeholder="Service & Products of Interest" value="<?php the_title();?>" >
</li>
<li style="width:100%;">
<label>Project Description</label>
<textarea name="description" cols="40" rows="4" placeholder="Project Description"></textarea>
</li>
    <script>
        function onClickSubmit(e) {
            if ((typeof grecaptcha) != 'undefined'){
                grecaptcha.ready(function() {
                    grecaptcha.execute('<?php echo CustomConfig::RECAPTCHAHTML;?>', {action: 'submit'}).then(function(token) {
                        // Add your logic to submit to your backend server here.
                        $('#g-recaptcha-responseid').val(token)

                        if($('#formID').validationEngine('validate')){
                            $('#formID').submit();
                        }
                    });
                });
            }
        }
    </script>
    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-responseid">
<li style="margin-top:20px;">
<button class="submit" type="button" onclick="onClickSubmit(this)">Send</button> <input type="hidden" name="act" value="send">
</li>
</ul>
</form>
</div>

<div class="inside_right">
<div class="online-right">
<p style="text-align:center;"><img src="<?php echo get_template_directory_uri(); ?>/images/product-inquiry-pic.jpg" /></p>
<p>Welcome! For price inquiries, please feel free to contact us through the form on the left side. We will get back to you as soon as possible.</p>
</div>
</div>

              </div>
            </div>


            <div class="inside_right">


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


<?php get_footer();?>
