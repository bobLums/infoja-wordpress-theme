<form role="search" method="get" style="" class="search-form d-flex flex-row" action="<?php echo home_url( '/' ); ?>">
	<label for="search"></label>
	<input type="text" class="form-control me-2" name="s" id="search" value="<?php the_search_query();?>" required> 
	<button type="submit" class="btn">Search</button>
</form>