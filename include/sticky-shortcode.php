<?php
/**
 * Sticky Note Shortcode
 *
 * @package Sticky Note
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class ST_Sticky_Note_Shortcode {

	/*
	 * SHORTCODES
	 *
	 * Sticky Note shortcode:
	 * [ST_STICKY_NOTE]
	 *
	 * Sticky Note with column option shortcode:
	 * [ST_STICKY_NOTE column="3"]
	 */
	

	public function __construct() 
	{
		$this->st_sticky_note_create_shortcode();
	}

	public function st_sticky_note_shortcode_function( $atts ) 
	{
		/*
		 * Sticky Note Shortcode Function
		 */
		
		ob_start(); 

		$input = shortcode_atts( array(
			    'column' => 3
			), $atts );
		?>
			<div class="st-sticky-note-wrapper close">
				<div class="overlay"></div>
				<div class="update-overlay"></div>

				<?php
				ST_Sticky_Note_Controls::st_sticky_note_form();

				$args = array(
					'post_type'			=> 'st-sticky-note',
					'posts_per_page'	=> -1,
					);

				if ( ST_Sticky_Note_Controls::st_sticky_note_filter_by_author() ) {
					$args = array_merge( $args, array( 'author' => get_current_user_id() ) );
				}

				$the_query = new WP_Query( $args ); ?>
					<div class="st-sticky-note column-<?php echo absint( $input['column'] ); ?>">
						<?php  
						/* Start the Loop */
						if ( $the_query -> have_posts() ) : while ( $the_query -> have_posts() ) : $the_query -> the_post(); ?>
							<article class="grid-item st-sticky-note-item" data-id="<?php the_ID(); ?>">
								<div class="content-wrapper">
									<h4 class="entry-title"><?php the_title(); ?></h4>
									<div class="entry-content"><?php the_content(); ?></div>
									<span class="st-sticky-note-edit-info"><?php esc_html_e( 'Double Click to Edit', 'st-sticky-note' ); ?></span>
								</div>
							</article>
						<?php endwhile; endif; ?>
					</div><!-- .st-sticky-note -->
				<?php 
				wp_reset_postdata(); ?>

			</div><!-- .st-sticky-note-wrapper -->
		<?php return ob_get_clean();
	}

	public function st_sticky_note_create_shortcode() 
	{
		/*
		 * Create Shortcodes
		 */
		add_shortcode( 'ST_STICKY_NOTE', array( $this, 'st_sticky_note_shortcode_function' ) );
	}

}

new ST_Sticky_Note_Shortcode();

