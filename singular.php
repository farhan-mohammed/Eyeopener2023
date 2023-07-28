<?php get_header(); ?>
<div class="wrapper section-inner group">
	<div
		class="content 1 <?php echo ((has_features_category(get_the_category()) || has_special_issues_category(get_the_category())) ? 'full' : 'x'); ?>">

		<?php
		if (have_posts()):
			while (have_posts()):

				the_post();
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('single single-post group'); ?>>

					<div class="post-header">

						<?php


						if (is_single()):

							$author_id = get_the_author_meta('ID');
							$author_posts_url = get_author_posts_url($author_id);

							?>

							<div class="post-meta">

								<span class="resp">
									<?php _e('Posted', 'rowling'); ?>
								</span> <span class="post-meta-author">
									<?php _e('by', 'rowling'); ?> <a href="<?php echo esc_url($author_posts_url); ?>"><?php the_author_meta('display_name'); ?></a>
								</span> <span class="post-meta-date">
									<?php _e('on', 'rowling'); ?> <a href="<?php the_permalink(); ?>"><?php the_time(get_option('date_format')); ?></a>
								</span>
								<?php edit_post_link(__('Edit', 'rowling'), ' &mdash; '); ?>

								<?php if (comments_open() && !post_password_required()): ?>
									<span class="post-comments">
										<?php
										comments_popup_link(
											'<span class="fa fw fa-comment"></span>0<span class="resp"> ' . __('Comments', 'rowling') . '</span>',
											'<span class="fa fw fa-comment"></span>1<span class="resp"> ' . __('Comment', 'rowling') . '</span>',
											'<span class="fa fw fa-comment"></span>%<span class="resp"> ' . __('Comments', 'rowling') . '</span>'
										);
										?>
									</span>
								<?php endif; ?>

							</div><!-- .post-meta -->

						<?php endif; ?>

					</div><!-- .post-header -->

					<?php

					$post_format = get_post_format() ? get_post_format() : 'standard';

					if ($post_format == 'gallery' && !post_password_required()):

						rowling_flexslider('post-image');

					elseif (has_post_thumbnail() && !post_password_required()): ?>

						<figure
							class="post-image <?php echo ((is_single() && has_special_issues_category(get_the_category())) ? 'hidden' : 'xo'); ?>">
							<?php the_post_thumbnail('post-image'); ?>
						</figure><!-- .post-image -->

						<?php
					endif;


					?>
					<?php if (is_single() && has_category()): ?>
						<div class="post-categories">
							<?php the_category(' '); ?>
						</div>
						<?php
					endif; ?>
					<?php the_title('<h1 class="post-title">', '</h1>');
					?>
					<div class="post-date">
						<?php the_time(get_option('date_format')); ?>
					</div>
					<div class="post-inner">

						<div class="post-content entry-content">

							<?php

							the_content();

							wp_link_pages(
								array(
									'before' => '<p class="page-links"><span class="title">' . __('Pages:', 'rowling') . '</span>',
									'after' => '</p>',
									'link_before' => '<span>',
									'link_after' => '</span>',
									'separator' => '',
									'pagelink' => '%',
									'echo' => 1
								)
							);

							?>

						</div><!-- .post-content -->


					</div><!-- .post-inner -->

				</article><!-- .post -->

				<?php if (is_single()):
					rowling_related_posts();
				endif; ?>
				<?php

				comments_template('', true);

			endwhile;
		endif;
		?>

	</div><!-- .content -->

	<?php get_sidebar(); ?>

</div><!-- .wrapper -->

<?php get_footer(); ?>