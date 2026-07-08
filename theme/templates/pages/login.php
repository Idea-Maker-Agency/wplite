<?php
/**
 * The template for displaying login page.
 *
 * @package    WPLite
 * @subpackage Templates
 * @author     Idea Maker
 * @since      1.0.0
 */

use WPLite\Utils\Component;

get_header();
?>

<section class="py-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-md-8 col-lg-5">
				<h1 class="mb-4 fw-bold">
					<?= get_the_title() ?>
				</h1>

				<?php Component::render('login-form', 'Auth') ?>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
?>