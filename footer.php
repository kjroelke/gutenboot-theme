<?php
/**
 * Basic Footer Template
 *
 * @package GutenBoot
 */

?>
<footer class="footer text-bg-primary py-3">
	<div class="container d-flex flex-column row-gap-4">
		<div class="row">
			<?php
			if ( has_nav_menu( 'footer_menu' ) ) {
				wp_nav_menu(
					array(
						'theme_location'  => 'footer_menu',
						'menu_class'      => 'footer-nav list-unstyled navbar-nav flex-row',
						'container'       => 'nav',
						'container_class' => 'navbar',
						'depth'           => 1,
					)
				);
			}
			?>
		</div>
		<div class="row">
			<div class="col-4">
				<a href="<?php echo esc_url( site_url() ); ?>">
					<?php echo bloginfo( 'name' ); ?>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col text-center" id="copyright">
				<?php
				$now = new DateTime( 'now', wp_timezone() );
				echo '&copy;&nbsp;' . $now->format( 'Y' )
				?>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>

</html>
