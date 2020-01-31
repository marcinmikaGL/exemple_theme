<?php
/**
 * @package WordPress
 * @subpackage weblider
 * @since 0.1.0
 * widok podstron
 */
get_header();
?>

 <div class="page_top row">
<hr class="page_hr_top">
	<div class="page_title_top">
		<h3><?php the_title(); ?></h3>
	</div>

<?php
    while ( have_posts() ) : the_post(); ?>
        <div class="page_content col-12" id="post_<?php  echo get_the_ID() ?>">
            <?php do_shortcode(the_content()); ?>
        </div>

    <?php
endwhile;
wp_reset_query();
?>
</div>
<?php
get_footer();
