<?php

Theme::start();

class Theme{

	public $config;

	static $_instance;

	function __construct(){

		add_theme_support( 'post-thumbnails' );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'init', array( $this, 'init' ) );
    add_action( 'widgets_init', array($this, 'widgets_init' ));

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

	}

	function init(){

		register_nav_menus( array(
			'main-menu' => __( 'Main Menu' ),
			)
		);

	}

  function widgets_init(){

    register_sidebar( array(
      'name' => 'Home - Footer A',
      'id' => 'home-footer--A',
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => "</aside>",
      'before_title' => '<h3 class="widget-title">',
      'after_title' => '</h3>',
    ) );

    register_sidebar( array(
      'name' => 'Home - Footer B',
      'id' => 'home-footer--B',
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => "</aside>",
      'before_title' => '<h3 class="widget-title">',
      'after_title' => '</h3>',
    ) );

    register_sidebar( array(
      'name' => 'Home - Footer C',
      'id' => 'home-footer--C',
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => "</aside>",
      'before_title' => '<h3 class="widget-title">',
      'after_title' => '</h3>',
    ) );
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



}
