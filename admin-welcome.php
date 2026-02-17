<?php
/**
 * Welcome Screen for new users
 */
 if (!defined('FRPB_PLUGIN_FILE')){
    define('FRPB_PLUGIN_FILE',FRPB_PATH . 'farjana-reading-progress-bar.php');
 }
  class FRPB_Welcome_Screen{
    public function __construct(){
      register_activation_hook(FRPB_PLUGIN_FILE, array($this, 'plugin_activated'));
      add_action('admin_menu', array($this, 'add_welcome_page'));

      add_action('admin_notices', array($this, 'show_welcome_notice'));
      add_action('admin_init', array($this, 'dismiss_welcome_notice'));
    }
    public function plugin_activated(){
      add_option('frpb_show_welcome_screen',true);
      if (!isset($_GET['activate-multi'])) {
        set_transient('frpb_activation_redirect', true, 30);
      }
    }
    public function add_welcome_page() {
      add_dashboard_page(
        'welcome to Farjana Reading Progress Bar',
        'FRPB Welcome',
        'manage_options',
        'frpb-welcome',
        array($this, 'welcome_page_content')
      );
    }

    public function welcome_page_content(){
      ?>
      <div class="wrap frpb-welcome-wrap">
      <style>
                /* Welcome page এর CSS */
                .frpb-welcome-wrap {
                  max-width: 800px;
                  margin:50px auto;
                  background: #fff;
                  padding:40px;
                  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                  border-radius: 8px
                }
                .frpb-welcome-header {
                  text-align: center;
                  margin-bottom: 40px;
                }
                .frpb-welcome-header h1 {
                  font-size:32px;
                  color: #2271b1;
                  margin-bottom:10px;
                }
                .frpb-welcome-header p {
                  font-size:16px;
                  color: #666;
                }
                .frpb-setup-steps {
                  display: grid;
                  grid-template-columns: repeat(3, 1fr);
                  gap:20px;
                  margin-bottom: 30px;
                }
                .frpb-step {
                  text-align:center;
                  padding:20px;
                  background: #f7f7f7;
                  border-radius: 8px
                }
                .frpb-step-number {
                  display:inline-block;
                  width:40px;
                  height:40px;
                  background: #2271b1;
                  color:#fff;
                  border-radius: 50%;
                  line-height: 40px;
                  font-size: 20px;
                  font-weight: bold;
                  margin-bottom: 15px;
                }
                .frpb-step h3{
                    font-size: 18px;
                    margin-bottom:10px;

                }
                .frpb-actions{
                    text-align:center;
                    margin-top:30px;
                }
                .frpb-btn {
                    display: inline-block;
                    padding: 12px 30px;
                    background: #2271b1;
                    color:#fff;
                    text-decoration: none;
                    border-radius: 5px;
                    font-size: 16px;
                    margin:0 10px;

                }
                .frpb-btn:hover{
                    background:#135e96;
                    color:#fff;
                }
                .frpb-btn-secondary{
                    background: #135e96;
                    color: #fff;

                }
                .frpb-btn-secondary:hover {
                    background: #e0e0e0;
                    color: #333;
                }
                .frpb-features {
                    margin-top:40px;
                    padding-top:40px;
                    border-top:1px solid #e0e0e0
                }
                .frpb-features h2 {
                    text-align: center;
                    margin-bottom:30px;
                }        
                .frpb-features-list {
                    display:grid;
                    grid-template-columns: repeat(2, 1fr);
                    gap: 20px;
                }
                .frpb-features-item {
                    display:flex;
                    align-items: start;
                    gap: 15px;
                }
                .frpb-feature-icon {
                    font-size: 24px;
                    color: #2271b1;
                }

            </style>

            <div class="frpb-welcome-header">
                <h1>🎉welcome to Farjana Reading Progress Bar!</h1>
                <p> Thank you for installing! Les's get you started in 3 easy steps.</p>
             </div> 
            
            <div class="frpb-setup-steps">
                <div class="frpb-step">
                    <span class="frpb-step-number">1</span>
                   <h3>Choose Color</h3> 
                    <p>Pick your favorite color for the progress bar</p>
                </div>

                <div class="frpb-step">
                    <span class="frpb-step-number">2</span>
                    <h3>Select Position</h3>
                    <p>Top or bottom of the page</p>
                </div>
                <div class="frpb-step">
                    <span class="frpb-step-number">3</span>
                    <h3>You're Done!</h3>
                    <p>View your beautiful progress bar</p>
                </div>
                  </div>
            </div>
            <div class="frpb-actions">
                <a href="<?php echo admin_url('options-general.php?page=farjana-reading-progress-bar'); ?>"
                class="frpb-btn">
                ⚙️ Go to Settings
                </a>
                <a href="<?php echo admin_url('index.php'); ?>" class="frpb-btn frpb-btn-secondary">
                    Skip for Now
                </a>
            </div>
            
            <div class="frpb-features">
                <h2>✨ What's Included</h2>
                <div class="frpb-features-list">
                    <div class="frpb-feature-item">
                        <span class="frpb-feature-icon">🎨</span>
                        <div>
                            <h4>Customizable Colors</h4>
                            <p>Choose any color to match your brand</p>
                        </div>
                    </div>
                    <div class="frpb-feature-item">
                        <span class="frpb-feature-icon">⏱️</span>
                        <div>
                            <h4>Reading Time Estimation</h4>
                            <p>Show estimated reading time to users</p>
                        </div>
                    </div>
                    <div class="frpb-feature-item">
                        <span class="frpb-feature-icon">📱</span>
                        <div>
                            <h4>Mobile Responsive</h4>
                            <p>Works perfectly on all devices</p>
                        </div>
                    </div>
                    <div class="frpb-feature-item">
                        <span class="frpb-feature-icon">⚡</span>
                        <div>
                            <h4>Lightweight & Fast</h4>
                            <p>No performance impact on your site</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 40px; padding-top: 30px; border-top: 1px solid #e0e0e0;">
                <p style="color: #666;">Need help? <a href="https://wordpress.org/support/plugin/farjana-reading-progress-bar/" target="_blank">Visit Support Forum</a></p>
            </div>
        </div>
        <?php
    }
    
    /**
     * Admin notice দেখানো
     */
    public function show_welcome_notice() {
        // যদি already dismiss করা হয়ে থাকে
        if (get_option('frpb_welcome_notice_dismissed')) {
            return;
        }
        
        // যদি settings page এ থাকি
        if (isset($_GET['page']) && $_GET['page'] === 'farjana-reading-progress-bar') {
            return;
        }
        
        // Welcome screen flag check করা
        if (!get_option('frpb_show_welcome_screen')) {
            return;
        }
        
        ?>
        <div class="notice notice-success is-dismissible frpb-welcome-notice">
            <p>
                <strong>🎉 Farjana Reading Progress Bar is now active!</strong> 
                <a href="<?php echo admin_url('options-general.php?page=farjana-reading-progress-bar'); ?>" class="button button-primary" style="margin-left: 10px;">Configure Settings</a>
                <a href="<?php echo admin_url('index.php?page=frpb-welcome'); ?>" class="button" style="margin-left: 5px;">Quick Start Guide</a>
            </p>
        </div>
        <script>
        jQuery(document).ready(function($) {
            // Notice dismiss করা
            $('.frpb-welcome-notice').on('click', '.notice-dismiss', function() {
                jQuery.post(ajaxurl, {
                    action: 'frpb_dismiss_welcome_notice'
                });
            });
        });
        </script>
        <?php
    }
    
    /**
     * Notice dismiss handle করা
     */
    public function dismiss_welcome_notice() {
        if (isset($_POST['action']) && $_POST['action'] === 'frpb_dismiss_welcome_notice') {
            update_option('frpb_welcome_notice_dismissed', true);
            update_option('frpb_show_welcome_screen', false);
        }
    }
}

// Class initialize করা
new FRPB_Welcome_Screen();