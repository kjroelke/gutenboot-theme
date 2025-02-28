<?php
/**
 * The primary archive page.
 *
 * Included for historical reasons. This file is not used in the theme.
 *
 * @package GutenBoot
 */

get_header();
?>
<main <?php post_class();?>>
	<?php
the_title( '<h1>', '</h1>' );
the_content();
?>
</main>
<?php
get_footer();
