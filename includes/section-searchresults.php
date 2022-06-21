<h1 class="mt-5 mb-4">Results for: <?php the_search_query();?></h1>
<?php if( have_posts() ): while( have_posts() ): the_post();?>
	<div class="card mb-4">
		<div class="card-body">
			<div class="row">
				<div class="col-3 col-2-sm mb-2">
					<?php if(has_post_thumbnail()):?>
						<img src="<?php the_post_thumbnail_url('blog-small')?>" alt="<?php the_title();?>" class="img-fluid mx-auto" style="">
					<?php endif;?>
				</div>
				<div class="col">
					<h3 style="text-align:left;"><?php the_title();?></h3>
					<?php the_excerpt();?>
					<p class="card-text">Author:<br>
						<b class="mb-2"><?php the_field('doc_author');?></b>
					</p>
					<p class="card-text">Date authored:<br><b class="mb-2">
						<?php if( get_field('date_published') ): ?>
							<?php  the_field('date_published'); echo ', '; ?>
						<?php endif; ?>
						<?php the_field('pub_year');?></b>
					</p>
					<b><a href="<?php the_permalink();?>">Read more</a></b>
				</div>
			</div>
		</div>
	</div>
<?php endwhile; else: ?> 
	There are no results for <?php the_search_query();?>.	
<?php endif;?>
