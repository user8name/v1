<?php
/**
 * Template Name: Inquiry
 */
$q = $_GET["q"];
get_header();?>

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
	<div class="inside_banner inquiry_bgimg">
		<h2><?php the_title(); ?></h2>
		<p style="line-height:45px;"><?php echo get_post_meta(get_the_ID(), "bannerText", true);?></p>
	</div>

	<div class="inside_nav">
		<div class="inside_nav_title"><?php get_breadcrumbs() ?></div>
	</div>

<div class="container_center inquiry_center">
		<div class="inquiry_title"><?php the_title() ?></div>
		<div class="main_center_c2">

			<div class="inside_left">

				<form id="formID" name="inquiryform" class="Inquiry_form" method="post" action="/pub/" autocomplete="off">
					<ul>
						<li>
							<label>* Name</label>
							<input type="text" name="name1" class="validate[required]" placeholder="Name">
						</li>

						<li>
							<label>* Phone Number</label>
							<input type="text" name="phone" class="validate[required]" placeholder="Phone Number">
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
							<input type="text" name="services" class="validate[required]" placeholder="Service & Products of Interest" value="<?php echo $q ?>" >
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
				<h2>Contact Us</h2>
				<p><img src="<?php echo get_template_directory_uri() ;?>/nosvg/tel-black.svg" height="22" style="padding: 15px 0 0 0;"></p>
				<p><img src="<?php echo get_template_directory_uri() ;?>/nosvg/fax-black.svg" height="22" style="padding: 15px 0 0 0;"></p>
				<p>Address: <img src="<?php echo get_template_directory_uri() ;?>/nosvg/n_add4.svg" height="22" style="padding: 15px 0 0 0;"></p>
				<p>Email:<a href="mailto:info@<?php echo do_shortcode('[v1_get_domain]'); ?>">info@<?php echo do_shortcode('[v1_get_domain]'); ?></a></p>
				<p style="text-align:center;"><img src="<?php echo get_template_directory_uri(); ?>/images/product-inquiry-pic.jpg" /></p>
				<p>Welcome! For price inquiries, please feel free to contact us through the form on the left side. We will get back to you as soon as possible.</p>
	
			</div>
		</div>

	</div>



<?php get_footer();?>
