<?php get_header();?>
	<?php get_template_part('includes/section','archive');?>
	<div class="mx-auto mb-5 pages">
		<?php 
			global $wp_query;
			$big = 999999999;
			echo paginate_links(
				array(
					'base' => str_replace( $big, "%#%", esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages
				)
			);
		?>
	</div>
<?php get_footer();?>