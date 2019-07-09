<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.boldgrid.com
 * @since             1.0.0
 * @package           Boldgrid_Theme_Grep
 *
 * @wordpress-plugin
 * Plugin Name:       Theme Grep by BoldGrid
 * Plugin URI:        https://www.boldgrid.com
 * Description:       Theme Grep helps to review WordPress themes by automating many searches (greps) used to "snoop around" the theme's code.
 * Version:           1.0.0
 * Author:            BoldGrid
 * Author URI:        https://www.boldgrid.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       boldgrid-theme-grep
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BOLDGRID_THEME_GREP_VERSION', '1.0.0' );

if ( ! defined( 'BOLDGRID_THEME_GREP_PATH' ) ) {
	define( 'BOLDGRID_THEME_GREP_PATH', dirname( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-boldgrid-theme-grep-activator.php
 */
function activate_boldgrid_theme_grep() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-boldgrid-theme-grep-activator.php';
	Boldgrid_Theme_Grep_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-boldgrid-theme-grep-deactivator.php
 */
function deactivate_boldgrid_theme_grep() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-boldgrid-theme-grep-deactivator.php';
	Boldgrid_Theme_Grep_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_boldgrid_theme_grep' );
register_deactivation_hook( __FILE__, 'deactivate_boldgrid_theme_grep' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-boldgrid-theme-grep.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_boldgrid_theme_grep() {

	$plugin = new Boldgrid_Theme_Grep();
	$plugin->run();

}
run_boldgrid_theme_grep();
