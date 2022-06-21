<?php if( have_posts() ): while( have_posts() ): the_post();?>
	<h1 class="mt-5"><?php the_title();?></h1>
	<div class="row mt-3 mb-3">
		<div class="col">
			<h2 class="mb-3">Basic Information</h2>
			<h3>Date Created</h3>
			<b class="mb-2"><p>
				<?php if( get_field('date_published') ): ?>
					<?php  the_field('date_published'); echo ', '; ?>
				<?php endif; ?>
				<?php the_field('pub_year');?>
			</p></b>

			<h3>Author</h3>
			<p class="mb-3"><?php the_field('doc_author');?></p>
			
			<?php if( get_field('date_obtained') ): ?>
				<h3>Date Obtained</h3>
				<b class="mb-2"><p class="mb-3"><?php the_field('date_obtained');?></p></b>
			<?php endif; ?>

			<?php if( get_field('document_link') ): ?>
				<h3><a href ="<?php the_field('document_link');?>" target="_blank">Document Link</a></h3>
			<?php endif; ?>
		</div>
		<div class="col-sm-4 m-5">
			<?php if(has_post_thumbnail()):?>
					<img src="<?php the_post_thumbnail_url('blog-small')?>" alt="<?php the_title();?>" class="img-fluid">
			<?php endif;?>
		</div>
	</div>
	<?php the_content();?>
	<p><?php the_tags( 'Tags: ', ', ', '<br />' ); ?></p>
<?php endwhile; else: endif;?>