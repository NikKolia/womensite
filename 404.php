<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */

get_header('inner'); ?>
<?php get_template_part('includes/section', 'jumbotron'); ?>
 <div class="container-fluid whiteBg overflow-hidden treatmentLanding pageContentDynamic p-15 p-md-4">
    <div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h1>Oops!</h1>
			</div>
			<h2>404 - Page not found</h2>
			<p>The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
			<a href="http://menopausewhatworks.com">Go To Homepage</a>
		</div>
	</div>
 </div>

<?php
get_footer();
