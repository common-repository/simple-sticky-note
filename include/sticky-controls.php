<?php
/**
 * Sticky Note Controls
 *
 * @package Sticky Note
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class ST_Sticky_Note_Controls {	

	public function __construct() 
	{
		add_action( 'wp_enqueue_scripts', array( $this, 'st_sticky_note_ajax_enqueuer' ) );

		// insert post
		add_action( 'wp_ajax_st_sticky_note_insert', array( $this, 'st_sticky_note_insert' ) ); 
		add_action( 'wp_ajax_nopriv_st_sticky_note_insert', array( $this, 'st_sticky_note_insert' ) );

		// fetch post
		add_action( 'wp_ajax_st_sticky_note_new_added', array( $this, 'st_sticky_note_new_added' ) ); 
		add_action( 'wp_ajax_nopriv_st_sticky_note_new_added', array( $this, 'st_sticky_note_new_added' ) );

		// update post form
		add_action( 'wp_ajax_st_sticky_note_update_form', array( $this, 'st_sticky_note_update_form' ) ); 
		add_action( 'wp_ajax_nopriv_st_sticky_note_update_form', array( $this, 'st_sticky_note_update_form' ) );

		// update post
		add_action( 'wp_ajax_st_sticky_note_update', array( $this, 'st_sticky_note_update' ) ); 
		add_action( 'wp_ajax_nopriv_st_sticky_note_update', array( $this, 'st_sticky_note_update' ) );

		// delete post
		add_action( 'wp_ajax_st_sticky_note_delete', array( $this, 'st_sticky_note_delete' ) ); 
		add_action( 'wp_ajax_nopriv_st_sticky_note_delete', array( $this, 'st_sticky_note_delete' ) );

		// fetch updated post
		add_action( 'wp_ajax_st_sticky_note_updated_post', array( $this, 'st_sticky_note_updated_post' ) ); 
		add_action( 'wp_ajax_nopriv_st_sticky_note_updated_post', array( $this, 'st_sticky_note_updated_post' ) );
	}

	public static function st_sticky_note_form() 
	{
		/*
		 * Class Form Function
		 */

		if ( ! is_user_logged_in() || ! current_user_can('administrator') ) {
			return;
		}

		?>

		<form method="post" id="st-sticky-note-form" enctype="multipart/form-data">
			<?php wp_nonce_field( 'st_sticky_note_create_nonce_action', 'st_sticky_note_create_nonce_field' ); ?>
			<input type="text" id="st-title" name="st-title"  placeholder="<?php esc_attr_e( 'Note Title', 'st-sticky-note' ); ?>" />
			<?php  
				$settings = array( 
					'media_buttons' => false,
					'quicktags' 	=> false,
					'teeny'         => true,
					'textarea_name' => 'st-content', 
				);
				$content   = '';
				$editor_id = 'st-content';
				wp_editor( $content, $editor_id, $settings );
			?>
		</form>
			
		<?php
	}

	public function st_sticky_note_update_form() 
	{
		/*
		 * Class Update Form Function
		 */

		if ( ! is_user_logged_in() || ! current_user_can('administrator') ) {
			return;
		}

		$id = isset( $_POST['id'] ) ? wp_unslash( $_POST['id'] ) : '';
		$title = isset( $_POST['title'] ) ? wp_unslash( $_POST['title'] ) : '';
		$content = isset( $_POST['content'] ) ? wp_unslash( $_POST['content'] ) : '';
		?>

		<form method="post" id="st-sticky-note-update-form" enctype="multipart/form-data">
			<?php wp_nonce_field( 'st_sticky_note_create_nonce_action', 'st_sticky_note_create_nonce_field' ); ?>
			<input type="hidden" id="st-update-id" name="st-update-id"  value="<?php echo absint( $id ) ?>" />
			<input type="text" id="st-update-title" name="st-update-title"  value="<?php echo esc_attr( $title ); ?>" />
			<textarea id="st-update-content" name="st-update-content"><?php echo wp_kses_post( $content ); ?></textarea>
			<a href="#" data-id="<?php echo absint( $id ) ?>" id="st-sticky-note-delete" title="<?php esc_attr_e( 'Delete Note', 'st-sticky-note' ); ?>">
				<svg viewBox="0 0 512 512">
					<path d="M256,0C114.844,0,0,114.844,0,256s114.844,256,256,256s256-114.844,256-256S397.156,0,256,0z M359.54,329.374
					c4.167,4.165,4.167,10.919,0,15.085L344.46,359.54c-4.167,4.165-10.919,4.165-15.086,0L256,286.167l-73.374,73.374
					c-4.167,4.165-10.919,4.165-15.086,0l-15.081-15.082c-4.167-4.165-4.167-10.919,0-15.085l73.374-73.375l-73.374-73.374
					c-4.167-4.165-4.167-10.919,0-15.085l15.081-15.082c4.167-4.165,10.919-4.165,15.086,0L256,225.832l73.374-73.374
					c4.167-4.165,10.919-4.165,15.086,0l15.081,15.082c4.167,4.165,4.167,10.919,0,15.085l-73.374,73.374L359.54,329.374z"/>
				</svg>
			</a>
		</form>
			
		<?php

		die();
	}

	private function st_sticky_note_kses( $input ) {
		$input = wp_kses( $input, array(
			'a' => array(
				'href' => array(),
			),
			'img' => array(
				'src' => array(),
				'alt' => array(),
			)
		) );
		return $input;
		
	}

	public static function st_sticky_note_filter_by_author() {
		$author_filter = apply_filters( 'st_sticky_note_filter_by_author', false );

		if ( ! $author_filter ) {
			return false;
		} else {
			return true;
		}
	}

	public function st_sticky_note_ajax_enqueuer() {
	   	wp_register_script( "st-sticky-note", ST_STICKY_NOTE_URL_PATH . 'assets/js/ajax.min.js', array( 'jquery', 'imagesloaded', 'jquery-packery', 'st-sticky-note-custom' ), '', true );
	   	wp_localize_script( 'st-sticky-note', 'st_sticky_note', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'delete_confirm' => __( 'Do you want to delete this note.', 'st-sticky-note' ) ) );        
	   	wp_enqueue_script( 'st-sticky-note' );
	}
	

	public function st_sticky_note_insert() {
		if ( ! is_user_logged_in() || ! current_user_can('administrator') ) {
			return;
		}

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'st_sticky_note_create_nonce_action' ) ) {
			return;
		}

		$title = isset( $_POST['title'] ) ? wp_unslash( $_POST['title'] ) : '';
		$content = isset( $_POST['content'] ) ? wp_unslash( $_POST['content'] ) : '';

		if ( ! empty( $title ) && ! empty( $content ) ) {
			$atts = array(
				'post_title' => sanitize_text_field( $title ),
				'post_content' => wp_kses_post( $content ),
				'post_type' => 'st-sticky-note',
				'post_status' => 'publish',
			);
			wp_insert_post( $atts );

			$response = 'success';

		    // normally, the script expects a json respone
		    header( 'Content-Type: application/json; charset=utf-8' );
		    echo json_encode( $response );

		}

		die();

	}

	public function st_sticky_note_update() {
		if ( ! is_user_logged_in() || ! current_user_can('administrator') ) {
			return;
		}

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'st_sticky_note_create_nonce_action' ) ) {
			return;
		}

		$id = isset( $_POST['id'] ) ? wp_unslash( $_POST['id'] ) : '';
		$title = isset( $_POST['title'] ) ? wp_unslash( $_POST['title'] ) : '';
		$content = isset( $_POST['content'] ) ? wp_unslash( $_POST['content'] ) : '';

		if ( ! empty( $id ) && ! empty( $title ) ) {
			$atts = array(
				'ID' => absint( $id ),
				'post_title' => sanitize_text_field( $title ),
				'post_content' => wp_kses_post( $content ),
				'post_type' => 'st-sticky-note',
				'post_status' => 'publish',
			);
			wp_update_post( $atts );

			$response = 'success';

		    // normally, the script expects a json respone
		    header( 'Content-Type: application/json; charset=utf-8' );
		    echo json_encode( $response );

		}

		die();

	}

	public function st_sticky_note_delete() {
		if ( ! is_user_logged_in() || ! current_user_can('administrator') ) {
			return;
		}

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'st_sticky_note_create_nonce_action' ) ) {
			return;
		}

		$id = isset( $_POST['id'] ) ? wp_unslash( $_POST['id'] ) : '';

		if ( ! empty( $id ) ) {
			$id = absint( $id );
			wp_delete_post( $id, true );

			$response = 'success';

		    // normally, the script expects a json respone
		    header( 'Content-Type: application/json; charset=utf-8' );
		    echo json_encode( $response );

		}

		die();

	}

	public function st_sticky_note_new_added() 
	{
		$args = array(
			'post_type'			=> 'st-sticky-note',
			'posts_per_page'	=> 1,
			);

		if ( self::st_sticky_note_filter_by_author() ) {
			$args = array_merge( $args, array( 'author' => get_current_user_id() ) );
		}

		$the_query = new WP_Query( $args );
		if ( $the_query -> have_posts() ) : ?>
			
				<?php  
				/* Start the Loop */
				while ( $the_query -> have_posts() ) : $the_query -> the_post(); ?>
					<article class="grid-item st-sticky-note-item" data-id="<?php the_ID(); ?>">
						<div class="content-wrapper">
							<h4 class="entry-title"><?php the_title(); ?></h4>
							<div class="entry-content"><?php the_content(); ?></div>
							<span class="st-sticky-note-edit-info"><?php esc_html_e( 'Double Click to Edit', 'st-sticky-note' ); ?></span>
						</div>
					</article>
				<?php endwhile; ?>
			
		<?php 
		endif;
		wp_reset_postdata();
		
		die();
	}

	public function st_sticky_note_updated_post() 
	{

		$id = isset( $_POST['id'] ) ? wp_unslash( $_POST['id'] ) : '';

		$args = array(
			'post_type'			=> 'st-sticky-note',
			'p'					=> absint( $id ),
			'posts_per_page'	=> 1,
			);

		if ( self::st_sticky_note_filter_by_author() ) {
			$args = array_merge( $args, array( 'author' => get_current_user_id() ) );
		}

		$the_query = new WP_Query( $args );
		if ( $the_query -> have_posts() ) : ?>
			
				<?php  
				/* Start the Loop */
				while ( $the_query -> have_posts() ) : $the_query -> the_post(); ?>
					<article class="grid-item st-sticky-note-item" data-id="<?php the_ID(); ?>">
						<div class="content-wrapper">
							<h4 class="entry-title"><?php the_title(); ?></h4>
							<div class="entry-content"><?php the_content(); ?></div>
							<span class="st-sticky-note-edit-info"><?php esc_html_e( 'Double Click to Edit', 'st-sticky-note' ); ?></span>
						</div>
					</article>
				<?php endwhile; ?>
			
		<?php 
		endif;
		wp_reset_postdata();		
		
		die();
	}


}

new ST_Sticky_Note_Controls();