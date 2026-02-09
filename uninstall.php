<?php
/**
 * This file runs only when the plugin is deleted from the WordPress dashboard.
 * It helps to keep the database clean by removing plugin settings.
 */

// If uninstall not called from WordPress, exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

delete_option( 'frpb_options' );
