<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="keywords" content="<?php if ( is_home() ) { bloginfo('description'); } else { bloginfo('name'); $posttags = get_the_tags(); if ($posttags) { foreach($posttags as $tag) { echo ', '.$tag->name ; } } } ?>" />
<meta name="description" content="<?php if ( is_home() ) { bloginfo('name'); } else { if ( have_posts() ) : while ( have_posts() ) : the_post(); echo get_the_excerpt(); endwhile; else: endif; } ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<!--[if lte IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<title><?php wp_title( '-', true, 'right' ); ?><?php bloginfo('name'); ?></title>
</head>
<body>
<div id="notFound">
	<article>
		<h1>404 Not Found</h1>
		<p>The page you are looking for could not be found</p>
	</article>
</div>
</body>
</html>
