<?php
/**
 * Template Name: faqs
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

	<!--banner start css html-->
	<div class="inside_banner faq_bgimg">
		<h2><?php the_title(); ?></h2>
		<p><?php echo get_post_meta(get_the_ID(), "bannerText", true);?></p>
	</div>

	<div class="inside_nav">
		<div class="inside_nav_title"><?php get_breadcrumbs() ?></div>
	</div>

<div class="container_center inquiry_center">
		<div class="inquiry_title"><?php the_title() ?></div>
		<div class="main_center_c2" style="margin-top:30px;">

			
        <?php
                while (have_posts()): the_post();

                    the_content();

                endwhile; // End of the loop.
                ?>

        </div>

	</div>



<?php get_footer();?>
