<?php
/**
 * Template Name: career
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
$q = $_GET["q"];
get_header();?>


	<script type="text/javascript">
$(document).ready(function(){

	$("#firstpane .menu_body:eq(0)").show();
	$("#firstpane h3.menu_head").click(function(){
		$(this).addClass("current").next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
		$(this).siblings().removeClass("current");
	});

	
});
</script>


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
<style>
	.Inquiry_form input {width: 96%!important;}
</style>
	<!--banner start css html-->
	<div class="inside_banner about_bgimg">
		<h2><?php the_title(); ?></h2>
		<p><?php echo get_post_meta(get_the_ID(), "bannerText", true);?></p>
	</div>

	<div class="inside_nav">
		<div class="inside_nav_title"><?php get_breadcrumbs() ?></div>
	</div>

<div class="container_center inquiry_center">
		<div class="inquiry_title">Project Manager<!--<?php the_title() ?>--></div>
		<div class="main_center_c2" style="margin-top:30px;">

        <P><strong>About Matexcel</strong></P>
        <p>Matexcel is a leading service provider in materials science. We offer a full range of materials covering polymers, metals, ceramics, and natural materials, in addition to professional material manufacturing and characterization services.</p>
        <P><strong>Key responsibilities:</strong></P>
<p>• Work across functions with different departments within the company to ensure each project is well planned for successful execution.</p>
<p>• Implement completion of projects from project initialization, capital request, scheduling, conceptual design, basic design, detailed design, execution to final testing.</p>
<p>• Lead and deliver projects on time, meeting the requirement, and within budget.</p>
<p>• Communicate with management of internal & external partners, including from R&D, Supply, and Product Development departments.</p>
<p>• Prepare and write scientific papers and case studies.</p>
<p>• Demonstrate projects‘ purpose, process, and results as requested.</p>
<p>• Offer advice and consultation on related research topics and meet customers’ requirements.</p>

			<P><strong>Qualifications:</strong></p>
<p>• Ph.D. in Materials Science, Biomaterials, or related areas;</P>
<p>• Ability to complete complicated tasks independently;</P>
<p>• Ability to quickly learn and be flexible;</P>
<p>• Positive attitude, outgoing personality, hardworking, and open-minded;</P>
<p>• Skilled in writing, editing, and reviewing business documents.</P>
<P><strong>Location</strong></p>
<p>New York, USA</p>
       <div class="inquiry_title" style="text-align: left;">Join Us</div>
       <form id="formID" name="inquiryform" class="Inquiry_form" method="post" action="/pubx/" enctype="multipart/form-data" autocomplete="off">
			<ul>
            <li>
			<label>* First Name:</label>
			<input type="text" name="firstname" class="validate[required]" placeholder="First Name">
			</li>
			<li>
			<label>* Last Name:</label>
			<input type="text" name="lastname" class="validate[required]" placeholder="Last Name ">
			</li>
			<li>
			<label>* Email: </label>
			<input type="text" name="email" class="validate[required]" placeholder="Email">
			</li>
			<li>
			<label>* Phone number: </label>
			<input type="text" name="phone" class="validate[required]" placeholder="Phone number">
			</li>
			<li style="width:100%;">
			<label>* Resume</label>
			<input id="myfile" name="myfile" type="file" value="11" class="validate[required]" width="100%;">
			</li>
            <li style="width:100%; margin-top: 30px;">
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-responseid">
                <input type="hidden" name="act" value="send">
                <input type="hidden" name="action" value="1">
			<button class="submit" type="button" onclick="onClickSubmit(this)" style="margin-bottom: 10px;">Submit</button>
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
			</ul>
            </form>
       <p>We are looking for talented people like you to join our team. Together we can advance the field of materials science and build a great future! </p>
      
        </div>

	</div>



<?php get_footer();?>
