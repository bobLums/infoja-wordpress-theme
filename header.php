<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo get_the_title();?></title>
        <meta name="description" content="<?php ?>">
        <?php if ( is_home() ){
                echo '<link rel="canonical" href="';
                echo home_url();
                echo '">';  
		    }
        ?>
        <meta property="og:image" content="<?php echo home_url();?>" /> 
        <meta property="og:image:type" content="image/jpeg" />
        <meta property="og:image:width" content="400" />
        <meta property="og:image:height" content="300" />
		<?php wp_head();?>
        <link rel="stylesheet" href="https://use.typekit.net/qmg0jmj.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=ABeeZee:ital@0;1&display=swap" rel="stylesheet"> 
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto%3A100%2C300%2C300italic%2C400%2C500%2C700&amp;ver=5.5.3" type="text/css" media="all">
	</head>
	<body>
		<header>
            <nav class="navbar navbar-expand-md navbar-light">
                <div class="container">
                    <a class="navbar-brand" href="<?php echo home_url();?>">
                        <img src="<?php echo home_url('/wp-content/uploads/2022/05/infoja.png');?>" alt="" width="100">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <?php
                        wp_nav_menu(array(
                        'theme_location' => 'main-menu',
                        'container' => false,
                        'menu_class' => '',
                        'fallback_cb' => '__return_false',
                        'items_wrap' => '<ul id="%1$s" class="navbar-nav me-auto mb-2 mb-md-0 %2$s">%3$s</ul>',
                        'depth' => 2,
                        'walker' => new bootstrap_5_wp_nav_menu_walker()
                        ));
                        ?>
                        <div class=""><?php get_search_form();?></div>
                        <div class="sideNavsml">
                            <ul class="sideNav">
                                <li><h3 class="mt-5 mb-3">Categories</h3></li>
				                <?php
				                    $terms = get_terms('category');
				                    if ( !empty( $terms ) && !is_wp_error( $terms ) ){
					                    foreach ( $terms as $term ) {
						                    echo '<li><h5><a href="'. get_term_link( $term ) .'">'. $term->name .'</a></h5></li>';
					                        }
				                    }
				                ?>
                                <li><h3 class="mt-5 mb-3">Media Types</h3></li>
                                <?php
				                    $terms = get_terms('types');
				                    if ( !empty( $terms ) && !is_wp_error( $terms ) ){
					                    foreach ( $terms as $term ) {
						                    echo '<li><h5><a href="'. get_term_link( $term ) .'">'. $term->name .'</a></h5></li>';
					                        }
				                    }
				                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
		</header>
        <div class="content-wrap">
		    <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="sideNavbig">
                            <ul class="sideNav">
                                <li><h3 class="mt-5 mb-3">Categories</h3></li>
				                <?php
				                    $terms = get_terms('category');
				                    if ( !empty( $terms ) && !is_wp_error( $terms ) ){
					                    foreach ( $terms as $term ) {
						                    echo '<li><h5><a href="'. get_term_link( $term ) .'">'. $term->name .'</a></h5></li>';
					                        }
				                    }
				                ?>
                                <li><h3 class="mt-5 mb-3">Media Types</h3></li>
                                <?php
				                    $terms = get_terms('types');
				                    if ( !empty( $terms ) && !is_wp_error( $terms ) ){
					                    foreach ( $terms as $term ) {
						                    echo '<li><h5><a href="'. get_term_link( $term ) .'">'. $term->name .'</a></h5></li>';
					                        }
				                    }
				                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col">