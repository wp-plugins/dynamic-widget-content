<?php

class DWC_Meta_Box {

    private $buttons_added = false;

    public function __construct()
    {
        add_action( 'admin_init', array( $this, 'add_meta_box' ) );
        add_action( 'save_post', array( $this, 'save_meta_box' ) );
    }

    public function add_meta_box()
    {
        $post_types = apply_filters( 'dwc_post_types', array( 'post', 'page' ) );

        foreach( $post_types as $post_type ) {
            add_meta_box(
                'dwc_meta_box',
                'Dynamic Widget Content',
                array( $this, 'meta_box_content' ),
                $post_type,
                'normal',
                'default'
            );
        }
    }

    public function meta_box_content( $post )
    {
        include( DynamicWidgetContent::get()->coreDir . '/helpers/meta_box_content.php' );
    }

    public function save_meta_box( $post_id )
    {
        // Checks save status
        $is_autosave = wp_is_post_autosave( $post_id );
        $is_revision = wp_is_post_revision( $post_id );
        $is_valid_nonce = ( isset( $_POST[ 'dwc_nonce' ] ) && wp_verify_nonce( $_POST[ 'dwc_nonce' ], 'dynamic-widget-content' ) ) ? true : false;
     
        if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
            return;
        }
     
        if( isset( $_POST[ 'dwc-title' ] ) ) {
            update_post_meta( $post_id, 'dwc-title', sanitize_text_field( $_POST[ 'dwc-title' ] ) );
        }
        if( isset( $_POST[ 'dwc-content' ] ) ) {
            update_post_meta( $post_id, 'dwc-content', $_POST[ 'dwc-content' ] );
        }
    }
}