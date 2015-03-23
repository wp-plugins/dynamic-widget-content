<?php
wp_nonce_field( 'dynamic-widget-content', 'dwc_nonce' );
$meta = get_post_meta( $post->ID );
?>
 
<h3><?php _e( 'Title', 'dynamic-widget-content' ); ?></h3>
<input type="text" name="dwc-title" id="dwc-title" value="<?php if ( isset ( $meta['dwc-title'] ) ) echo $meta['dwc-title'][0]; ?>" />

<h3><?php _e( 'Content', 'dynamic-widget-content' ); ?></h3>
<?php
$options = array(
    'textarea_rows' => 7
);

$content = isset ( $meta['dwc-content'] ) ? $meta['dwc-content'][0] : '';

wp_editor( $content, 'dwc-content',  $options );
?>