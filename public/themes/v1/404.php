<?php
/**
 * 404 template
 */
get_header();?>

<!--banner start css html-->
<div class="inside_banner services_bgimg">
		<h2>404 Not Found</h2>
		<p>Sorry, but page was not found</p>
	</div>

	<div class="inside_nav">
		<div class="inside_nav_title"><?php get_breadcrumbs() ?></div>
  </div>
  
  <div class="container_center">

<div class="about_us_center" style="text-align:center;">
<h3>Sorry, but page was not found</h3>
<p >You may have mistyped the address or the page may have moved.</p>
  <p>
	  <a href="javascript:void(0);" onClick="javascript :history.back(-1);" class="inquiry_btn">Back</a>
	  <a  href="<?php echo home_url();?>" class="inquiry_btn">Home</a>
	  <a  href="<?php echo home_url();?>/contact-us/" class="inquiry_btn">Contact Us</a>
  </p>
</div>
</div>

<?php get_footer();
