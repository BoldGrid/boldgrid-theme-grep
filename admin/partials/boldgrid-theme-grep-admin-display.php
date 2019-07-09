<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.boldgrid.com
 * @since      1.0.0
 *
 * @package    Boldgrid_Theme_Grep
 * @subpackage Boldgrid_Theme_Grep/admin/partials
 */

$configs = $this->get_configs();

$grep = new Boldgrid_Theme_Grep_Admin_Grep();
?>

<div class="wrap">

	<h1>Theme Grep by BoldGrid</h1>

	<p>
		<strong>Theme Grep</strong> is a plugin designed to help review WordPress themes.
		While <a href="https://wordpress.org/plugins/theme-check/" target="_blank">Theme Check</a> and <a href="https://wordpress.org/plugins/theme-sniffer/" target="_blank">Theme Sniffer</a> are designed to find specific issues, <em>Theme Grep</em> was built to help automate some of the searches (greps) used to "snoop around" the theme's code.
	</p>

	<p>
		This page contains the rules / requirements a theme must meet as outlined on the <a href="https://make.wordpress.org/themes/handbook/review/required/" target="_blank">Required</a> page. For many of the rules, we have grepped through the theme's files to help you find whether the rules have been met / broken. For rules missing a grep, you can help contribute by submitting a pull request on <a href="https://github.com/BoldGrid/boldgrid-theme-grep" target="_blank">GitHub</a>.
	</p>

	<?php
	$page_count    = 1;
	$section_count = 1;
	$notice_count  = 1;

	foreach ( $configs['pages'] as $page ) {
		// Page heading.
		echo '<h2 class="page" id="bgthgr-page-' . esc_attr( $page_count ) . '">' . esc_html( $page['title'] ) . ' <a href="' . esc_url( $page['url'] ) . '" target="_blank"><span class="dashicons dashicons-external"></span></a></h2>';

		foreach ( $page['sections'] as $section ) {
			foreach ( $section['items'] as $item ) {
				$grep_count = 1;

				$item['greps'] = empty( $item['greps'] ) ? [] : $item['greps'];

				$markup_header = '<p class="bgthgr-item-heading">
					<strong>PAGE:</strong> <a href="' . esc_url( $page['url'] ) . '" target="_blank">' . esc_html( $page['title'] ) . '</a> &raquo; <strong>SECTION</strong>: ' . ( ! empty( $section['url'] ) ? '<a href="' . esc_url( $section['url'] ) . '" target="_blank">' : '' ) . esc_html( $section['title'] ) . ( ! empty( $section['url'] ) ? '</a>' : '' ) . '
				</p>';

				$markup_rule = '<p class="bgthgr-rule-container">
					<strong class="bgthgr-pill">RULE:</strong>
					<em>' . wp_kses(
					$item['description'], [
						'a'  => [
							'href'   => [],
							'target' => [],
						],
						'br' => [],
					]
				) . '</em>
				</p>';

				// If we don't have any greps, show a warning. Otherwise, loop through each grep.
				if ( empty( $item['greps'] ) ) {
					echo '<div class="bgthgr-section-container">
						<div class="bgthgr-item-container">
							<div id="bgthgr-notice-' . esc_attr( $notice_count ) . '" class="notice notice-error inline">' .
								$markup_header . // phpcs:ignore
								$markup_rule . // phpcs:ignore
								'<p>Currently, there is no grep for this rule. If you would like to recommend one, please do so on <a href="https://github.com/BoldGrid/boldgrid-theme-grep" target="_blank">this plugin\'s GitHub page</a>. Thanks!</p>
							</div>
						</div>
					</div>';

					$notice_count++;
				} else {
					foreach ( $item['greps'] as $a_grep ) {
						$cmd        = $a_grep['cmd'];
						$highlights = $a_grep['highlights'];

						$markup_cmd = '<div class="bgthgr-cmd-container">
							<p class="bgthgr-cmd-heading">
								<strong>Shell command executed</strong> ( ' . esc_html( $grep_count ) . ' of ' . count( $item['greps'] ) . ' ):
							</p>
							<div class="bgthgr-code">' . esc_html( $cmd ) . '</div>
						</div>';

						echo '<div class="bgthgr-section-container">
							<div class="bgthgr-item-container">
								<div id="bgthgr-notice-' . esc_attr( $notice_count ) . '" class="notice notice-warning inline">' .
									$markup_header . // phpcs:ignore
									$markup_rule . // phpcs:ignore
									$markup_cmd . // phpcs:ignore
								'</div>';
						$grep->grep_and_print( $cmd, $highlights );
						echo '</div>
						</div>';

						$grep_count++;
						$notice_count++;
					}
				}
			} // End of 1 item.

			$section_count++;
		} // End of 1 section.

		$page_count++;
	} // End of 1 page.
	?>
</div>
