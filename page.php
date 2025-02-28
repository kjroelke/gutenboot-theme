<?php
/**
 * Standard Page Output with default Hero section
 *
 * @package GutenBoot
 */

get_header();
?>

<main <?php post_class( array( 'site-content', "page-{$post->post_name}" ) ); ?>>
	<article class="container">
		<?php the_content(); ?>
	</article>
</main>
<?php
get_footer();
