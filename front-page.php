<?php get_header();?>
		<?php get_template_part('includes/section','content');?>
        <div class="link-box mb-5 mt-4">
            <h3><a href="<?php echo home_url('/contact');?>">Contact us</a></h3>
        </div>
        <h2 class="mb-3">Recently Added</h2>
		<div class="row mt-2 mb-5 d-flex align-items-stretch"> 
            <?php
                $args = array( 'post_type' => 'post', 
                               'numberposts' => 3 );
                $mypost = get_posts( $args );
                foreach($mypost as $post) : setup_postdata($post); ?>
                    <div class="col-lg-4 mb-3">
                        <div class="card" style="width: 100%; height: 100%;">
                            <div class="card-body">
                                <div class="mx-auto front-img"><img src="<?php the_post_thumbnail_url( 'page-img' )?>" class="card-img-top p-3" alt="..."></div>
                                <div class="card-body">
                                    <a href="<?php the_permalink();?>"><p class="card-title"><b><?php the_title();?></b></p></a>
                                    <p class="card-text">Author:<br>
			                            <b class="mb-2"><?php the_field('doc_author');?></b>
			                        </p>
                                    <p class="card-text">Date authored:<br><b class="mb-2">
									    <?php if( get_field('date_published') ): ?>
										    <?php  the_field('date_published'); echo ', '; ?>
									    <?php endif; ?>
									    <?php the_field('pub_year');?></b>
								    </p>
                                </div>
                             </div>
                         </div>
                    </div>
            <?php endforeach; ?> 
		</div>
<?php get_footer();?>