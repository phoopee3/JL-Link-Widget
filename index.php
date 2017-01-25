<?php
/*
Plugin Name: JL Link
Plugin URI:
Description: A simple link widget
Version: 1.0
Author: Jason Lawton
Author URI: http://www.jasonlawton.com/
License: GPL2
*/

// Creating the widget
class jl_link extends WP_Widget {

    private $params = array('text','link','cssClass');

    function __construct() {
        parent::__construct(
            // Base ID of your widget
            'jl_link',

            // Widget name will appear in UI
            __('JL Link', 'jl_link_domain'),

            // Widget description
            array( 'description' => __( 'Link for Your Site', 'jl_link_domain' ), )
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {
        foreach ($this->params as $param) {
            ${$param} = $instance[$param];
        }
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (! empty($text) && ! empty($link)) {
            echo "<a title='' target='_blank' class='$cssClass' href='$link'>$text</a>";
        }
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {
        foreach ($this->params as $param) {
            if ( isset( $instance[$param] ) ) { ${$param} = $instance[$param]; } else { ${$param} = __( '', 'jl_link_domain' ); }
        }
        // Widget admin form
        foreach ($this->params as $param) {
            $paramName = preg_replace(array('/(?<=[^A-Z])([A-Z])/', '/(?<=[^0-9])([0-9])/'), ' $0', $param);
            $paramName = ucwords($paramName);
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( $param ); ?>"><?php _e( $paramName . ':' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( $param ); ?>" name="<?php echo $this->get_field_name( $param ); ?>" type="text" value="<?php echo esc_attr( $$param ); ?>" />
            </p>
            <?php
        }
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        foreach ($this->params as $param) {
            $instance[$param] = ( ! empty( $new_instance[$param] ) ) ? strip_tags( $new_instance[$param] ) : '';
        }
        return $instance;
    }
} // Class jl_link ends here

// Register and load the widget
function jl_link_load_widget() {
    register_widget( 'jl_link' );
}
add_action( 'widgets_init', 'jl_link_load_widget' );