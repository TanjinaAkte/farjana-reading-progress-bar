<?php
/**
 * Plugin Name: Farjana Reading Progress Bar
 * Author URI: https://github.com/TanjinaAkte
 * Plugin URI: https://wordpress.org/plugins/farjana-reading-progress-bar/
 * Description: Farjana Reading Progress Bar is a professional and lightweight plugin. It displays an estimated reading time and a live scroll progress bar on your WordPress posts.
 * Version: 1.4.0
 * Author: Farjana
 * License: GPL2
 * Text Domain: farjana-reading-progress-bar
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Farjana_Reading_Progress_Bar {

    public function __construct() {
        $this->define_constants();
        $this->includes();

        // Hooks
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        add_action( 'wp_footer', array( $this, 'frpb_progress_bar_html' ) ); 
        add_action( 'admin_notices', array( $this, 'frpb_show_admin_notice' ) );
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
    }

    private function define_constants() {
        define( 'FRPB_VERSION', '1.0.1' );
        define( 'FRPB_PATH', plugin_dir_path( __FILE__ ) );
        define( 'FRPB_URL', plugin_dir_url( __FILE__ ) );
        define( 'FRPB__PLUGIN_FILE', __FILE__ );  
    }
 
    private function includes() {
        if ( file_exists( FRPB_PATH . 'includes/frpb-calculator.php' ) ) {
            require_once FRPB_PATH . 'includes/frpb-calculator.php';
        }
        if ( file_exists( FRPB_PATH . 'includes/frpb-settings.php' ) ) {
            require_once FRPB_PATH . 'includes/frpb-settings.php';
        }
         require_once FRPB_PATH . 'admin-welcome.php';

    }

    public function activate() {
        $default_options = array(
            'wpm'           => 200,
            'post_types'    => array( 'post' ),
            'bar_color'     => '#0073aa',
            'bar_height'    => 5,
            'bar_pos'       => 'top',
            'box_bg'        => '#ffffff',
            'text_color'    => '#334155',
            'font_size'     => 14,
            'border_radius' => 12,
            'enable_english' => 0,
            'enable_popup'  => 1
        );        
        if ( ! get_option( 'frpb_options' ) ) {
            update_option( 'frpb_options', $default_options );
        }
    }
    public function enqueue_assets() {
        $options = get_option( 'frpb_options' );
        $allowed_types = isset( $options['post_types'] ) ? (array) $options['post_types'] : array( 'post' );

        if ( is_singular( $allowed_types ) ) {
            // CSS Enqueue
            wp_enqueue_style( 'frpb-style', FRPB_URL . 'assets/style.css', array(), FRPB_VERSION );
            
            // JS Enqueue
            wp_enqueue_script( 'frpb-script', FRPB_URL . 'assets/script.js', array('jquery'), FRPB_VERSION, true );

            wp_localize_script( 'frpb-script', 'frpb_data', array(
                'is_english' => !empty( $options['enable_english'] ) ? true : false,
                'popup_enabled' => !empty( $options['enable_popup'] ) ? true : false
            ) );
            // Inline CSS
            $bar_color  = isset( $options['bar_color'] ) ? sanitize_hex_color($options['bar_color']) : '#0073aa';
            $box_bg     = isset( $options['box_bg'] ) ? sanitize_hex_color($options['box_bg']) : '#ffffff';
            $text_color = isset( $options['text_color'] ) ? sanitize_hex_color($options['text_color']) : '#334155';
            $font_size  = isset( $options['font_size'] ) ? absint($options['font_size']) : 14;
            $radius     = isset( $options['border_radius'] ) ? absint($options['border_radius']) : 12;

            $custom_css = "
                #frpb-progress-bar { background-color: {$bar_color} !important; }
                .farjana-reading-progress-bar { 
                    background-color: {$box_bg} !important; 
                    color: {$text_color} !important; 
                    font-size: {$font_size}px !important;
                    border_radius: {$radius}px !important;
                }";
            wp_add_inline_style( 'frpb-style', $custom_css );
        }
    }

    public function frpb_show_admin_notice() {
        $screen = get_current_screen();
        if ( $screen && $screen->id === 'settings_page_farjana-reading-progress-bar' ) {
            return;
        }
        ?>
        <div class="notice notice-info is-dismissible">
            <p><strong><?php esc_html_e( 'Farjana Reading Progress Bar', 'farjana-reading-progress-bar' ); ?></strong> <?php esc_html_e( 'is ready!', 'farjana-reading-progress-bar' ); ?> <a href="<?php echo esc_url( admin_url('options-general.php?page=farjana-reading-progress-bar') ); ?>"><?php esc_html_e( 'Go to Settings', 'farjana-reading-progress-bar' ); ?></a></p>
        </div>
        <?php
    }

    public function frpb_progress_bar_html(){
        $options = get_option( 'frpb_options');
        $allowed_types = isset( $options['post_types'] ) ? (array) $options['post_types'] : array ('post' );
        
        if ( is_singular( $allowed_types ) ) {
            $bar_height = isset( $options['bar_height'] ) ? absint( $options['bar_height'] ) : 5;
            $bar_pos    = isset( $options['bar_pos'] ) ? sanitize_text_field($options['bar_pos']) : 'top';
            $position_css = ( $bar_pos === 'bottom' ) ? 'bottom: 0;' : 'top: 0;';
            ?>
            <div id="frpb-progress-bar-container" style="height:<?php echo absint($bar_height); ?>px; position: fixed; <?php echo esc_attr($position_css); ?> left: 0; width: 100%; z-index: 99999; background: rgba(0,0,0,0.05);">
                <div id="frpb-progress-bar" style="height: 100%; width: 0%; transition: width 0.1s ease-out;"></div>
            </div>
            <?php
        }
    }
} 

new Farjana_Reading_Progress_Bar();