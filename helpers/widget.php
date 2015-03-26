<?php

class DWC_Widget extends WP_Widget {

    public function __construct()
    {
        parent::__construct(
            'dwc_widget',
            'Dynamic Widget Content',
            array(
                'description' => __( 'Page and post specific widget content.', 'dynamic-widget-content' )
            )
        );
    }

    public function widget( $args, $instance )
    {
        if( !is_singular() ) return;

        $post_id = get_the_ID();

        // Check post type
        $post_type = get_post_type( $post_id );
        $post_types = DynamicWidgetContent::option( 'meta_box_post_types', array( 'post', 'page' ) );

        if( !in_array( $post_type, $post_types ) ) return;

        // Get data
        $title = get_post_meta( $post_id, 'dwc-title', true );
        $content = get_post_meta( $post_id, 'dwc-content', true );

        if( $title == '' && $content == '') return;

        // Create output
        $title = apply_filters( 'widget_title', $title );

        $output = $args['before_widget'];
        if ( !empty( $title ) ) {
            $output .= $args['before_title'] . $title . $args['after_title'];
        }

        $output .= do_shortcode( wpautop( $content ) );
        $output .= $args['after_widget'];

        $output = apply_filters( 'dwc_widget_output', $output, $post_id );

        // Echo output
        echo $output;
    }

    public function form( $instance )
    {
        _e( 'The content should be set for each page of post where you want the widget to show up.', 'dynamic-widget-content' );
    }

    public function update( $new_instance, $old_instance )
    {
        return $old_instance;
    }
}

add_action( 'widgets_init', create_function( '', 'return register_widget("DWC_Widget");' ) );