<?php get_header(); ?>

	<div id="error" >
		<div id="content">
			<div class="row">
				<div class="container inner">
					<div class="span column seven break">
						<div class="error">
							<h1>Oops!</h1>                     
							<h2>It’s looking like you may have taken a wrong turn.
							Don’t worry... it happens to the best of us.</h2>
							<p>Theres’s a little help on the top that might help you get back on track.</p>
							<span>404</span>
						</div>						
					</div>
					<div class="span column three break">
						<img  class="hide-on-mobile" src="<?php echo get_template_directory_uri(); ?>/images/misc/404-sad-face.png" alt="">
					</div>
				</div>
			</div>

		</div><!-- #content -->
	</div><!-- #error -->

<?php get_footer(); ?>