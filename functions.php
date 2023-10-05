<?php


/* ---------------------------------------------------------------------------------------------
   THEME SETUP
   --------------------------------------------------------------------------------------------- */


if (!function_exists('rowling_setup')):
	function rowling_setup()
	{

		// Automatic feed
		add_theme_support('automatic-feed-links');

		// Title tag
		add_theme_support('title-tag');

		// Add post format support
		add_theme_support('post-formats', array('gallery'));

		// Set content-width
		global $content_width;
		if (!isset($content_width))
			$content_width = 616;

		// Post thumbnails
		add_theme_support('post-thumbnails');
		set_post_thumbnail_size(88, 88, true);

		add_image_size('post-image', 816, 9999);
		add_image_size('post-image-thumb', 400, 200, true);

		// Add nav menus
		register_nav_menu('primary', __('Primary Menu', 'rowling'));
		register_nav_menu('secondary', __('Secondary Menu', 'rowling'));
		register_nav_menu('social', __('Social Menu', 'rowling'));

		// Custom logo
		add_theme_support(
			'custom-logo',
			array(
				'height' => 240,
				'width' => 320,
				'flex-height' => true,
				'flex-width' => true,
				'header-text' => array('blog-title', 'blog-description'),
			)
		);

		// Make the theme translation ready
		load_theme_textdomain('rowling', get_template_directory() . '/languages');

	}
	add_action('after_setup_theme', 'rowling_setup');
	function limit_homepage_posts($query)
	{
		if ($query->is_main_query()) {
			$query->set('posts_per_page', 12);
		}
	}
	add_action('pre_get_posts', 'limit_homepage_posts');
	function has_special_issues_category($categories)
	{
		$special_issues_category = 'Special Issues';
		foreach ($categories as $category) {
			if ($category->name === $special_issues_category) {
				return true;
			}
		}
		return false;
	}
	function has_features_category($categories)
	{
		$features_category = 'Features';
		foreach ($categories as $category) {
			if ($category->name === $features_category) {
				return true;
			}
		}
		return false;
	}
	add_action('after_setup_theme', 'has_features_category');

endif;


/* ---------------------------------------------------------------------------------------------
   ENQUEUE JAVASCRIPT
   --------------------------------------------------------------------------------------------- */

if (!function_exists('rowling_load_javascript_files')):
	function rowling_load_javascript_files()
	{

		$theme_version = wp_get_theme('rowling')->get('Version');

		wp_register_script('rowling_flexslider', get_template_directory_uri() . '/assets/js/flexslider.js', '2.4.0', true);
		wp_register_script('rowling_doubletap', get_template_directory_uri() . '/assets/js/doubletaptogo.js', $theme_version, true);

		wp_enqueue_script('rowling_global', get_template_directory_uri() . '/assets/js/global.js', array('jquery', 'rowling_flexslider', 'rowling_doubletap'), $theme_version, true);

		if (is_singular())
			wp_enqueue_script('comment-reply');

	}
	add_action('wp_enqueue_scripts', 'rowling_load_javascript_files');
endif;


/* ---------------------------------------------------------------------------------------------
   ENQUEUE STYLES
   --------------------------------------------------------------------------------------------- */

if (!function_exists('rowling_load_style')):
	function rowling_load_style()
	{

		if (is_admin())
			return;

		$theme_version = wp_get_theme('rowling')->get('Version');
		$dependencies = array();

		wp_register_style('rowling_google_fonts', get_theme_file_uri('/assets/css/fonts.css'));
		$dependencies[] = 'rowling_google_fonts';

		wp_register_style('rowling_fontawesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '5.13.0');
		$dependencies[] = 'rowling_fontawesome';

		wp_enqueue_style('rowling_style', get_stylesheet_uri(), $dependencies, $theme_version);

	}
	add_action('wp_print_styles', 'rowling_load_style');
endif;


/* ---------------------------------------------------------------------------------------------
   ADD EDITOR STYLES
   --------------------------------------------------------------------------------------------- */

if (!function_exists('rowling_add_editor_styles')):
	function rowling_add_editor_styles()
	{

		add_editor_style('assets/css/rowling-classic-editor-styles.css', '/assets/css/fonts.css');

	}
	add_action('init', 'rowling_add_editor_styles');
endif;


/* ---------------------------------------------------------------------------------------------
   ADD WIDGET AREAS
   --------------------------------------------------------------------------------------------- */

if (!function_exists('rowling_sidebar_registration')):
	function rowling_sidebar_registration()
	{

		register_sidebar(
			array(
				'name' => __('Sidebar', 'rowling'),
				'id' => 'sidebar',
				'description' => __('Widgets in this area will be shown in the sidebar.', 'rowling'),
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
				'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget' => '</div></div>'
			)
		);

	}
	add_action('widgets_init', 'rowling_sidebar_registration');
	function footer_widget_area()
	{
		register_sidebar(
			array(
				'name' => 'Footer Widget Area',
				'id' => 'footer-widget-area',
				'description' => 'Widgets in this area will be displayed in the footer.',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h2 class="widget-title">',
				'after_title' => '</h2>',
			)
		);
	}
	add_action('widgets_init', 'footer_widget_area');

endif;


/* ---------------------------------------------------------------------------------------------
   INCLUDE REQUIRED FILES
   --------------------------------------------------------------------------------------------- */

// Theme Customizer options.
require get_template_directory() . '/inc/classes/class-rowling-customizer.php';

// Recent Comments widget
require get_template_directory() . '/inc/widgets/recent-comments.php';

// Recent Posts widget
require get_template_directory() . '/inc/widgets/recent-posts.php';


/* ---------------------------------------------------------------------------------------------
   MODIFY WIDGETS
   --------------------------------------------------------------------------------------------- */

if (!function_exists('rowling_unregister_default_widgets')):
	function rowling_unregister_default_widgets()
	{

		// Register custom widgets
		register_widget('Rowling_Recent_Comments');
		register_widget('Rowling_Recent_Posts');

		// Unregister replaced widgets
		unregister_widget('WP_Widget_Recent_Comments');
		unregister_widget('WP_Widget_Recent_Posts');

	}
	add_action('widgets_init', 'rowling_unregister_default_widgets', 11);
endif;


/* ---------------------------------------------------------------------------------------------
   CHECK FOR JAVASCRIPT
   --------------------------------------------------------------------------------------------- */

if (!function_exists('rowling_html_js_class')) {
	function rowling_html_js_class()
	{

		echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>' . "\n";

	}
	add_action('wp_head', 'rowling_html_js_class', 1);
}


/* ---------------------------------------------------------------------------------------------
   RELATED POSTS FUNCTION
   --------------------------------------------------------------------------------------------- */

if (!function_exists('rowling_related_posts')):
	function rowling_related_posts($number_of_posts = 3)
	{
		?>
		<div id="jp-relatedposts" class="jp-relatedposts" style="display: block;">
			<h3 class="jp-relatedposts-headline"><em>Related</em></h3>
			<div class="jp-relatedposts-items jp-relatedposts-items-visual jp-relatedposts-grid ">
				<div class="jp-relatedposts-post jp-relatedposts-post0 jp-relatedposts-post-thumbs" data-post-id="112059"
					data-post-format="false"><a class="jp-relatedposts-post-a"
						href="/2023/01/tmu-snaps-losing-skid-at-winter-homecoming-game/?relatedposts_hit=1&amp;relatedposts_origin=114891&amp;relatedposts_position=0"
						title="TMU snaps losing skid at Winter Homecoming game" data-origin="114891" data-position="0"><img
							class="jp-relatedposts-post-img" loading="lazy"
							src="https://i0.wp.com/theeyeopener.com/wp-content/uploads/2023/01/TMUMHKY_MatthewLin_Jan20.gif?resize=350%2C200&amp;ssl=1"
							width="350" height="200" alt="A hockey player in a blue jersey"></a>
					<h4 class="jp-relatedposts-post-title"><a class="jp-relatedposts-post-a"
							href="/2023/01/tmu-snaps-losing-skid-at-winter-homecoming-game/?relatedposts_hit=1&amp;relatedposts_origin=114891&amp;relatedposts_position=0"
							title="TMU snaps losing skid at Winter Homecoming game" data-origin="114891" data-position="0">TMU
							snaps losing skid at Winter Homecoming game</a></h4>
					<p class="jp-relatedposts-post-excerpt">The TMU men's hockey team snapped their three game losing streak
						Friday at home</p><time class="jp-relatedposts-post-date" datetime="January 20, 2023"
						style="display: block;">January 20, 2023</time>
					<p class="jp-relatedposts-post-context">In "All"</p>
				</div>
				<div class="jp-relatedposts-post jp-relatedposts-post1 jp-relatedposts-post-thumbs" data-post-id="112017"
					data-post-format="false"><a class="jp-relatedposts-post-a"
						href="/2023/01/second-straight-loss-leaves-bold-looking-for-change/?relatedposts_hit=1&amp;relatedposts_origin=114891&amp;relatedposts_position=1"
						title="Second straight loss leaves Bold looking for change" data-origin="114891" data-position="1"><img
							class="jp-relatedposts-post-img" loading="lazy"
							src="https://i0.wp.com/theeyeopener.com/wp-content/uploads/2023/01/MHKY-vs-York-Feature.jpg?resize=350%2C200&amp;ssl=1"
							width="350" height="200"
							alt="A TMU men's hockey player chews on his mouthguard with one knee on the ice"></a>
					<h4 class="jp-relatedposts-post-title"><a class="jp-relatedposts-post-a"
							href="/2023/01/second-straight-loss-leaves-bold-looking-for-change/?relatedposts_hit=1&amp;relatedposts_origin=114891&amp;relatedposts_position=1"
							title="Second straight loss leaves Bold looking for change" data-origin="114891"
							data-position="1">Second straight loss leaves Bold looking for change</a></h4>
					<p class="jp-relatedposts-post-excerpt">The TMU men's hockey team lost its second consecutive game Saturday
						and are looking for change as they continue their season</p><time class="jp-relatedposts-post-date"
						datetime="January 14, 2023" style="display: block;">January 14, 2023</time>
					<p class="jp-relatedposts-post-context">In "All"</p>
				</div>
				<div class="jp-relatedposts-post jp-relatedposts-post2 jp-relatedposts-post-thumbs" data-post-id="111588"
					data-post-format="false"><a class="jp-relatedposts-post-a"
						href="/2022/11/opportunity-to-host-nationals-once-in-a-lifetime-for-bold/?relatedposts_hit=1&amp;relatedposts_origin=114891&amp;relatedposts_position=2"
						title="Opportunity to host nationals &amp;#8216;once in a lifetime&amp;#8217; for Bold"
						data-origin="114891" data-position="2"><img class="jp-relatedposts-post-img" loading="lazy"
							src="https://i0.wp.com/theeyeopener.com/wp-content/uploads/2022/11/TMUMHKY_NathanGerson_NOV.21.gif?resize=350%2C200&amp;ssl=1"
							width="350" height="200" alt="Two hockey players in white jerseys celebrate"></a>
					<h4 class="jp-relatedposts-post-title"><a class="jp-relatedposts-post-a"
							href="/2022/11/opportunity-to-host-nationals-once-in-a-lifetime-for-bold/?relatedposts_hit=1&amp;relatedposts_origin=114891&amp;relatedposts_position=2"
							title="Opportunity to host nationals &amp;#8216;once in a lifetime&amp;#8217; for Bold"
							data-origin="114891" data-position="2">Opportunity to host nationals ‘once in a lifetime’ for
							Bold</a></h4>
					<p class="jp-relatedposts-post-excerpt">There’s still lots of hockey left to be played before TMU can look
						toward nationals in 2024</p><time class="jp-relatedposts-post-date" datetime="November 21, 2022"
						style="display: block;">November 21, 2022</time>
					<p class="jp-relatedposts-post-context">In "All"</p>
				</div>
			</div>
		</div>
		<div class="related-posts">

			<p class="related-posts-title">
				<?php _e('Read Next', 'rowling'); ?> &rarr;
			</p>

			<div class="row">

				<?php

				global $post;

				// Base args, used for both the term query and random query
				$base_args = array(
					'ignore_sticky_posts' => true,
					'meta_key' => '_thumbnail_id',
					'posts_per_page' => $number_of_posts,
					'post_status' => 'publish',
					'post__not_in' => array($post->ID),
				);

				// Create a query for posts in the same category as the ones for the current post
				$cat_ids = array();

				$categories = get_the_category();

				foreach ($categories as $category) {
					$cat_ids[] = $category->cat_ID;
				}

				$term_posts_args = array_merge($base_args, array('category__in' => $cat_ids));

				$related_posts = get_posts($term_posts_args);

				// No results for the categories? Get random posts instead
				if (!$related_posts):

					$random_posts_args = array_merge($base_args, array('orderby' => 'rand'));

					$related_posts = get_posts($random_posts_args);

				endif;

				// If either the category query or random query hit pay dirt, output the posts
				if ($related_posts):

					foreach ($related_posts as $related_post): ?>

						<a class="related-post" href="<?php echo get_the_permalink($related_post->ID); ?>">

							<?php if (has_post_thumbnail($related_post->ID)): ?>

								<?php echo get_the_post_thumbnail($related_post->ID, 'post-image-thumb') ?>

							<?php endif; ?>

							<p class="category">
								<?php
								$category = get_the_category($related_post->ID);
								echo $category[0]->cat_name;
								?>
							</p>

							<h3 class="title">
								<?php echo get_the_title($related_post->ID); ?>
							</h3>

						</a>

						<?php

					endforeach;

				endif;

				?>

			</div><!-- .row -->

		</div><!-- .related-posts -->

		<?php

	}
endif;


/* ---------------------------------------------------------------------------------------------
   ARCHIVE NAVIGATION
   --------------------------------------------------------------------------------------------- */

if (!function_exists('rowling_archive_navigation')):
	function rowling_archive_navigation()
	{

		get_template_part('pagination');

	}
endif;


/* ---------------------------------------------------------------------------------------------
   CUSTOM READ MORE TEXT
   --------------------------------------------------------------------------------------------- */

if (!function_exists('rowling_modify_read_more_link')):
	function rowling_modify_read_more_link()
	{

		return '<p><a class="more-link" href="' . get_permalink() . '">' . __('Read More', 'rowling') . '</a></p>';

	}
	add_filter('the_content_more_link', 'rowling_modify_read_more_link');
endif;


/* ---------------------------------------------------------------------------------------------
   BODY CLASSES
   --------------------------------------------------------------------------------------------- */

if (!function_exists('rowling_body_classes')):
	function rowling_body_classes($classes)
	{

		// If has post thumbnail
		if (is_single() && has_post_thumbnail()) {
			$classes[] = 'has-featured-image';
		}

		return $classes;

	}
	add_filter('body_class', 'rowling_body_classes');
endif;


/* ---------------------------------------------------------------------------------------------
   GET COMMENT EXCERPT LENGTH
   --------------------------------------------------------------------------------------------- */

if (!function_exists('rowling_get_comment_excerpt')):
	function rowling_get_comment_excerpt($comment_ID = 0, $num_words = 20)
	{

		$comment = get_comment($comment_ID);
		$comment_text = strip_tags($comment->comment_content);
		$blah = explode(' ', $comment_text);

		if (count($blah) > $num_words) {
			$k = $num_words;
			$use_dotdotdot = 1;
		} else {
			$k = count($blah);
			$use_dotdotdot = 0;
		}

		$excerpt = '';

		for ($i = 0; $i < $k; $i++) {
			$excerpt .= $blah[$i] . ' ';
		}

		$excerpt .= ($use_dotdotdot) ? '...' : '';

		return apply_filters('get_comment_excerpt', $excerpt);

	}
endif;


/* ---------------------------------------------------------------------------------------------
   FLEXSLIDER FUNCTION
   --------------------------------------------------------------------------------------------- */

if (!function_exists('rowling_flexslider')):
	function rowling_flexslider($size)
	{

		$attachment_parent = is_page() ? $post->ID : get_the_ID();

		$images = get_posts(
			array(
				'numberposts' => -1,
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'post_mime_type' => 'image',
				'post_parent' => $attachment_parent,
				'post_status' => null,
				'post_type' => 'attachment',
			)
		);

		if (!$images)
			return;

		?>

		<?php if (!is_single()): // Make it a link if it's an archive ?>
			<a class="flexslider" href="<?php the_permalink(); ?>">
			<?php else: // ...and just a div if it's a single post ?>
				<div class="flexslider">
				<?php endif; ?>

				<ul class="slides reset-list-style">

					<?php foreach ($images as $image):

						$attimg = wp_get_attachment_image($image->ID, $size);

						if (!$attimg)
							continue;

						?>

						<li>
							<?php

							echo $attimg;

							if (!empty($image->post_excerpt) && is_single()): ?>
								<p class="post-image-caption"><span class="fa fw fa-camera"></span>
									<?php echo $image->post_excerpt; ?>
								</p>
							<?php endif; ?>
						</li>

					<?php endforeach; ?>

				</ul><!-- .slides -->

				<?php
				echo !is_single() ? '</a>' : '</div>';

	}
endif;


/* ---------------------------------------------------------------------------------------------
   COMMENT FUNCTION
   --------------------------------------------------------------------------------------------- */

if (!function_exists('rowling_comment')):
	function rowling_comment($comment, $args, $depth)
	{

		switch ($comment->comment_type):
			case 'pingback':
			case 'trackback':
				?>

						<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

							<?php __('Pingback:', 'rowling'); ?>
							<?php comment_author_link(); ?>
							<?php edit_comment_link(__('Edit', 'rowling'), '<span class="edit-link">', '</span>'); ?>

						</li>
						<?php
						break;
			default:
				global $post;
				?>
						<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

							<div id="comment-<?php comment_ID(); ?>" class="comment">

								<?php echo get_avatar($comment, 160); ?>

								<?php if ($comment->user_id === $post->post_author): ?>

									<a class="comment-author-icon" href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
										<div class="fa fw fa-user"></div>
										<span class="screen-reader-text">
											<?php _e('Comment by post author', 'rowling'); ?>
										</span>
									</a>

								<?php endif; ?>

								<div class="comment-inner">

									<div class="comment-header">

										<h4>
											<?php echo get_comment_author_link(); ?>
										</h4>

									</div><!-- .comment-header -->

									<div class="comment-content post-content entry-content">

										<?php comment_text(); ?>

									</div><!-- .comment-content -->

									<div class="comment-meta group">

										<div class="fleft">
											<div class="fa fw fa-clock-o"></div><a class="comment-date-link"
												href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
												<?php echo get_comment_date(get_option('date_format')); ?>
											</a>
											<?php edit_comment_link(__('Edit', 'rowling'), '<div class="fa fw fa-wrench"></div>', ''); ?>
										</div>

										<?php if ('0' == $comment->comment_approved): ?>

											<div class="comment-awaiting-moderation fright">
												<div class="fa fw fa-exclamation-circle"></div>
												<?php _e('Awaiting moderation', 'rowling'); ?>
											</div>

										<?php else:

											comment_reply_link(
												array(
													'reply_text' => __('Reply', 'rowling'),
													'depth' => $depth,
													'max_depth' => $args['max_depth'],
													'before' => '<div class="fright"><div class="fa fw fa-reply"></div>',
													'after' => '</div>'
												)
											);

										endif; ?>

									</div><!-- .comment-meta -->

								</div><!-- .comment-inner -->

							</div><!-- .comment-## -->

							<?php
							break;
		endswitch;

	}
endif;


/* ---------------------------------------------------------------------------------------------
   SPECIFY BLOCK EDITOR SUPPORT
------------------------------------------------------------------------------------------------ */

if (!function_exists('rowling_add_block_editor_features')):
	function rowling_add_block_editor_features()
	{

		/* Block Editor Features ------------- */

		add_theme_support('align-wide');

		/* Block Editor Palette -------------- */

		$accent_color = get_theme_mod('accent_color', '#0093C2');

		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name' => _x('Accent', 'Name of the accent color in the Block Editor palette', 'rowling'),
					'slug' => 'accent',
					'color' => $accent_color,
				),
				array(
					'name' => _x('Black', 'Name of the black color in the Block Editor palette', 'rowling'),
					'slug' => 'black',
					'color' => '#111',
				),
				array(
					'name' => _x('Dark Gray', 'Name of the dark gray color in the Block Editor palette', 'rowling'),
					'slug' => 'dark-gray',
					'color' => '#333',
				),
				array(
					'name' => _x('Medium Gray', 'Name of the medium gray color in the Block Editor palette', 'rowling'),
					'slug' => 'medium-gray',
					'color' => '#555',
				),
				array(
					'name' => _x('Light Gray', 'Name of the light gray color in the Block Editor palette', 'rowling'),
					'slug' => 'light-gray',
					'color' => '#777',
				),
				array(
					'name' => _x('White', 'Name of the white color in the Block Editor palette', 'rowling'),
					'slug' => 'white',
					'color' => '#fff',
				),
			)
		);

		/* Block Editor Font Sizes ----------- */

		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name' => _x('Small', 'Name of the small font size in Block Editor', 'rowling'),
					'shortName' => _x('S', 'Short name of the small font size in the Block Editor.', 'rowling'),
					'size' => 15,
					'slug' => 'small',
				),
				array(
					'name' => _x('Normal', 'Name of the normal font size in Block Editor', 'rowling'),
					'shortName' => _x('N', 'Short name of the normal font size in the Block Editor.', 'rowling'),
					'size' => 17,
					'slug' => 'normal',
				),
				array(
					'name' => _x('Large', 'Name of the large font size in Block Editor', 'rowling'),
					'shortName' => _x('L', 'Short name of the large font size in the Block Editor.', 'rowling'),
					'size' => 24,
					'slug' => 'large',
				),
				array(
					'name' => _x('Larger', 'Name of the larger font size in Block Editor', 'rowling'),
					'shortName' => _x('XL', 'Short name of the larger font size in the Block Editor.', 'rowling'),
					'size' => 28,
					'slug' => 'larger',
				),
			)
		);

	}
	add_action('after_setup_theme', 'rowling_add_block_editor_features');
endif;


/* ---------------------------------------------------------------------------------------------
   BLOCK EDITOR EDITOR STYLES
   --------------------------------------------------------------------------------------------- */

if (!function_exists('rowling_block_editor_styles')):
	function rowling_block_editor_styles()
	{

		$theme_version = wp_get_theme('rowling')->get('Version');

		wp_register_style('rowling-block-editor-styles-font', get_theme_file_uri('/assets/css/fonts.css'));
		wp_enqueue_style('rowling-block-editor-styles', get_theme_file_uri('/assets/css/rowling-block-editor-styles.css'), array('rowling-block-editor-styles-font'), $theme_version, 'all');

	}
	add_action('enqueue_block_editor_assets', 'rowling_block_editor_styles', 1);
endif;