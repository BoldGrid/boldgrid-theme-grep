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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Configure our admin menus.
	 *
	 * @since 1.0.0
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
	 * Get configs.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_configs() {
		$configs = include BOLDGRID_THEME_GREP_PATH . '/includes/config/config.plugin.php';

		return $configs;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 *
	 * @param string $hook Hook.
	 */
	public function enqueue_styles( $hook ) {
		if ( 'tools_page_boldgrid-theme-grep' !== $hook ) {
			return;
		}

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/boldgrid-theme-grep-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 *
	 * @param string $hook Hook.
	 */
	public function enqueue_scripts( $hook ) {
		if ( 'tools_page_boldgrid-theme-grep' !== $hook ) {
			return;
		}

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/boldgrid-theme-grep-admin.js', array( 'jquery', 'bgthgr-sticky' ), $this->version, false );

		// @todo - Include this file with a build process.
		// @link https://github.com/garand/sticky
		wp_enqueue_script( 'bgthgr-sticky', plugin_dir_url( __FILE__ ) . 'js/jquery.sticky.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Render the Theme Grep page (Dashboard > Tools > Theme Grep).
	 *
	 * @since 1.0.0
	 */
	public function page_theme_grep() {
		require_once BOLDGRID_THEME_GREP_PATH . '/admin/partials/boldgrid-theme-grep-admin-display.php';
	}
}
