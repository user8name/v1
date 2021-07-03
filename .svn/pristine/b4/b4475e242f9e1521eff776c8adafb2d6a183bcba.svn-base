<?php
/**
 * Template Name: promotion1
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
    $bannerImage = trim(get_post_meta(get_the_ID(), "bannerImage", true));
    if($bannerImage==''){
        $bannerImage = '/images/Thanksgiving-Sale-2018.jpg';
    }

get_header();?>

	<!--banner start css html-->
    <div class="inside_banner" style="background:url(<?php echo get_template_directory_uri().$bannerImage ;?>); background-position:center;">

		<h2 style="color:#fff;"><?php the_title(); ?></h2>
		<p style="font-size:36px; font-weight:bold; color:#fff;"><?php echo get_post_meta(get_the_ID(), "bannerText", true);?></p>
	</div>

	<div class="inside_nav">
		<div class="inside_nav_title"><?php get_breadcrumbs() ?></div>
	</div>

<div class="container_center inquiry_center">
		
		<div class="main_center_c4">
   <div class="inquiry_title"><?php the_title() ?></div>
 <?php
                        while (have_posts()) : the_post();

                        the_content();

                        endwhile; // End of the loop.
                        ?>

					</div>

	</div>



<?php get_footer();?>
