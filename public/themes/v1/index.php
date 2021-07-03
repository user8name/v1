<?php
/**
 * default index template
 */
get_header();?>
<!--banner start css html-->
<div class="inside_banner_about">
		<h1><?php the_title(); ?></h1>
		<p><?php echo get_post_meta(get_the_ID(), "bannerText", true);?></p>
	</div>

	<div class="inside_nav">
		<div class="inside_nav_title"><?php get_breadcrumbs() ?></div>
  </div>
  <div class="container_center">
<?php
if (have_posts()):

    /* Start the Loop */
    while (have_posts()): the_post();

        /*
         * Include the Post-Format-specific template for the content.
         * If you want to override this in a child theme, then include a file
         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
         */
        get_template_part('content/content',get_post_format());

    endwhile;

else:
    _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'v1');
    get_search_form();

endif;
?>
</div>

<?php get_footer();
