<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
die;
}

global $wpdb;
$wpdb->get_results('ALTER TABLE `wp_terms` DROP `tok_image`');