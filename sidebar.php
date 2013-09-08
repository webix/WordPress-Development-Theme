	<aside id="aside">
		<?php get_search_form(); ?>
		<section>
			<h2>카테고리</h2>
			<ul>
			<?php wp_list_cats('sort_column=id&optioncount=1&exclude=36'); ?>
			</ul>
		</section>
		<section>
			<h2>최근 게시물</h2>
			<ul>
			<?php
				$args = array( 'numberposts' => '5' );
				$recent_posts = wp_get_recent_posts( $args );
				foreach( $recent_posts as $recent ){
					echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="Look '.$recent["post_title"].'" >' .   $recent["post_title"].'</a> </li> ';
				}
			?>
			</ul>
		</section>
		<section>
			<h2>최근 댓글</h2>
			<?php recent_comments() ?>
		</section>
		<?php if ( ! dynamic_sidebar( 'primary-widget-area' ) ) :
			// Widgets
		endif; ?>
	</aside>
