<?php
/* 
Template Name: Advanced Search
*/

if( (isset($_GET['keyword']) && trim($_GET['keyword']) !== '') ||
(isset($_GET['Subject']) && trim($_GET['Subject']) !== '') ||
(isset($_GET['Media']) && trim($_GET['Media']) !== '') ||
(isset($_GET['the_pub_year']) && trim($_GET['the_pub_year']) !== '') ||
(isset($_GET['the_pub_year_last']) && trim($_GET['the_pub_year_last']) !== '') ||
(isset($_GET['the_author']) && trim($_GET['the_author']) !== '')) 
{
	$is_search = true;
}
$catargs = array(
	"hide_empty" => true//to get all categories
);
$subjects = get_categories($catargs);                  
$doctypes = get_terms([
	'taxonomy' => 'types',
	'hide_empty' => true,
]);
if($is_search)
{
	$query = search_query();
}
?>
<?php get_header();?>
<?php get_template_part('includes/section','content');?>
<?php if($is_search):?>
	<div class="clearfix mb-3"></div>
	<h3>Search results for:
	<?php 
		if( isset($_GET['keyword']) && trim($_GET['keyword']) !== '' )
		{
		
			echo $_GET['keyword'];
			echo ', ';
		}
		if(isset($_GET['Subject']) && trim($_GET['Subject']) !== '' )
		{
			echo $_GET['Subject'];
			echo ', ';
		}
		if(isset($_GET['Media']) && trim($_GET['Media']) !== '' )
		{
			echo $_GET['Media'];
			echo ', ';
		}
		if(isset($_GET['the_pub_year']) && trim($_GET['the_pub_year']) !== '' )
		{
			echo ' start year: ';
			echo $_GET['the_pub_year'];
			echo ', ';
		}
		if(isset($_GET['the_pub_year_last']) && trim($_GET['the_pub_year_last']) !== '' )
		{
			echo ' end year: ';
			echo $_GET['the_pub_year_last'];
			echo ', ';
		}
		if(isset($_GET['the_author']) && trim($_GET['the_author']) !== '' )
		{
			echo ' authored by: ';
			echo $_GET['the_author'];
			echo ', ';
		}
	?></h3>
	<div class="mb-4"><a href="<?php echo home_url('/advanced-search');?>">Reset Search</a></div>
	<?php if($query->have_posts()) :?>
		<?php while($query->have_posts()) : $query->the_post();?>
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
		<?php endwhile;?>
		<?php wp_reset_postdata();?>
		<div class="mx-auto mb-5 pages">
			<?php 
				echo paginate_links( array(
					'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
					'total'        => $query->max_num_pages,
					'current'      => max( 1, get_query_var( 'paged' ) ),
					'format'       => '?paged=%#%',
				) );
			?>
		</div>
	<?php else:?>
		<div class="clearfix mb-3"></div>
		<div class="alert alert-danger">No results</div>
	<?php endif;?>
<?php endif;?>
<div class="card mt-4 mb-4" id="advanced-search-form" <?php
if($is_search)
{
	echo 'style="display: none;"';
}
?>>
	<div class="card-body">
		<form action="">
			<div class="form-group mb-4">
				<label class="mb-3">Type a keyword</label>
				<input
				type="text" 
				name="keyword" 
				placeholder="Type a keyword" 
				class="form-control"
				value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '';?>"
				> 
			</div>
			<div class="form-group mb-4">
				<label class="mb-3">Subject Area</label>
				<select name="Subject" class="form-control">
					<option value="">Select subject area</option>
					<?php foreach($subjects as $subject):?>
						<option
						<?php if( isset($_GET['Subject']) && ($_GET['Subject'] == $subject->slug) ):?>
							selected
						<?php endif;?>
						value="<?php echo $subject->slug;?>"><?php echo $subject->name;?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div class="form-group mb-4">
				<label class="mb-3">Media Type</label>
				<select name="Media" class="form-control">
					<option value="">Select Media</option>
					<?php foreach($doctypes as $doctype):?>
						<option 
						<?php if( isset($_GET['Media']) && ($_GET['Media'] == $subject->slug) ):?>
							selected
						<?php endif;?>
						value="<?php echo $doctype->slug;?>"><?php echo $doctype->name;?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div class="row">
				<p>Date Range</p>
				<div class="col-md-6">
					<div class="form-group mb-4">
						<label class="mb-3">From</label>
						<input
						type="number" 
						name="the_pub_year" 
						placeholder="Year" 
						class="form-control"
						value="<?php echo isset($_GET['the_pub_year']) ? $_GET['the_pub_year'] : '';?>"
						> 
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group mb-4">
						<label class="mb-3">To</label>
						<input
						type="number" 
						name="the_pub_year_last" 
						placeholder="Year" 
						class="form-control"
						value="<?php echo isset($_GET['the_pub_year_last']) ? $_GET['the_pub_year_last'] : '';?>"
						> 
					</div>
				</div>
			</div>

			<div class="form-group mb-4">
				<label class="mb-3">Author</label>
				<input
				type="text" 
				name="the_author" 
				placeholder="Authored by" 
				class="form-control"
				value="<?php echo isset($_GET['the_author']) ? $_GET['the_author'] : '';?>"
				> 
			</div>
			<button type="submit" class="btn btn-success btn-lg btn-block" onclick="hideForm()">Search</button>
			<div class="mt-3"><a href="<?php echo home_url('/advanced-search');?>">Reset Search</a></div>
		</form>
	</div>
</div>
<?php get_footer();?>