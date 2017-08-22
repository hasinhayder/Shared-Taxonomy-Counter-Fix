<?php
/**
 * Plugin Name: CptTaxCounter
 * Plugin URI: http://onexwp.themebucket.net
 * Description: Essential Custom Post for cpttaxcounter theme
 * Version: 1.0
 * Author: ThemeBucket
 * Author URI: http://themebucket.net
 * Text Domain: cpttaxcounter
 * Domain Path: /languages/
 * License: GPL2
 */

defined( 'ABSPATH' ) or die( "No Direct Access" );

if ( ! class_exists( "CptTaxCounterHelper" ) ) {

	class CptTaxCounterHelper {

		public function __construct() {
			register_activation_hook( __FILE__, array( $this, "ctc_activate" ) );
			register_deactivation_hook( __FILE__, array( $this, "ctc_deactivate" ) );

			add_action( "init", array( $this, "ctc_init" ) );
//			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'ctc_load_scripts' ) );
		}

		function ctc_activate() {
		}

		function ctc_deactivate() {
		}

		function ctc_scripts() {
		}

		function ctc_init() {
		}

		function ctc_load_scripts($hook){
			if ("edit-tags.php"==$hook){
				wp_enqueue_script("jquery");
				wp_enqueue_script("ctc-js",plugin_dir_url( __FILE__ )."script/ctc.js","jquery",time(),true);
			}
		}

		function ctc_portfolio_term_counter( $term, $cpt ) {
			$ctc_posts = new WP_Query( array(
				'post_type'   => $cpt,
				'tax_query'   => array(
					array(
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => array( $term ),
//						'operator' => 'IN'
					)
				),
				'post_status' => 'publish'
			) );

			return $ctc_posts->post_count;
		}

	}

	$ch = new CptTaxCounterHelper();
}

