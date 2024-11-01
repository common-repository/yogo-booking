<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Plugin Name: YOGO Booking
 * Version: 1.6.2
 * Description: A comprehensive booking and payment solution for studios, shalas, training centers, etc
 * Author: YOGO
 * Author URI: https://yogobooking.com/
 * Text Domain: yogo-booking
 * Domain Path: /languages
 */


// The way this works:
//
// - WP converts shortcodes to html tags
// - WP also injects "widget-loader.js", a small piece of JS into <head>
// - Widget Loader makes a XHR call for the file [CLIENT_DOMAIN]/widgets/filelist.json
// - Widget Loader parses filelist.json and injects <link> and <script> tags into <head> to load YOGO widgets css and js
// - Widget code reads HTML tags and replaces them with Vue instances
// - Done
//
// The reason for the two-step process is that we can be sure to bypass cache when getting the filelist.json via XHR, which is a relatively inexpensive call, but still use cache for the main widget files.


require_once( 'src/shortcodes.php' );
require_once( 'src/admin.php' );


add_action( 'init', function () {

	if ( ! is_admin() && ! in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {

		$settings_file = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'settings.php';

		if ( file_exists( $settings_file ) ) {
			require_once( $settings_file );

			if ( isset( $yogo_widget_settings ) && is_array( $yogo_widget_settings ) ) {
				wp_localize_script( 'yogo-booking', 'yogoWidgetSettings', $yogo_widget_settings );
			}
		}
	}

} );

function yogo_inject_widget_loader() {
	// Widget loader is a small piece of JS that reads the file /widgets/filelist.json from the app server and loads whatever js- and css-files that file specifies. This lets us get the newest widget files right away, when they are published.

	if ( ! is_admin() && ! in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {

		$yogoClientDomain = get_option( 'yogo_client_domain' );

		$protocol = strstr( $yogoClientDomain, '-local' ) ? 'http' : 'https';

        $yogoClientDomain = esc_url_raw($protocol . "://" . $yogoClientDomain, array('http','https'));

		echo "<script>\n";
		echo "  var YOGO_APP_SERVER = '" . esc_js($yogoClientDomain) . "';";
		echo "</script>\n";

		echo "<script>\n";
		echo "!function(){var i=YOGO_APP_SERVER+\"/widgets/\",l=new XMLHttpRequest;l.onloadend=function(){if(200<=l.status&&l.status<300){for(var e=JSON.parse(l.responseText),t=e.css,s=e.js,r=0;r<t.length;r++){var n=document.createElement(\"link\");n.rel=\"stylesheet\",n.setAttribute(\"type\",\"text/css\"),n.href=i+t[r],document.head.appendChild(n)}for(var a=0;a<s.length;a++){var o=document.createElement(\"script\");o.setAttribute(\"type\",\"text/javascript\"),o.src=i+s[a],document.head.appendChild(o)}}else console.error(\"YOGO: Failed to get widget file list from app server.\")},l.open(\"GET\",i+\"filelist.json?cachebuster=\"+Date.now()),l.send()}();";
		echo "</script>\n";
	}
}

add_action( 'wp_head', 'yogo_inject_widget_loader');

add_action( 'init', 'yogo_load_textdomain' );

function yogo_load_textdomain() {
    load_plugin_textdomain( 'yogo-booking', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
