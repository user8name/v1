<?php
/**
 * others category
 */
$cid = get_query_var('cat');
$cat = get_category($cid);
$page = $_REQUEST["page"];
if ($page == null) {
    $page = 1;
}

$pagesize = 10;
$cats = get_categories(array('hide_empty' => false, 'parent' => 1));
$p_cats = get_categories(array('hide_empty' => false, 'parent' => $cid));
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
<div class="inside_banner services_bgimg">
        <h2><?php echo $cat->cat_name; ?></h2>
        <p>We provide the most professional service in materials science</p>
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
                
    <?php if($cid==3):
        foreach ($p_cats as $pk=>$pv):

        ?>
            <div class="reg_services_links"><a href="<?php echo esc_url( get_term_link( $pv->term_id, 'category' ) );?>"><?php echo $pv->cat_name?></a></div>

    <?php
    endforeach;
    endif;?>
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
<input type="text" name="services" placeholder="Service & Products of Interest" value="<?php echo $cat->cat_name; ?>" >
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
                    <h2>Servcie Categories</h2>
                    <ul>
                    <?php foreach ($cats as $obj) {

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
