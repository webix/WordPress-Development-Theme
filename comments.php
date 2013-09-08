<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

function comment_add_microid($classes) {
	$c_email=get_comment_author_email();
	$c_url=get_comment_author_url();
	if (!empty($c_email) && !empty($c_url)) {
		$microid = 'microid-mailto+http:sha1:' . sha1(sha1('mailto:'.$c_email).sha1($c_url));
		$classes[] = $microid;
	}
	return $classes;	
}
add_filter('comment_class','comment_add_microid');
?>
<section id="respond">
<?php if ('open' == $post-> comment_status) : ?>

	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<div class="login">
			<p>댓글을 작성하려면 <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">로그인</a>을 해야합니다.</p>
		</div>
	<?php else : ?>
		<h2><?php comment_form_title( '댓글', '%s님에게 댓글' ); ?> <span><?php cancel_comment_reply_link('취소'); ?></span></h2>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<fieldset>
		<legend>댓글</legend>
			<?php if ( !$user_ID ) : ?>
			<div class="author">
				<label for="author">이름</label>
				<input type="text" name="author" id="author" <?php if ($req) echo 'required="required"'; ?> value="<?php echo $comment_author; ?>" placeholder="이름" />
				<label for="email">이메일</label>
				<input type="text" name="email" id="email" <?php if ($req) echo 'required="required"'; ?> value="<?php echo $comment_author_email; ?>" placeholder="이메일" />
			</div>
			<?php endif; ?>
			<input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" />
			<textarea name="comment" id="comment" cols="" rows="" placeholder="댓글 달기..."></textarea>
			<input name="submit" type="submit" class="submit" value="등록" />
			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', $post->ID); ?>
		</fieldset>
	</form>
	<?php if (get_option("comment_moderation") == "1") { ?>
		<p class="msg"><strong>알림:</strong> 모든 댓글은 관리자 검토 후에 노출 됩니다.</p>
	<?php } ?>
	<?php endif; ?>
<?php endif; ?>

<?php if ( have_comments() ) : ?>
	<div class="commentList">
		<ul>
			<?php wp_list_comments('type=comment&callback=custom_comment_list'); ?>
		</ul>
		<?php if (paginate_comments_links) { ?>
			<div class="pagination">
			<?php paginate_comments_links( array('prev_text' => '이전', 'next_text' => '다음') ); ?>
			</div>
		<?php } ?>

	</div>
<?php endif; ?>
</section>
