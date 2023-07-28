<?php
$currentUrl = strtok($_SERVER['REQUEST_URI'], '?'); // Remove the query string from the URL
$isFeaturesCategory = strpos($currentUrl, '/category/features') === 0 || strpos($currentUrl, '/category/special-issues') === 0;
$categories = get_the_category();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?> href="<?php the_permalink(); ?>">

	<?php $post_format = get_post_format() ? get_post_format() : 'standard'; ?>



	<figure class="post-image">
		<?php if (is_sticky()): ?>
			<a class="sticky-tag" href="<?php the_permalink(); ?>">
				<span class="fa fw fa-star"></span>
				<span class="screen-reader-text">
					<?php _e('Sticky post', 'rowling'); ?>
				</span>
			</a>
		<?php endif; ?>

		<?php if ($post_format == 'gallery'): ?>
			<?php rowling_flexslider('post-image-thumb'); ?>
		<?php else: ?>
			<?php if (has_post_thumbnail()): ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('post-image-thumb'); ?></a>
			<?php else: ?>
				<a href="<?php the_permalink(); ?>"><img src="/wp-content/themes/test2023/assets/img/PG12_EyeLogo.png"
						alt=""></a>
			<?php endif; ?>
		<?php endif; ?>



	</figure><!-- .post-image -->


	<header class="post-header">

		<?php if (has_category()): ?>
			<p class="post-categories">
				<?php
				$categories = get_the_category();
				$filteredCategories = array_filter($categories, function ($category) {
					return $category->name !== 'All' && $category->name !== 'News';
				});

				$filteredCount = count($filteredCategories);
				$maxToShow = 5;
				// Show only all cateogry if more than 5 categories
				if ($filteredCount > $maxToShow) {
					// Add "All" category
					echo '<a href="' . esc_url(get_category_link(0)) . '">All</a>';
				} else {
					foreach ($filteredCategories as $category) {
						echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
					}
				}
				?>
			</p>
		<?php endif; ?>
		<a href="<?php the_permalink(); ?>">

			<?php if (get_the_title()): ?>
				<h2 class="post-title">
					<?php the_title(); ?>
				</h2>
			<?php endif; ?>

			<div class="post-timeago"> <img src="/wp-content/themes/test2023/assets/img/PG12_EyeLogo.png" />


				<div class="post-timeago__text">
					<?php the_time(get_option('date_format')); ?>
				</div>

			</div>

			<div class="post-excerpt">
				<?php echo get_the_excerpt(); ?>
			</div>
		</a>

	</header><!-- .post-header -->

</article><!-- .post -->