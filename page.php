<?php get_header(); ?>
	<section id="container">
		<article id="content">
			<?php if (have_posts()) : the_post(); ?>
			<hgroup>
				<h1><?php the_title(); ?></h1>
				<p><?php the_time('Y.m.d g:i A') ?></p>
			</hgroup>
			<section class="content">
				<?php the_content(); ?>
			</section>
			<?php comments_template(); ?>
			<?php endif; ?>
		</article>
		<hr />
		<?php get_sidebar(); ?>
	</section>
<?php get_footer(); ?>
