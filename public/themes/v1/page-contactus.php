<?php
/**
 * Template Name: Contact Us
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
	<div class="inside_banner about_bgimg">
		<h2><?php the_title(); ?></h2>
		<p><?php echo get_post_meta(get_the_ID(), "bannerText", true);?></p>
	</div>

	<div class="inside_nav">
		<div class="inside_nav_title"><?php get_breadcrumbs() ?></div>
	</div>

	<!-- Contact Us -->

	<div class="container_center">
		<div class="container_bg_contact">

			<div class="contact_us">
				<h2>Our Contacts</h2>
				<p>
					<img src="<?php echo get_template_directory_uri() ;?>/images/adds.png"><span id="xload-contact-add" data-file="<?php echo get_template_directory_uri() ;?>/nosvg/ajax/14b2beb717e0f5dd" data-scroll="false"></span>
<script>$(function () { $("#xload-contact-add").xload(); });</script></a></a>
				</p>
				<p>
					<img src="<?php echo get_template_directory_uri() ;?>/images/tel.png"><span id="xload-f3" data-file="<?php echo get_template_directory_uri() ;?>/nosvg/ajax/14b2beb717e0f5d4" data-scroll="false"></span>
<script>$(function () { $("#xload-f3").xload(); });</script></a>
				</p>
				<!--<p style="padding-left:30px;">Europe: <?php echo v1_get_option(array('type' => 'europetel1')) ?></p>-->
				<p>
					<img src="<?php echo get_template_directory_uri() ;?>/images/fax.png"><span id="xload-contact-fax" data-file="<?php echo get_template_directory_uri() ;?>/nosvg/ajax/14b2beb717e0f5df" data-scroll="false"></span>
<script>$(function () { $("#xload-contact-fax").xload(); });</script></a></a>
				</p>
				<p>
					<img src="<?php echo get_template_directory_uri() ;?>/images/email.png">Email: <span id="xload-contact-email" data-file="<?php echo get_template_directory_uri() ;?>/nosvg/ajax/14b2beb717e0f5de" data-scroll="false"></span>
<script>$(function () { $("#xload-contact-email").xload(); });</script></a>
				</p>
                <h2>Distributor</h2>
                <p>
                <strong>Bioquote Ltd.</strong><br />
				The Raylor Centre, James Street, York, YO10 3DW, United Kingdom<br />
                <strong>Tel:</strong> +44 (0) 1904 431 402 <br />
					  <strong>Fax:</strong> +44 (0) 1904 431 409 <br />
                      <strong>Email:</strong> <a href="mailto:sales@bioquote.com">sales@bioquote.com</a><br />
					  <strong>Web:</strong> <a href="https://www.bioquote.com" rel="nofollow">www.bioquote.com</a>
                </p>
			</div>

		</div>
		<div class="main_contact_right">

			<div class="contact_form">
				<h2>Leave a message</h2>
				<form id="formID" name="contactform" method="post" action="/pub/" autocomplete="off">
					<ul>
						<li>
							<label>Name *</label>
							<input type="text" name="name1" placeholder="Name" class="validate[required]">
						</li>

						<li>
							<label for="Phone number">Phone number *</label>
							<input type="text" name="phone" placeholder="Phone number" class="validate[required]">
						</li>

						<li>
							<label for="Email">Email *</label>
							<input type="email" name="email" placeholder="Email" class="validate[required,custom[email]]">
						</li>

						<li style="width:100%;">
							<label>Messages</label>
							<textarea name="message" cols="40" rows="4" placeholder="Messages"></textarea>
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

						<li style="margin-top:20px;">
							<button class="submit" type="button" onclick="onClickSubmit(this)">Send</button> <input type="hidden" name="act" value="send">
						</li>

					</ul>
				</form>
			</div>

		</div>

  </div><script type="text/javascript">jQuery(document).ready(function () { jQuery("#formID").validationEngine('attach', { promptPosition: "bottomLeft" }); });</script>
  
<?php get_footer();?>
