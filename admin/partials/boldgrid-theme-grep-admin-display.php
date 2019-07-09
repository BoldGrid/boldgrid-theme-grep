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

	<?php
	$page_count    = 1;
	$section_count = 1;
	$notice_count  = 1;

	foreach ( $configs['pages'] as $page ) {
		echo '<h2 class="page" id="bgthgr-page-' . $page_count . '">' . esc_html( $page['title'] ) . ' <a href="' . esc_url( $page['url'] ) . '" target="_blank"><span class="dashicons dashicons-external"></span></a></h2>';


		foreach( $page['sections'] as $section ) {


			foreach ( $section['items'] as $item ) {
				$grep_count = 1;

				// If an item has no greps, set it 'greps' as empty array.
				// @todo Need to show user a warning this item has no greps.
				$item['greps'] = empty( $item['greps'] ) ? [] : $item['greps'];

				$markup_header = '<p style="font-size:.85em; margin-top:0;">
					<strong>PAGE:</strong> <a href="' . esc_url( $page['url'] ) . '" target="_blank">' . esc_html( $page['title'] ) . '</a> &raquo; <strong>SECTION</strong>: ' . ( ! empty( $section['url'] ) ? '<a href="' . esc_url( $section['url'] ) . '" target="_blank">' : '' ) . esc_html( $section['title'] ) . ( ! empty( $section['url'] ) ? '</a>' : '' ) . '
				</p>';

				$markup_rule = '<p style="font-size:1.2em;color: #000;  margin:15px 0;">
					<strong class="bgthgr-pill">RULE:</strong>
					<em>' . wp_kses( $item['description'], [ 'a' => [ 'href' => [], 'target' => [] ], 'br' => [] ] ) . '</em>
				</p>';

				if ( empty( $item['greps'] ) ) {
					echo '<div class="bgthgr-section-container">
						<div class="bgthgr-item-container">
							<div id="bgthgr-notice-' . $notice_count . '" class="notice notice-error inline">' .
								$markup_header .
								$markup_rule . '
								<p>Currently, there is no grep for this rule. If you would like to recommend one, please do so on <a href="https://github.com/BoldGrid/boldgrid-theme-grep" target="_blank">this plugin\'s GitHub page</a>. Thanks!</p>
							</div>
						</div>
					</div>';

					$notice_count++;
				}
				else {
					foreach ( $item['greps'] as $a_grep ) {

						$cmd        = $a_grep[ 'cmd' ];
						$highlights = $a_grep[ 'highlights' ];

						$markup_cmd = '<div class="bgthgr-cmd-container">
							<p style="background:#ddd; padding:5px; margin:0;">
								<strong>Shell command executed</strong> ( ' . $grep_count . ' of ' . count( $item['greps']) . ' ):
							</p>
							<div class="bgthgr-code">' . esc_html( $cmd ) . '</div>
						</div>';

						echo '
						<div class="bgthgr-section-container">
							<div class="bgthgr-item-container">
								<div id="bgthgr-notice-' . $notice_count . '" class="notice notice-warning inline">' .
									$markup_header .
									$markup_rule .
									$markup_cmd . '
								</div>';
						$grep->grep_and_print( $cmd, $highlights );
						echo '</div>
						</div>';

						$grep_count++;

						$notice_count++;
					}
				}
			}
			$section_count++;
		}

		$page_count++;
	} ?>
</div>
