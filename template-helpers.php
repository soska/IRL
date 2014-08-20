<?php



/**
 * Outputs a widget area if any widget exists. Otherwise outputs a placehodler with a title.
 *
 * @param string $id
 * @param string $placeholder
 * @return void
 * @author Armando Sosa
 */
function widget_area( $id, $placeholder = null ){

	if ( ! dynamic_sidebar( $id ) ){
		if ( empty( $placeholder ) )
			$placeholder = $id;
		echo "<div class='widget-placeholder well'><h3>{$placeholder}</h3><p>This is an empty widget area. You can add widgets to it in the dashboard, under Appareance > Widgets</p></div>";
	}

}



/**
 * Gets the best possible post image.
 *
 * @return void
 * @author Armando Sosa
 */
function get_better_post_image(){

	$image = get_featured_image();

	if ( false === $image ) {
		$image = get_youtube_post_image();
	}

	return $image;

}

/**
 * undocumented function
 *
 * @param string $width
 * @param string $link
 * @param string $content
 * @return void
 * @author Armando Sosa
 */
function youtube_post_image( $width = 480, $link = false, $content = null, $default = null ){
	$image = get_youtube_post_image( $content );

	if ( empty( $image ) && $default ) {
		$image = $default;
	}

	if ( $image ) {
		$image  = "<img src='$image' width='$width' class='youtube-video-thumb'/>";
		if ( $link ) {
			echo '<a href="'. $link .'" class="youtube-video-link" >' . $image . '</a>';
		}else{
			echo $image;
		}
	}

}

/**
 * undocumented function
 *
 * @param string $content
 * @return void
 * @author Armando Sosa
 */
function get_youtube_post_image(  $content = null ){

	$image = false;

	if ( empty( $content ) ) {
		$content = get_the_content( '' );
	}

	$regexp = array(
		'#youtube.com\/watch.+v=([^&^\s^"]+)#', // matches the old url structure
		'#youtube.com\/v\/([^?^&^\s^"]+)#', // matches the new url structure
		'#youtu.be\/([^&^\s^"]+)#', // matches short url
	);

	foreach ($regexp as $r) {
		if ( preg_match( $r, $content, $matches ) ){
			if ( isset( $matches[1] ) )
				return "http://img.youtube.com/vi/{$matches[1]}/0.jpg";
		}
	}

}


/**
 * undocumented function
 *
 * @param string $size
 * @return void
 * @author Armando Sosa
 */
function get_featured_image( $size = 'large' ){

	global $id;

	$post_thumbnail_id = get_post_thumbnail_id( $id );
	$image = wp_get_attachment_image_src( $post_thumbnail_id, $size );

	if ( isset( $image[0] ) )
		$image = $image[0];

	return $image;
}

function assets_image($file, $src_only = false, $attributes = ''){
	$src = IRL_ASSETS_URL . '/img/' . $file;
	if ($src_only) {
		return $src;
	}else{
		echo "<image src='$src' $attributes>";
	}

}

function seo_tagline($tagline){
  if (is_single()) {
    echo "<span class='tagline tagline--single'>$tagline</span>";
  }else{
    echo "<h1 class='tagline tagline--front'>$tagline</h1>";
  }
}

function timestamp() {

  // Set up and print post meta information.
  printf( '<a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a></span> <span class="byline"><span class="author vcard"><a class="url fn n" href="%4$s" rel="author">%5$s</a></span>',
    esc_url( get_permalink() ),
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date() ),
    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
    get_the_author()
  );
}
