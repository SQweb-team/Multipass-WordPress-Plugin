<?php
/**
 * Compatibility Paid Membership Pro
 */

function sqw_pmp_access( $post_categorie ) {
	global $wpdb, $post;
	static $return = null;
	if ( null === $return ) {
		$categorie = array();
		foreach ( $post_categorie as $value ) {
			$categorie[] = $value->slug;
		}
		$current_user = wp_get_current_user();
		$query        = $wpdb->get_results(
			$wpdb->prepare( "SELECT membership_id FROM {$wpdb->pmpro_memberships_categories} WHERE category_id IN(%s)", array( implode( ',', $categorie ) ) )
		);
		$query2       = $wpdb->get_results(
			$wpdb->prepare( "SELECT membership_id FROM {$wpdb->pmpro_memberships_pages} WHERE page_id = %d", array( $post->ID ) )
		);
		$levels       = array();
		foreach ( $query as $value ) {
			$levels[] = $value->membership_id;
		}
		foreach ( $query2 as $value ) {
			$levels[] = $value->membership_id;
		}
		$query  = $wpdb->query(
			$wpdb->prepare( "SELECT UNIX_TIMESTAMP(startdate) FROM $wpdb->pmpro_memberships_users WHERE status = 'active' AND membership_id IN(%s) AND user_id = %d ORDER BY id LIMIT 1", array( implode( ',', $levels ), $current_user->ID )
			)
		);
		$return = $query;
	}
	return $return;
}

remove_filter( 'the_content', 'pmpro_membership_content_filter', 5 );
remove_filter( 'pre_get_posts', 'pmpro_search_filter' );

