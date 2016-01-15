<?php
/**
 * Single post author box template.
 */
?>

<?php if ( is_singular( 'post' ) && in_array( 'author_box', get_theme_mod( 'post_options', array( 'post_date', 'author_name' ) ) ) ) : ?>

	<section id="author-box" class="author-box" itemscope="itemscope" itemtype="http://schema.org/Person" itemprop="author">

		<div class="author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'email' ), 80, '', get_the_author() ); ?>
		</div><!-- .one-third -->

		<div class="author-info">

			<h2 class="author-box-title">
				<?php _e( 'About ', 'croft' ); ?>
					<span class="name" itemprop="name"><?php the_author(); ?></span>
			</h2>

			<?php if ( get_the_author_meta( 'description' ) ) : ?>
				<div class="description" itemprop="description">
					<?php echo wpautop( get_the_author_meta( 'description' ) ) ?>
				</div>
			<?php endif; ?>

		</div><!-- .author-info -->

	</section><!-- .author-box -->

<?php endif; ?>
