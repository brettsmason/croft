<?php
class Croft_Hide_Page_Title {

	public function __construct() {

		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	public function init_metabox() {

		add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
		add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );

	}

	public function add_metabox() {

		add_meta_box(
			'hide-page-title',
			__( 'Page Title', 'croft' ),
			array( $this, 'render_metabox' ),
			'page',
			'side',
			'low'
		);

	}

	public function render_metabox( $post ) { ?>

		<?php
		// Add nonce for security and authentication.
		wp_nonce_field( 'hide_page_title_nonce_action', 'hide_page_title_nonce' );

		// Retrieve an existing value from the database.
		$hide_page_title = get_post_meta( $post->ID, 'hide_page_title', true );
		// Set default values.
		if( empty( $hide_page_title ) ) $hide_page_title = '';

		// Form fields.
		?>

		<p>
			<label><input type="checkbox" name="hide_page_title" id="hide-page-title" value="1" <?php checked( get_post_meta( $post->ID, 'hide_page_title', true ), 1 ); ?>>Hide Page Title</label>
		</p>

	<?php }

	public function save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		$nonce_name   = $_POST['hide_page_title_nonce'];
		$nonce_action = 'hide_page_title_nonce_action';

		// Check if a nonce is set.
		if ( ! isset( $nonce_name ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;

		// Check if the user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

		// Check if it's not an autosave.
		if ( wp_is_post_autosave( $post_id ) )
			return;

		// Check if it's not a revision.
		if ( wp_is_post_revision( $post_id ) )
			return;

		// Sanitize user input.
		$new_hide_page_title  = isset( $_POST[ 'hide_page_title' ] )  ? $_POST[ 'hide_page_title' ] : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'hide_page_title', $new_hide_page_title );

	}
}

new Croft_Hide_Page_Title;