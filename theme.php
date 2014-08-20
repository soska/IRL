<?php

Theme::start();

class Theme{

	public $config;

	static $_instance;

	function __construct(){

		// $this->config = require_once( IRL_INCLUDES . "/config.php" );

		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'woo-commerce' );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'init', array( $this, 'init' ) );
	}

	static function start(){

		self::$_instance = new Theme();

	}

	static function instance(){

		if ( !self::$_instance ) {
			self::start();
		}

		return $_instance;
	}

	function enqueue_scripts(){
		// wp_enqueue_style( 'foundationcss', IRL_FOUNDATION_URL . "/css/foundation.css" );
		wp_enqueue_script( 'foundationjs', IRL_FOUNDATION_URL . "/js/foundation.min.js", ['jquery'] );
	}

	function init(){

		register_nav_menus( array(
			'main-menu' => __( 'Main Menu' ),
			)
		);

	}


	static function render_view( $name, $vars = array() ){
		extract( $vars );

		$view_path = IRL_VIEWS . "/" . $name . ".php";

		if ( file_exists( $view_path ) ) {
			include $view_path;
		}else{
			throw new Exception( "view for $name not found on $view_path." );
		}

	}

	static function render_partial( $name, $vars = array() ){

		$parts = explode('/',$name);
		$parts[count($parts)-1] = "_" . $parts[count($parts)-1];

		$name = implode('/',$parts);

		self::render_view($name, $vars);

	}

	static function nav(){
		if (is_single()) {

			$args = array(
				'prelabel' => '&larr; Posts más nuevos',
				'nxtlabel' => 'Posts más viejos &rarr;',
			);
			echo bootstrap_posts_nav( $args );
		}else{
			$args = array(
				'prelabel' => '&larr; Posts más nuevos',
				'nxtlabel' => 'Posts más viejos &rarr;',
			);
			echo bootstrap_archive_nav( $args );
		}
		keyboard_nav_js();
	}


}
