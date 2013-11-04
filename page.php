<?php $ajax = (isset($_GET['ajax']) && $_GET['ajax'] == true) ? true : false;
if(!$ajax) get_header(); ?>
<?php if($ajax): ?><button class="close-button"></button><?php endif; ?>
	<div id="page" class="container clearfix">
		<div id="content" class="row">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php if ( get_field('header_image')) :?>
					<?php 
						$header_image_id = get_field('header_image');
						$header_image = wp_get_attachment_image_src($header_image_id, 'full');
					?>
					<div class="header-image clearfix">
						<div class="span ten">
							<img src="<?php echo $header_image[0]; ?>" alt="">
						</div>
					</div>
				<?php endif; ?>
				<?php if ( get_field('explanation')) :?>
					<div class="top-message clearfix" id="start">
						<p><?php the_field('explanation')?></p>
					</div>
				<?php endif; ?>
				<div class="inner clearfix">
					<?php the_content(); ?>	
				</div>
			<?php endwhile; ?>
		</div><!-- #content -->
	</div><!-- #page -->
<?php $ajax = (isset($_GET['ajax']) && $_GET['ajax'] == true) ? true : false;
if(!$ajax) get_footer(); ?>