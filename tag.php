<?php get_header(); ?>
		<section id="container">
			<article id="content">
				<p class="msg"><?php printf( __( '<em>&quot;%s&quot;</em>태그 관련 건의 글' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></p>
				<?php if (have_posts()) : ?>
					<div class="postList">
						<ul>
						<?php while (have_posts()) : the_post(); ?>
							<li>
								<?php if ( has_post_thumbnail() ){ ?>
										<p class="figure"><?php the_post_thumbnail('thumbnails'); ?></p>
								<?php } else {
										$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
										if ( $images ){
											$total_images = count( $images );
											$image = array_shift( $images );
											$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
											echo '<p class="figure">'.$image_img_tag.'</p>';
										}
									}
								?>
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p class="date"><?php the_date('Y-m-d') ?></p>
								<?php the_excerpt(); ?>
								<?php if ( get_the_tags() ){ ?>
									<p class="tags"><span class="ico tag"></span><?php the_tags('태그: ', ', ', '.'); ?></p>
								<?php } ?>
							</li>
						<?php endwhile; ?>
						</ul>
					</div>
				<?php else : ?>
					<div class="postList">
						<p class="noData">등록된 글이 없습니다.</p>
					</div>
				<?php endif; ?>
				<?php
					if ( paginate_links ){
						global $wp_query;
						$big = 999999999;
						echo '<div class="pagination">';
						echo paginate_links( array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $wp_query->max_num_pages,
							'prev_text'    => __('이전'),
							'next_text'    => __('다음'),
						) );
						echo '</div>';
					}
				?>
			</article>
			<hr />
			<?php get_sidebar(); ?>
		</section>
<?php get_footer(); ?>
