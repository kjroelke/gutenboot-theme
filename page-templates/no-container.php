<?php
/**
 * Template Name: Blank, No Container
 * Description: A blank page with a container for content
 *
 * @package GutenBoot
 */

get_header();
?>
<div <?php post_class(); ?>>
	<?php the_content(); ?>
</div>
<?php
get_footer();
