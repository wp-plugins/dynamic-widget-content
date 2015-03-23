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
        $title = get_post_meta( $post_id, 'dwc-title', true );
        $content = get_post_meta( $post_id, 'dwc-content', true );

        if( $title == '' && $content == '') return;

        $title = apply_filters( 'widget_title', $title );

        echo $args['before_widget'];
        if ( !empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        echo do_shortcode( wpautop( $content ) );

        echo $args['after_widget'];
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