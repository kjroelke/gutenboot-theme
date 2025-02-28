<?php
/**
 * Homepage Template
 *
 * @package GutenBoot
 */

use GutenBoot\Asset_Loader;
use GutenBoot\Enqueue_Type;

$loader = new Asset_Loader( 'frontPage', Enqueue_Type::both, 'pages' );

get_header();
?>
<main <?php post_class( array( 'site-content', "page-{$post->post_name}", 'd-flex', 'flex-column', 'row-gap-5' ) ); ?>>
	<section class="container py-5">
		<div class="row row-cols-1 row-cols-lg-2 row-gap-3">
			<div class="col">Blank on purpose.</div>
			<div class="col text-bg-secondary py-5">
				<h2 class="text-white">A text element</h2>
				<p class="fs-6">A subheadline element that has a lot of text. Hopefully if I keep typing there will be enough characters to break onto a second line.</p>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
