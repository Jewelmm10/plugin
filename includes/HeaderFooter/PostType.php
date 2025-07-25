<?php
namespace icon\starter\HeaderFooter;

class PostType {
    public function __construct() {
        add_action( 'init', [ $this, 'register_post_type' ] );
        add_filter( 'single_template', [ $this, 'custom_templates' ] );
		add_action( 'add_meta_boxes', [ $this, 'icon_register_metabox' ] );
        add_filter( 'manage_icon_template_posts_columns', [ $this, 'custom_columns' ] );
		add_filter( 'manage_icon_template_posts_custom_column', [ $this, 'display_custom_columns' ] );
    }

    public function register_post_type() {
        $labels = [
            'name'               => __( 'Templates', 'iconStarter' ),
            'singular_name'      => __( 'Template', 'iconStarter' ),
            'add_new'            => __( 'Add New', 'iconStarter' ),
            'add_new_item'       => __( 'Add New Template', 'iconStarter' ),
            'edit_item'          => __( 'Edit Template', 'iconStarter' ),
            'new_item'           => __( 'New Template', 'iconStarter' ),
            'view_item'          => __( 'View Template', 'iconStarter' ),
            'search_items'       => __( 'Search Template', 'iconStarter' ),
            'not_found'          => __( 'No Template found', 'iconStarter' ),
            'not_found_in_trash' => __( 'No Template found in Trash', 'iconStarter' ),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-twitter-alt',
            'supports'           => [ 'title', 'elementor' ],
			
        ];

        register_post_type( 'icon_template', $args );
    }

    /**
	 * Add Custom Columns in admin view table
	 *
	 * @param $columns
	 *
	 * @return mixed
	 */
	public function custom_columns( $columns ) {
		$columns[ 'type' ] = __( 'Type', 'iconStarter' );
		$columns[ 'info' ] = __( 'Info', 'iconStarter' );

		return $columns;
	}

	/**
	 * Admin Custom Columns view table content
	 *
	 * @param $name
	 *
	 * @return void
	 */
	public function display_custom_columns( $name ) {
		global $post;

		switch ( $name ) {
			case 'type':
				//echo ucwords( str_replace( '_', ' ', $this->get_template_type( $post->ID ) ) );
				break;
			case 'info':
				//echo $this->get_item_info( $post->ID );
				break;
		}
	}

    /**
	 * Get Template Type
	 *
	 * @param $post_id
	 *
	 * @return mixed|string
	 */
	public function get_template_type( $post_id ) {
		$meta = get_post_meta( $post_id, 'icon_tb_settings', true );

		return $meta[ 'template_type' ] ?? '';
	}

    public function custom_templates( $single_template ) {
		global $post;

		if ( $post->post_type == $this->type ) {
			$meta = get_post_meta( $post->ID, 'icon_tb_settings', true );

			if ( isset( $meta[ 'template_type' ] ) ) {
				$template_type = $meta[ 'template_type' ];
			} else {
				$template_type = '';
			}
		}

		return $single_template;
	}

	public function icon_register_metabox() {
		add_meta_box(
			'icon_template_settings',
			__( 'Template Settings', 'iconStarter' ),
			[ $this, 'icon_template_render' ],
			'icon_template',
			'normal',
			'high'
		);
	}

	/**
	 * Render Meta field.
	 *
	 * @param  POST $post Currennt post object which is being displayed.
	 */
	function icon_template_render( $post ) {
		$values            = get_post_custom( $post->ID );
		$template_type     = isset( $values['icon_template_type'] ) ? esc_attr( $values['icon_template_type'][0] ) : '';

		// We'll use this nonce field later on when saving.
		wp_nonce_field( 'icon_meta_nounce', 'icon_meta_nounce' );
		?>
		<table class="icon-options-table widefat">
			<tbody>
				<tr class="icon-options-row type-of-template">
					<td class="icon-options-row-heading">
						<label for="icon_template_type"><?php _e( 'Type of Template', 'iconStarter' ); ?></label>
					</td>
					<td class="icon-options-row-content">
						<select name="icon_template_type" id="icon_template_type">
							<option value="" <?php selected( $template_type, '' ); ?>><?php _e( 'Select Option', 'iconStarter' ); ?></option>
							<option value="type_topbar" <?php selected( $template_type, 'type_topbar' ); ?>><?php _e( 'Topbar', 'iconStarter' ); ?></option>
							<option value="type_header" <?php selected( $template_type, 'type_header' ); ?>><?php _e( 'Header', 'iconStarter' ); ?></option>
							<option value="type_after_header" <?php selected( $template_type, 'type_after_header' ); ?>><?php _e( 'After Header', 'iconStarter' ); ?></option>
							<option value="type_before_footer" <?php selected( $template_type, 'type_before_footer' ); ?>><?php _e( 'Before Footer', 'iconStarter' ); ?></option>
							<option value="type_footer" <?php selected( $template_type, 'type_footer' ); ?>><?php _e( 'Footer', 'iconStarter' ); ?></option>
						</select>
					</td>
				</tr>				
			</tbody>
		</table>
		<?php
	}




    
}   