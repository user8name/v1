<?php
/**
 * Template Name: order
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

		jQuery("#formID2").validationEngine();

		$("#formID2").bind("jqv.form.validating", function (event) {
			$("#hookError").html("")
		})
		$("#formID2").bind("jqv.form.result", function (event, errorFound) {
			if (errorFound) $("#hookError").append("There is some problems with your form");
		})
     });
</script>

	<!--banner start css html-->
	<div class="inside_banner order_bgimg">
		<h2><?php the_title(); ?></h2>
		<p><?php echo get_post_meta(get_the_ID(), "bannerText", true);?></p>
	</div>

	<div class="inside_nav">
		<div class="inside_nav_title"><?php get_breadcrumbs() ?></div>
	</div>

<div class="container_center inquiry_center">
		<div class="inquiry_title"><?php the_title() ?></div>
		<div class="main_center_c2">
        <div class="tab-wrapper">
        <div class="tab-menu-bg">
        <ul class="tab-menu">
    	<li class="active">Purchase Order</li>
    	<li>Credit Card Payment</li>
  		</ul>
        </div>
		<div class="tab-content">
        	<div>
            <p>
			<strong>Three Ways to Place Your Order:</strong><br />
			1. Submit your Purchase Order via <strong><a href="mailto:info@<?php echo do_shortcode('[v1_get_domain]'); ?>">info@<?php echo do_shortcode('[v1_get_domain]'); ?></a></strong><br />
			2. Submit your Purchase Order via <strong><img src="<?php echo get_template_directory_uri() ;?>/nosvg/faq-fax-black.svg" height="20" style="vertical-align: middle;" /></strong>
            </p>
            <div class="orderleft">
			<form id="formID" name="inquiryform" class="Inquiry_form" method="post" action="/orderpub/" autocomplete="off" enctype="multipart/form-data">
			<ul>
			<li style="width:100%;">
			<label>* Submit your Purchase Order via Online File upload :</label>
                
			<input id="myfile" name="myfile" type="file" value="11" class="validate[required]">
			</li>
			<li style="width:100%;">
			<label>* Name</label>
			<input type="text" name="name1" class="validate[required]" placeholder="Name">
			</li>

			<li style="width:100%;">
			<label>* Organization </label>
			<input type="text" name="organization" class="validate[required]" placeholder="Organization">
			</li>
                                    
			<li style="width:100%;">
			<label>* Email </label>
			<input type="text" name="email" class="validate[required,custom[email]]" placeholder="Email">
			</li>
                        
                        
			<li style="width:100%;">
			<label>* Phone number</label>
			<input type="text" name="phone" class="validate[required]" placeholder="Phone number">
			</li>

            <li style="width:100%;">
                <label>Fedex/UPS/DHL Account for Shipping</label>
                <input type="text" name="shipping" placeholder="Account for Shipping">
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
			<li style="width:100%;"></li>           
			<li style="width:100%;">
			<button class="submit" type="button" onclick="onClickSubmit(this)">Submit</button> <input type="hidden" name="act" value="send"><input type="hidden" name="typeid" value="1">
			</li>
			</ul>
			</form>

			</div>
            
            <div class="orderright"><p><img src="<?php echo get_template_directory_uri() ;?>/images/Distributors.png" /></p>
            <p><h2 style="text-align:center; font-size:20px;">INNOVATIVE / PROFESSIONAL GLOBAL SERVICES</h2></p>
            <p>We influence the world through our innovative technology, and you can find us at every corner of the world. </p>
            <p><a href="/contact-us/" class="btn">Contact Us</a></p>
            </div>
            
            </div>
            <!--Credit Card Payment-->
            <div>
            <p>You could also place an order through Credit Card Payment by filling and submitting the following information.</p>
            <div class="orderleft">
            
            <p><strong>Contact Information</strong></p>
			<form id="formID2" name="inquiryform" class="Inquiry_form" method="post" action="/orderpub/" autocomplete="off">
			<ul>
            <li>
			<label>* Name</label>
			<input type="text" name="name1" class="validate[required]" placeholder="Name">
			</li>
			<li>
			<label>* Organization </label>
			<input type="text" name="organization" class="validate[required]" placeholder="Organization ">
			</li>
			<li>
			<label>* Email </label>
			<input type="text" name="email" class="validate[required]" placeholder="Email">
			</li>
			<li>
			<label>* Phone number </label>
			<input type="text" name="phone" class="validate[required]" placeholder="Phone number">
			</li>
			<li style="width:100%;">
			<label>* Shipping Address </label>
			<textarea name="shippingaddress" class="validate[required]" cols="40" rows="2" placeholder="Shipping Address"></textarea>
			</li>
            <li style="width:100%;">
                <label>Fedex/UPS/DHL Account for Shipping </label>
                <textarea name="fedexshipping" cols="40" rows="2" placeholder="Account for Shipping"></textarea>
            </li>
			<li style="width:100%;">
			<label>* Billing Address </label>
			<textarea name="billingaddress" class="validate[required]" cols="40" rows="2" placeholder="Billing Address"></textarea>
			</li>            
			<li style="width:100%;">
			<label>Other Inquiries </label>
			<textarea name="specialrequirement" cols="40" rows="2" placeholder="Other inquiries"></textarea>
			</li>
            
            <p><strong>Product Information</strong></p>
			<li>
			<label>* Quote Number </label>
			<input type="text" name="quotenumber" class="validate[required]" placeholder="Quote Number">
			</li>            
			<li>
			<label>* Catalog Number(s) </label>
			<input type="text" name="catalognumber" class="validate[required]" placeholder="Catalog Number(s)">
			</li>
			<li>
			<label>* Quantity </label>
			<input type="text" name="quantitytoorder" class="validate[required]" placeholder="Quantity">
			</li>            
            
            <p><strong>Card Information</strong></p>
            
			<li>
			<label>* Card Type </label>
			<input id="cardtype" type="Type" list="Type_list" name="cardtype" class="validate[required]"/>
<datalist id="Type_list">
	<option label="MasterCard" value="MasterCard" />
	<option label="VISA" value="VISA" />
	<option label="Amex" value="Amex" />
</datalist>
			</li>            
			<li>
			<label>* Card Number </label>
			<input type="text" name="cardnumber" class="validate[required]" placeholder="Card Number">
			</li>            
			<li>
			<label>* Expiration Date </label>
			<input type="month" name="expirydate" class="validate[required]" placeholder="Expiration Date">
			</li>            
			<li>
			<label>* Name on Card </label>
			<input type="text" name="nameoncard" class="validate[required]" placeholder="Name on Card">
			</li>            
			<li>
			<label>* CVV </label>
			<input type="password" name="cvv" class="validate[required]" placeholder="CVV">
			</li>            
            <li style="width:100%;"></li>
                <script>
                    function onClickSubmit1(e) {
                        if ((typeof grecaptcha) != 'undefined'){
                            grecaptcha.ready(function() {
                                grecaptcha.execute('<?php echo CustomConfig::RECAPTCHAHTML;?>', {action: 'submit'}).then(function(token) {
                                    // Add your logic to submit to your backend server here.
                                    $('#g-recaptcha-responseid1').val(token)

                                    if($('#formID2').validationEngine('validate')){
                                        $('#formID2').submit();
                                    }
                                });
                            });
                        }
                    }
                </script>
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-responseid1">
			<li style="width:100%;">
			<button class="submit" type="button" onclick="onClickSubmit1(this)">Submit</button> <input type="hidden" name="act" value="send"><input type="hidden" name="typeid" value="2">
			</li>
            
            
                        
			</ul>
            </form>
            </div>
            
            
            <div class="orderright"><p><img src="<?php echo get_template_directory_uri() ;?>/images/cart.png" /></p>
            <p><h2 style="text-align:center; font-size:20px;">Convenient, quick, accurate, and confidential</h2></p>
            <p>We influence the world through our innovative technology, and you can find us at every corner of the world. </p>
            </div>            
            
                                    
            </div>
            <!--end-->
            </div>
            </div>
            
         

    
    
			
		</div>

	</div>

<script type="text/javascript">
$(document).ready(function() {
  
  var $wrapper = $('.tab-wrapper'),
      $allTabs = $wrapper.find('.tab-content > div'),
      $tabMenu = $wrapper.find('.tab-menu li'),
      $line = $('<div class="line"></div>').appendTo($tabMenu);
  
  $allTabs.not(':first-of-type').hide();  
  $tabMenu.filter(':first-of-type').find(':first').width('100%')
  
  $tabMenu.each(function(i) {
    $(this).attr('data-tab', 'tab'+i);
  });
  
  $allTabs.each(function(i) {
    $(this).attr('data-tab', 'tab'+i);
  });
  
  $tabMenu.on('click', function() {
    
    var dataTab = $(this).data('tab'),
        $getWrapper = $(this).closest($wrapper);
    
    $getWrapper.find($tabMenu).removeClass('active');
    $(this).addClass('active');
    
    $getWrapper.find('.line').width(0);
    $(this).find($line).animate({'width':'100%'}, 'fast');
    $getWrapper.find($allTabs).hide();
    $getWrapper.find($allTabs).filter('[data-tab='+dataTab+']').show();
  });

});//end ready
</script>

<?php get_footer();?>
