<?php
/**
 * Plugin Name: Shared Taxonomy Counter Fix
 * Plugin URI: https://github.com/hasinhayder/Shared-Taxonomy-Counter-Fix
 * Description: This plugin fixes the actual counter of taxonomoies if the taxonomy is shared, i.e used in multiple post types. This is a known bug of WordPress listed here in Trac, <a href='https://core.trac.wordpress.org/ticket/19031'>https://core.trac.wordpress.org/ticket/19031</a>, and countless times in different support sites as well as in StackExchange forums.
 * Version: 1.0
 * Author: Hasin Hayder From ThemeBucket
 * Author URI: http://themebucket.net
 * License: GPL
 */

defined( 'ABSPATH' ) or die( "No Direct Access" );

if ( ! class_exists( "SharedTaxCounterHelper" ) ) {

	class SharedTaxCounterHelper {

		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'stc_load_scripts' ) );
		}

		function stc_load_scripts( $hook ) {
			if ( "edit-tags.php" == $hook ) {
				$stc_tax_name  = $_GET['taxonomy'];
				$stc_post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : "post";

				$stc_counter = [];
				$stc_terms   = $this->stc_get_terms( $stc_tax_name );
				foreach ( $stc_terms as $stc_term ) {
					$stc_counter[] = array(
						"name"    => $stc_term->name,
						"counter" => $this->stc_get_term_counter( $stc_term->slug, $stc_post_type )
					);
				}

				wp_enqueue_script( "jquery" );
				wp_enqueue_script( "stc-js", plugin_dir_url( __FILE__ ) . "script/stc.js", "jquery", time(), true );
				wp_localize_script( "stc-js", "stc",
					array(
						"counter" => $stc_counter
					)
				);
			}
		}

		function stc_get_term_counter( $term, $cpt ) {
			$stc_posts = new WP_Query( array(
				'post_type'   => $cpt,
				'tax_query'   => array(
					array(
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => $term,
					)
				),
				'post_status' => 'publish'
			) );

			return $stc_posts->post_count;
		}

		function stc_get_terms( $tax = "category" ) {
			$stc_terms = get_categories( array(
				'taxonomy'   => $tax,
				'hide_empty' => true

			) );

			return $stc_terms;
		}

	}

	$ch = new SharedTaxCounterHelper();
}

