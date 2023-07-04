</main><!-- #site-content -->

<footer class="credits">
	<div class="section-inner">
		<a href="#" class="to-the-top">
			<div class="fa fw fa-angle-up"></div>
			<span class="screen-reader-text">
				<?php _e('To the top', 'rowling'); ?>
			</span>
		</a>
		<?php if (is_active_sidebar('footer-widget-area')): ?>
			<div id="footer-widget-area" class="footer-widget-area">
				<?php dynamic_sidebar('footer-widget-area'); ?>
			</div>
		<?php endif; ?>
	</div><!-- .section-inner -->
</footer><!-- .credits -->

<?php wp_footer(); ?>

</body>

</html>