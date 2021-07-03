<?php
/**
 * The template for displaying all pages
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

<!--banner start css html-->
<div class="inside_banner about_bgimg">
		<h2><?php the_title(); ?></h2>
		<p><?php echo get_post_meta(get_the_ID(), "bannerText", true);?></p>
	</div>

	<div class="inside_nav">
		<div class="inside_nav_title"><?php get_breadcrumbs() ?></div>
  </div>
  
  <div class="container_center">
        <?php
                while (have_posts()): the_post();

                    the_content();

                endwhile; // End of the loop.
                ?>
     
 </div>

<?php get_footer();?>
