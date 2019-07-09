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
 * Grep class.
 *
 * @package    Boldgrid_Theme_Grep
 * @subpackage Boldgrid_Theme_Grep/admin
 * @author     BoldGrid <support@boldgrid.com>
 */
class Boldgrid_Theme_Grep_Admin_Grep {

	/**
	 * Template directory.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $template_directory;

	/**
	 * Get the theme's template directory.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_template_directory() {
		if ( empty( $this->template_directory ) ) {
			$this->template_directory = get_template_directory();
		}

		return $this->template_directory;
	}

	/**
	 * Execute a grep command and return the results.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $cmd The grep command to run.
	 * @return array       Example: https://pastebin.com/uJPBnKbz
	 */
	public function grep( $cmd ) {
		$results = [];

		$cmd = str_replace( '<THEME>', $this->get_template_directory(), $cmd );

		$output = trim( shell_exec( $cmd ) );
		$output = explode( "\n", $output );

		foreach ( $output as $line ) {
			$first_colon = strpos( $line, ':' );

			$file  = substr( $line, 0, $first_colon );
			$match = trim( substr( $line, $first_colon + 1 ) );

			/*
			 * Add our match as long as it's not empty.
			 *
			 * Make sure it's not within a comment / docblock / etc.
			 */
			$empty_match   = empty( $file ) || empty( $match );
			$comment_match = substr( $match, 0, 3 ) === '// ' || substr( $match, 0, 2 ) === '* ' || substr( $match, 0, 4 ) === '/** ' || substr( $match, 0, 3 ) === '/* ';
			if ( ! $empty_match && ! $comment_match ) {
					$results[ $file ][] = $match;
			}
		}

		return $results;
	}

	/**
	 * Grep and print.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $cmd        The grep command to run.
	 * @param  array  $highlights An array of words to highlight in the grep results.
	 */
	public function grep_and_print( $cmd, $highlights = [] ) {
		$results = $this->grep( $cmd );

		if ( empty( $results ) ) {
			echo '<p>Grep command found no results.</p>';
			return;
		}

		echo '<div class="bgthgr-grep-container">';

		foreach ( $results as $file => $lines ) {
			// Create URL to the file editor for this file.
			$edit_file_url = admin_url(
				'theme-editor.php?file=' .
				urlencode( str_replace( $this->get_template_directory() . '/', '', $file ) ) .
				'&theme=' .
				urlencode( get_stylesheet() )
			);

			// Limit lines to $line_max in length. Useful when we don't want to show an entire minified file.
			$line_max = 500;
			foreach ( $lines as &$line ) {
				$line = strlen( $line ) > $line_max ? substr( $line, 0, $line_max ) . ' [LINE TRUNCATED]' : $line;
			}

			// Highlight words in the results.
			$lines = esc_html( implode( "\n\n", $lines ) );
			foreach ( $highlights as $highlight ) {
				$lines = str_replace( $highlight, '<span class="bgthgr-code-highlight">' . $highlight . '</span>', $lines );
			}

			echo '<div class="bgthgr-file-container">
				<div class="bgthgr-heading">' .
					'<span class="dashicons dashicons-arrow-down-alt2"></span> ' .
					esc_html( str_replace( $this->get_template_directory(), '', $file ) ) .
					' <a href="' . esc_url( $edit_file_url ) . '" target="_blank"><span class="dashicons dashicons-external"></span></a>' .
				'</div>
				<div class="bgthgr-code">' . $lines . '</div>
			</div>';
		}

		echo '</div>';
	}
}
