<?

// WordPress jQuery Remove / Theme jQuery Register
function custom_script_register() {
	wp_enqueue_script('jquery');
	wp_deregister_script('jquery');
	wp_register_script('jquery', (get_template_directory_uri()."/common/js/jquery.min.js"), false, '1.10.2');
}
if (!is_admin()) add_action("wp_enqueue_scripts", "custom_script_register", 11);

// Featured Image
add_theme_support('post-thumbnails');
add_image_size('featured', 200, 200, true);

// Wordpress Meta Reset
add_action('init', 'removeheadlink');
function removeheadlink() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links_extra', 3 );
	remove_action('wp_head', 'feed_links', 2 );
	remove_action('wp_head', 'rel_canonical');
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
}

function remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'remove_recent_comments_style' );

// Wordpress Version Meta Remove
remove_action('wp_head', 'wp_generator');

/* Disable the Admin Bar. */
add_filter( 'show_admin_bar', '__return_false' );

// Admin Link Menu Remove
add_action( 'admin_menu', 'my_admin_menu' );
function my_admin_menu() {
	remove_menu_page('link-manager.php');
}

// Wordpress Default Widgets Remove
function unregister_default_wp_widgets() {
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Text');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
}
add_action('widgets_init', 'unregister_default_wp_widgets', 1);

// Sidebar Widgets
if ( function_exists('register_sidebar') ) {

	register_sidebar(array(
		'name'=>'Primary Widget Area',
		'before_widget' => '<section>',
		'after_widget'  => '</section>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>'
	));
}

// Dashboard Custom Footer
function custom_admin_footer() {
 echo 'Thank you for creating with <a href="http://hylaweb.net">HYLA</a>';
}
add_filter('admin_footer_text', 'custom_admin_footer');

// Profile Remove AIM/IM/Jabber
function remove_userfields( $contactmethods ) {
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);
  return $contactmethods;
}
add_filter('user_contactmethods','remove_userfields',10,1);

// CUSTOM USER PROFILE FIELDS
function custom_userfields( $contactmethods ) {
	$contactmethods['facebook'] = 'Facebook';
	$contactmethods['twitter'] = 'Twitter';
	$contactmethods['me2day'] = 'me2day';
	return $contactmethods;
}
add_filter('user_contactmethods','custom_userfields',10,1);

// Recent Comment
function recent_comments() {
	global $wpdb;
	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
	comment_post_ID, comment_author, comment_date_gmt, comment_approved,
	comment_type,comment_author_url,
	SUBSTRING(comment_content,1,34) AS com_excerpt
	FROM $wpdb->comments
	LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =
	$wpdb->posts.ID)
	WHERE comment_approved = '1' AND comment_type = '' AND
	post_password = ''
	ORDER BY comment_date_gmt DESC
	LIMIT 5";
	
	$comments = $wpdb->get_results($sql);
	$output = $pre_HTML;
	$output .= "\n<ul>";
	foreach ($comments as $comment) {
	$output .= "\n<li><strong>".strip_tags($comment->comment_author)."</strong>: <a href=\"" . get_permalink($comment->ID) .
	"#comment-" . $comment->comment_ID . "\" title=\"on " .
	$comment->post_title . "\">" . strip_tags($comment->com_excerpt)
	."</a></li>";
	}
	$output .= "\n</ul>";
	$output .= $post_HTML;
	echo $output;
}

// Custom Comment List
function custom_comment_list($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li id="comment-<?php comment_ID() ?>">
		<div class="avatar">
			<?php echo get_avatar( $comment->comment_author_email, 44 ); ?>
		</div>
		<?php if ($comment->comment_approved == '0') : ?>
		<p class="msg"><?php _e('입력한 댓글이 검토를 기다리고 있습니다.') ?></p>
		<?php endif; ?>
		<p class="meta"><?php printf(__('<strong>%s</strong>'), get_comment_author_link()) ?> <?php printf(__('%1$s, %2$s'), get_comment_date(),  get_comment_time()) ?> <?php if ( $user_ID ) comment_reply_link(array_merge( $args, array('reply_text'=>'답변','depth' => $depth, 'max_depth' => $args['max_depth']))) ?></p>
		<?php comment_text() ?>
<?php
}

// Custom excerpt length
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function custom_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

// TinyMCE Custom Buttons
function my_mce_buttons_2( $buttons ) {
	$buttons[] = 'sup';
	$buttons[] = 'sub';
	array_unshift( $buttons, 'fontsizeselect' );
	return $buttons;
}
add_filter('mce_buttons_2', 'my_mce_buttons_2');

?>