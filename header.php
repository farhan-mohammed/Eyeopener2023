<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@100;200;300;400;500;600;700;800;900&display=swap"
		rel="stylesheet">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="/wp-content/themes/test2023/assets/img/favicon.png">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<?php if (function_exists('wp_body_open')) {
		wp_body_open();
	} ?>
	<a class="skip-link button" href="#site-content">
		<?php _e('Skip to the content', 'rowling'); ?>
	</a>


	<header class="header-wrapper">
		<?php if (has_nav_menu('secondary') || has_nav_menu('social')): ?>
			<div class="top-nav">
				<div class="section-inner group">
					<?php if (has_nav_menu('secondary')): ?>
						<ul class="secondary-menu dropdown-menu reset-list-style">
							<?php
							wp_nav_menu(
								array(
									'container' => '',
									'items_wrap' => '%3$s',
									'theme_location' => 'secondary'
								)
							);
							?>
						</ul><!-- .secondary-menu -->
					<?php endif; ?>
					<img src="/wp-content/themes/test2023/assets/img/PG12_EyeLogo.png" class='eyelogo' />

					<?php if (has_nav_menu('social')): ?>
						<ul class="social-menu reset-list-style">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'social',
									'container' => '',
									'container_class' => 'menu-social',
									'items_wrap' => '%3$s',
									'menu_id' => 'menu-social-items',
									'menu_class' => 'menu-items',
									'depth' => 1,
									'link_before' => '<span class="screen-reader-text">',
									'link_after' => '</span>',
									'fallback_cb' => '',
								)
							);
							echo '<li id="menu-item-151" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-151"><a class="search-toggle" href="?s"><span class="screen-reader-text">Search</span></a></li>';
							?>
						</ul><!-- .social-menu -->
					<?php endif; ?>
				</div><!-- .section-inner -->

			</div><!-- .top-nav -->

		<?php endif; ?>

		<div class="search-container">

			<div class="section-inner">

				<?php get_search_form(); ?>

			</div><!-- .section-inner -->

		</div><!-- .search-container -->

		<div class="header">

			<div class="section-inner">

				<?php

				$custom_logo_id = get_theme_mod('custom_logo');
				$blog_title_elem = ((is_front_page() || is_home()) && !is_page()) ? 'h1' : 'div';
				$blog_title_class = $custom_logo_id ? 'blog-logo' : 'blog-title';

				$blog_title = get_bloginfo('title');
				$blog_description = get_bloginfo('description');

				$custom_logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
				?>
				<div class="blog-header">
					<<?php echo $blog_title_elem; ?> class="
						<?php echo esc_attr($blog_title_class); ?>">
						<a class="logo" href="<?php echo esc_url(home_url('/')); ?>" rel="home">

							<img src="<?php echo esc_url($custom_logo_url); ?>"
								onerror="this.src='/wp-content/themes/test2023/assets/img/theye.png';">
							<span class="screen-reader-text">
								<?php echo $blog_title; ?>
							</span>
						</a>
					</<?php echo $blog_title_elem; ?>>
					<div class="blog-description">
						<?php echo wpautop($blog_description); ?>
					</div>
				</div>



				<div class="nav-toggle">

					<div class="bars">
						<div class="bar"></div>
						<div class="bar"></div>
						<div class="bar"></div>
					</div>

				</div><!-- .nav-toggle -->

			</div><!-- .section-inner -->

		</div><!-- .header -->

		<div class="navigation">

			<div class="section-inner group">

				<ul id='nav' class="primary-menu reset-list-style dropdown-menu">

					<?php if (has_nav_menu('primary')) {

						$nav_args = array(
							'container' => '',
							'items_wrap' => '%3$s',
							'theme_location' => 'primary'
						);

						wp_nav_menu($nav_args);

					} else {

						$list_pages_args = array(
							'container' => '',
							'title_li' => ''
						);

						wp_list_pages($list_pages_args);

					} ?>

				</ul>

			</div><!-- .section-inner -->

		</div><!-- .navigation -->

		<ul class="mobile-menu reset-list-style">

			<?php
			if (has_nav_menu('primary')) {
				wp_nav_menu($nav_args);
			} else {
				wp_list_pages($list_pages_args);
			}
			?>

		</ul><!-- .mobile-menu -->

	</header><!-- .header-wrapper -->

	<main id="site-content">