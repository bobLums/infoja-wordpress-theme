<?php
/* 
Template Name: Contact
*/
?>
<?php get_header();?>
	<h1 class="mt-5"><?php the_title();?></h1>
	<div class="card mt-4 mb-4">
		<div class="card-body">
			<?php if( have_posts() ): while( have_posts() ): the_post();?>
				<?php the_content();?>
			<?php endwhile; else: endif;?>
		</div>
	</div>
<?php get_footer();?>