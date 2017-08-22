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
			add_action( 'admin_enqueue_scripts', array( $this, 'ctc_load_scripts' ) );
		}

		function ctc_load_scripts( $hook ) {
			if ( "edit-tags.php" == $hook ) {
				$ctc_tax_name  = $_GET['taxonomy'];
				$ctc_post_type = isset($_GET['post_type'])?$_GET['post_type']:"post";

				$ctc_counter = [];
				$ctc_terms   = $this->ctc_get_terms( $ctc_tax_name );
				foreach ( $ctc_terms as $ctc_term ) {
					$ctc_counter[] = array(
						"name"    => $ctc_term->name,
						"counter" => $this->ctc_get_term_counter( $ctc_term->name, $ctc_post_type )
					);
				}

				wp_enqueue_script( "jquery" );
				wp_enqueue_script( "ctc-js", plugin_dir_url( __FILE__ ) . "script/ctc.js", "jquery", time(), true );
				wp_localize_script( "ctc-js", "ctc",
					array(
						"counter" => $ctc_counter
					)
				);
			}
		}

		function ctc_get_term_counter( $term, $cpt ) {
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

		function ctc_get_terms( $tax = "category" ) {
			$ctc_terms = get_categories( array(
				'taxonomy'   => $tax,
				'hide_empty' => true

			) );

			return $ctc_terms;
		}

	}

	$ch = new CptTaxCounterHelper();
}

