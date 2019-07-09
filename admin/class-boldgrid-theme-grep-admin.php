<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.boldgrid.com
 * @since      1.0.0
 *
 * @package    Boldgrid_Theme_Grep
 * @subpackage Boldgrid_Theme_Grep/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Boldgrid_Theme_Grep
 * @subpackage Boldgrid_Theme_Grep/admin
 * @author     BoldGrid <support@boldgrid.com>
 */
class Boldgrid_Theme_Grep_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 *
	 */
	public function admin_menu() {
		add_management_page(
			__( 'Theme Grep', 'boldgrid-theme-grep' ),
			__( 'Theme Grep', 'boldgrid-theme-grep' ),
			'manage_options',
			'boldgrid-theme-grep',
			array( $this, 'page_theme_grep' )
		);
	}

	/**
	 *
	 */
	public function get_configs() {
		$configs = include BOLDGRID_THEME_GREP_PATH . '/includes/config/config.plugin.php';

		return $configs;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {

		if ( 'tools_page_boldgrid-theme-grep' !== $hook ) {
			return;
		}

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Boldgrid_Theme_Grep_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Boldgrid_Theme_Grep_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/boldgrid-theme-grep-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {

		if ( 'tools_page_boldgrid-theme-grep' !== $hook ) {
			return;
		}

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Boldgrid_Theme_Grep_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Boldgrid_Theme_Grep_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/boldgrid-theme-grep-admin.js', array( 'jquery', 'bgthgr-jquery-jsticky' ), $this->version, false );

		wp_enqueue_script( 'bgthgr-jquery-jsticky', plugin_dir_url( __FILE__ ) . 'js/jquery.jsticky.min.js', array( 'jquery' ), $this->version, false );

		// https://wpreset.com/add-codemirror-editor-plugin-theme/
		$cm_settings['codeEditor'] = wp_enqueue_code_editor(
			array(
				'type' => 'text/css',
				/*
				 * CodeMirrorr settings.
				 *
				 * @link https://codemirror.net/doc/manual.html
				 */
				'codemirror'          => array(
					'lineNumbers'     => false,
					'readOnly'        => true,
					'lint'            => false,
					'styleActiveLine' => false,
				),
			)
		);
		wp_localize_script('jquery', 'cm_settings', $cm_settings);
		// wp_enqueue_script('wp-theme-plugin-editor');
		wp_enqueue_style('wp-codemirror');

	}

	/**
	 *
	 */
	public function page_theme_grep() {
		require_once( BOLDGRID_THEME_GREP_PATH . '/admin/partials/boldgrid-theme-grep-admin-display.php' );
	}
}
