<?php
/**
 * product template
 */
$vpid = get_query_var('vpid');
if (empty($vpid)) {
    status_header(404);
    get_template_part('404');
    die;
}
global $wpdb;
$product = $wpdb->get_row($wpdb->prepare('SELECT `id`,`cid`,`cat`,`productname`,`description`,`seo_title`,`seo_keywords`,`seo_description`,`seo_url`,`mw`,`particlesize`,`inherentviscosity`,`detail` FROM `wp_products` INNER JOIN `wp_products_json` ON `wp_products`.`id`= `wp_products_json`.`productid` WHERE `id`=%d AND `isdel`=%d', [$vpid,0]));
$cats = get_categories(array('hide_empty' => false, 'parent' => 3));
$js = null;
$cat = null;
$cid = 0;
if ($product != null) {
    $cid = $product->cid;
    $cat = get_category($cid);
    $js = json_decode($product->detail, true);

} else {
    status_header(404);
    get_template_part('404');
    die;
}
list( $req_uri ) = explode( '?', $_SERVER['REQUEST_URI'] );
$req_uri = rtrim($req_uri, '/');
$product_url='/p/' . $product->id . '/' .  sanitize_title(preg_replace( '/[^A-Za-z0-9\s\-]/', '-',$product->productname));
$query_string=$_SERVER["QUERY_STRING"]?"?".$_SERVER["QUERY_STRING"]:'';
if ($req_uri!=$product_url){
    header( "http/1.1 301 moved permanently" ) ;
    header( "location: ".home_url().$product_url.'/'.$query_string );
}

function custom_get_canonical_url($url){
    global $product;
    $url = home_url().'/p/' . $product->id . '/' .  sanitize_title(preg_replace( '/[^A-Za-z0-9\s\-]/', '-',$product->productname)) . '/';
    return  '<link rel="canonical" href="' . $url. '" />' . "\n";
}
add_filter('custom_get_canonical_url','custom_get_canonical_url');

function v1_page_title($title)
{
    global $product, $cat;
    $title['site'] = 'Matexcel';
    $seotitle = $product->seo_title;
    $customtitle = $product->productname;
    if ($product->particlesize != '') {
        $customtitle .= ', ' . $product->particlesize;
    } else if ($product->mw != '') {
        $customtitle .= ', ' . $product->mw;
    } else if ($product->inherentviscosity != '') {
        $customtitle .= ', ' . $product->inherentviscosity;
    }
    $customtitle .= ', ' . $cat->cat_name;
    $title['title'] = $seotitle ? $seotitle : $customtitle;
    return $title;
}
//在add_theme_support('title-tag');时使用
add_filter('document_title_parts', 'v1_page_title', 10, 1);

function v1_meta_description($description)
{
    global $product;
    $description = $product->description;
    return $description;
}
add_filter('v1_meta_description', 'v1_meta_description', 10, 3);

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
<div class="inside_banner products_bgimg">
        <h2><?php echo $product->productname; ?></h2>
        <p>Browse our wide selection of products for your research needs</p>
    </div>

    <div class="inside_nav">
        <div class="inside_nav_title"><?php get_breadcrumbs($cid)?></div>
    </div>

    <!-- RESOURCE AREA -->
    <div class="container_center">
        <div class="product_title_name"><?php echo $product->productname; ?></div>
        <div class="main_center_c2">

            <div class="inside_left">
                <div class="inside_left_body">
                <div class="table-responsive clearfix">
                                <table>
                                    <tr>
                                        <td colspan="2" style=" font-weight:bold; font-size:16px; color:#FFF; background-color:#164982;">Product Infomation</td>
                                    </tr>
                                    <?php foreach ($js as $key => $value) {
    if ($key == 'cid' || strtolower($key) == 'common name' || strtolower($key) == 'urltext' || strtolower($key)=='cas number' || strtolower($key)=='keywords') {
        continue;
    }

    ?>
                                    <tr>
                                        <td style="text-transform:capitalize"><?php echo $key ?></td>
                                        <?php if (strtolower($key)=='images'):?>
                                            <td>
                                                <?php
                                                $img = get_template_directory() . '/products-img/' . trim($value) . '.jpg';
                                                if (file_exists($img)) {
                                                    echo '<img src="'.get_template_directory_uri().'/products-img/' . trim($value) . '.jpg"  />';
                                                } else {
                                                    $img = get_template_directory() . '/products-img/' . trim($value) . '.png';
                                                    if (file_exists($img)) {
                                                        echo '<img src="'.get_template_directory_uri().'/products-img/' . trim($value) . '.png" />';
                                                    } else {
                                                        echo $value;
                                                    }
                                                }
                                                ?>
                                            </td>
                                        <?php else:?>
                                        <td><?php echo str_replace("\n",'<br />',$value) ?></td>
                                        <?php endif;?>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                        <td colspan="2"><img src="<?php echo get_template_directory_uri(); ?>/images/pdf.png" /> <a href="/pdf/?q=<?php echo $product->id ?>">Download Datasheet</a></td>
                                    </tr>
                                </table>
                            </div>


<div style="background: #f3f3f3; padding: 10px; display: block; color: #666; margin-top: 20px;"><img src="<?php echo get_template_directory_uri(); ?>/images/warning.png" style="vertical-align: bottom; padding-right: 15px;" />Our products/services are For Research Use Only. Not For Clinical Use!</div>

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
<input type="text" name="services" placeholder="Service & Products of Interest" value="(<?php echo $product->cat ?>)<?php echo $product->productname ?>" >
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


<?php get_footer();

?>