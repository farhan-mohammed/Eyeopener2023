<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?> href="<?php the_permalink(); ?>">

	<?php $post_format = get_post_format() ? get_post_format() : 'standard'; ?>

	<?php if ((has_post_thumbnail() || $post_format == 'gallery') && !post_password_required()): ?>

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
			<?php elseif (has_post_thumbnail()): ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('post-image-thumb'); ?></a>
			<?php endif; ?>

		</figure><!-- .post-image -->

	<?php endif; ?>

	<header class="post-header">

		<?php if (has_category()): ?>
			<p class="post-categories">
				<?php
				$categories = get_the_category();
				$filteredCategories = array_filter($categories, function ($category) {
					return $category->name !== 'All' && $category->name !== 'News';
				});

				foreach ($filteredCategories as $category) {
					echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
				}
				?>
			</p>
		<?php endif; ?>
		<?php if (get_the_title()): ?>
			<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php endif; ?>
		<a href="<?php the_permalink(); ?>">

			<div class="post-timeago"> <img src="/wp-content/themes/test2023/assets/img/PG12_EyeLogo.png" />


				<div class="post-timeago__text">
					<?php the_time(get_option('date_format')); ?>
				</div>

			</div>
		</a>

	</header><!-- .post-header -->

</article><!-- .post -->