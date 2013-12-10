<?php get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<article id="post-<?php the_ID(); ?>">
				<header>
					<h2>404</h2>
				</header><!-- .entry-header -->

				<div class="entry-content">
					Not found
				</div><!-- .entry-content -->

				<footer class="entry-meta">
					<?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
				</footer><!-- .entry-meta -->
			</article><!-- #post -->


		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>