<?php

if ( ! function_exists( 'back_stab' ) ) {

	/**
	 * backtrace
	 * @return [type] [description]
	 */
	function back_stab(){
		echo "<pre>";
		debug_print_backtrace();
		echo "</pre>";
	}
}



if ( ! function_exists( 'pr' ) ) {
	/**
	 * Helper function for development.
	 *
	 * @param string $v
	 * @return void
	 * @author Armando Sosa
	 */
	function pr( $v ){
		echo '<pre>';

		if ( is_bool( $v ) ) {
			var_dump( $v );
		}else{
			print_r( $v );
		}

		echo '</pre>';
	}
}


/**
 * returns the previous post url
 *
 * @param string $in_same_cat
 * @param string $excluded_categories
 * @return void
 * @author Armando Sosa
 */
function previous_post_url($in_same_cat = false, $excluded_categories = '') {
	return adjacent_post_url($in_same_cat, $excluded_categories, true);
}

/**
 * return the next post url
 *
 * @param string $in_same_cat
 * @param string $excluded_categories
 * @return void
 * @author Armando Sosa
 */
function next_post_url($in_same_cat = false, $excluded_categories = '') {
	return adjacent_post_url($in_same_cat, $excluded_categories, false);
}

/**
 * returns the adjacent post url
 *
 * @param string $in_same_cat
 * @param string $excluded_categories
 * @param string $previous
 * @return void
 * @author Armando Sosa
 */
function adjacent_post_url($in_same_cat = false, $excluded_categories = '', $previous = true) {

	if ( $previous && is_attachment() )
		$post = & get_post($GLOBALS['post']->post_parent);
	else
		$post = get_adjacent_post($in_same_cat, $excluded_categories, $previous);

	if ( !$post )
		return;

	$url = get_permalink($post);
	return $url;
}



/**
 * Recursive argument parsing
 *
 * This acts like a multi-dimensional version of wp_parse_args() (minus
 * the querystring parsing - you must pass arrays).
 *
 * Values from $a override those from $b; keys in $b that don't exist
 * in $a are passed through.
 *
 * This is different from array_merge_recursive(), both because of the
 * order of preference ($a overrides $b) and because of the fact that
 * array_merge_recursive() combines arrays deep in the tree, rather
 * than overwriting the b array with the a array.
 *
 * The implementation of this function is specific to the needs of
 * BP_Group_Extension, where we know that arrays will always be
 * associative, and that an argument under a given key in one array
 * will be matched by a value of identical depth in the other one. The
 * function is NOT designed for general use, and will probably result
 * in unexpected results when used with data in the wild. See, eg,
 * http://core.trac.wordpress.org/ticket/19888
 *
 * @since BuddyPress (1.8)
 * @arg array $a
 * @arg array $b
 * @return array
 */
function bp_parse_args_r( &$a, $b ) {
	$a = (array) $a;
	$b = (array) $b;
	$r = $b;

	foreach ( $a as $k => &$v ) {
		if ( is_array( $v ) && isset( $r[ $k ] ) ) {
			$r[ $k ] = bp_parse_args_r( $v, $r[ $k ] );
		} else {
			$r[ $k ] = $v;
		}
	}

	return $r;
}
