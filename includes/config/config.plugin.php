<?php
/**
 * File: config.plugin.php
 *
 * Plugin configuration file.
 *
 * @link https://www.boldgrid.com
 * @since 1.0
 *
 * @package    Boldgrid_Theme_Grep
 * @subpackage Boldgrid_Backup/includes
 * @copyright  BoldGrid
 * @version    $Id$
 * @author     BoldGrid <support@boldgrid.com>
 */

if ( ! defined( 'WPINC' ) ) die;

$theme = wp_get_theme();

return [
	'pages' => [
		[
			'title'    => 'Theme Review Team > Handbook > Review Process > Required',
			'url'      => 'https://make.wordpress.org/themes/handbook/review/required/',
			'sections' => [
				[
					'title' => 'Child themes',
					'items' => [
						[
							'description'    => 'Child themes must include more than minor changes (such as font and colour changes) to the parent theme to be accepted. To make it easier on the reviewer, make sure you describe what modifications/features you did on top of the parent theme (in a ticket comment).',
							'in-theme-check' => false,
							'result'         => '<p>Is child theme: ' . ( is_child_theme() ? 'Yes' : 'No' ) . '</p>',
						],
					],
				],
				[
					'title' => 'Accessibility',
					'items' => [
						[
							'description'    => 'If the theme has the tag ‘accessibility-ready’ then it needs to meet <a href="https://make.wordpress.org/themes/handbook/review/accessibility/">these requirements</a>.',
							'in-theme-check' => false,
							'result'         => '<p>Has accessibility-ready tag: ' . ( in_array( 'accessibility-ready', $theme->get( 'Tags' ) ) ? 'Yes' : 'No' ) . '</p>',
						],
					],
				],
				[
					'title' => 'Code',
					'url'   => 'https://make.wordpress.org/themes/handbook/review/required/#code',
					'items' => [
						[
							'description'    => 'No PHP or JS notices.',
							'in-theme-check' => false,
							'greps'          => [
								[
									'cmd'       => 'grep -RE "(admin_notices|notice-|is-dismissible)" <THEME>/*',
									'highlights' => array( 'admin_notices', 'notice-', 'is-dismissible' ),
								],
							],
						],
						[
							'description'    => 'Validate and/or sanitize untrusted data before entering into the database. All untrusted data should be escaped before output. (See: <a href="https://codex.wordpress.org/Data_Validation">Data Validation</a>)',
							'in-theme-check' => false,
							'greps'          => [
								[
									'cmd'        => 'grep -REi --include \*.php "(wpdb|sql|insert)" <THEME>/*',
									'highlights' => [ 'wpdb', 'sql', 'insert' ],
								],
							],
						],
						[
							'description' => 'No removing or modifying non-presentational hooks.',
							'greps'       => [
								[
									'cmd'        => 'grep -RE "(remove_action|remove_filter)" <THEME>/*',
									'highlights' => [ 'remove_action', 'remove_filter' ],
								],
							],
						],
						[
							'description' => 'Must meet all <a href="https://make.wordpress.org/themes/handbook/review/required/theme-check-plugin/">Theme Check requirements</a>',
						],
						[
							'description' => 'Provide a <a href="http://themereview.co/prefix-all-the-things/">unique prefix</a> for everything the Theme defines in the public namespace, including options, functions, global variables, constants, post meta, etc.&nbsp;Theme nav menu locations and sidebar IDs are exceptions.',
							'greps'       => [
								[
									'cmd' => 'grep -RE  "(add_option|update_option)" <THEME>/* | grep -Ev "(public function|private function|protected function|static function)"',
									'highlights' => [ 'add_option', 'update_option' ],
								],
								[
									'cmd' => 'grep -R --include \*.php "function " <THEME>/* | grep -Ev "(public function|private function|protected function|static function)"',
									'highlights' => [ 'function ' ],
								],
								[
									'cmd' => 'grep -RE --include \*.php "(global |GLOBALS)" <THEME>/*',
									'highlights' => [ 'global ', 'GLOBALS' ],
								],
								[
									'cmd' => 'grep -R --include \*.php "define*(" <THEME>/*',
									'highlights' => [ 'define(', 'define (' ],
								],
								[
									'cmd' => 'grep -RE "(get_post_meta|add_post_meta)" <THEME>/*',
									'highlights' => [ 'get_post_meta', 'add_post_meta' ],
								],
							],
						],
					],
				],
				[
					'title' => 'Core Functionality and Features',
					'url'   => 'https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features',
					'items' => [
						[
							'description' => 'Use <a href="https://developer.wordpress.org/themes/functionality/">WordPress functionality and features first, if available</a>. <em>If incorporated, </em>features must support the WordPress&nbsp;functionality: <a href="https://developer.wordpress.org/reference/functions/add_theme_support/#feed-links">Automatic Feed Links</a>, <a href="https://developer.wordpress.org/themes/functionality/sidebars/">Sidebars</a>, <a href="https://developer.wordpress.org/themes/functionality/navigation-menus/">Navigation Menus</a>, <a href="https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/">Post Thumbnails</a>, <a href="https://developer.wordpress.org/themes/functionality/custom-headers/">Custom Headers</a>, <a href="https://codex.wordpress.org/Custom_Backgrounds">Custom Backgrounds</a>, <a href="https://developer.wordpress.org/reference/functions/add_editor_style/">Editor Style</a>, <a href="https://developer.wordpress.org/themes/functionality/custom-logo/">Logo.</a>',
						],
						[
							'description' => 'Do not use features/APIs meant for WP Core use only e.g. <a href="https://developer.wordpress.org/reference/classes/wp_internal_pointers/">admin pointers</a> and <a href="https://codex.wordpress.org/Category:Private_Functions">private functions</a>.',
							'greps'       => [
								[
									'cmd' => 'grep -RE "(_wp_post_revision_fields|_transition_post_status|_get_plugin_data_markup_translate|_cleanup_header_comment|do_shortcode_tag|get_post_type_labels|preview_theme_ob_filter_callback|preview_theme_ob_filter|wp_get_widget_defaults|wp_get_sidebars_widgets|wp_unregister_GLOBALS|wp_set_sidebars_widgets|WP_Internal_Pointers)" <THEME>/*',
									'highlights' => [ '_wp_post_revision_fields', '_transition_post_status', '_get_plugin_data_markup_translate', '_cleanup_header_comment', 'do_shortcode_tag', 'get_post_type_labels', 'preview_theme_ob_filter_callback', 'preview_theme_ob_filter', 'wp_get_widget_defaults', 'wp_get_sidebars_widgets', 'wp_unregister_GLOBALS', 'wp_set_sidebars_widgets', 'WP_Internal_Pointers' ],
								]
							],
						],
						[
							'description' => 'No pay wall restricting any WordPress feature.',
							'greps'       => [
								[
									'cmd' => 'grep -RE "(premium|upgrade)" <THEME>/*',
									'highlights' => [ 'premium', 'upgrade' ],
								],
							],
						],
						[
							'description' => 'Avoid hard coding to modify content. Instead, use function parameters, filters and action hooks where appropriate.&nbsp;For example <a href="https://developer.wordpress.org/reference/functions/wp_title/">wp_title</a> should be modified using a <a href="https://developer.wordpress.org/reference/hooks/wp_title/">filter</a>.',
						],
						[
							'description' => 'Able to have child themes made from them. (Child theme ready)',
						],
						[
							'description' => 'The <a href="https://make.wordpress.org/themes/handbook/review/required/theme-tags/">theme tags</a>&nbsp;in style.css&nbsp;and description must match what the theme actually&nbsp;does in respect to functionality and design. Don’t use more than 3 subject tags (See: <a href="https://make.wordpress.org/themes/handbook/review/required/theme-tags/">Theme Tag List</a>).',
						],
						[
							'description' => 'Use <a href="https://codex.wordpress.org/Template_Tags">template tags</a> and action/filter hooks properly.',
						],
						[
							'description' => 'Include comments.php (via <a href="https://codex.wordpress.org/Function_Reference/comments_template">comments_template()</a>).',
						],
						[
							'description' => 'Themes may be backwards compatible, but only for 3 major WordPress versions (version 4.9 if 5.2 is latest).',
						],
						[
							'description' => 'Themes should not remove, hide, or otherwise block the admin bar from appearing.',
							'greps'       => [
								[
									'cmd' => 'grep -RE "(wpadminbar|wp-admin-bar)" <THEME>/*',
									'highlights' => [ 'wpadminbar', 'wp-admin-bar' ],
								],
							],
						],
						[
							'description' => 'Core theme activation UX should not be modified. There should be no redirect on activation behaviour.',
							'greps'       => [
								[
									'cmd' => 'grep -RE "(wp_redirect|Location)" <THEME>/*',
									'highlights' => [ 'wp_redirect', 'Location' ],
								],
							],
						],
					],
				],
				[
					'title' => 'readme.txt file',
					'url'   => 'https://make.wordpress.org/themes/handbook/review/required/#readme-txt-file',
					'items' => [
						[
							'description' => 'Use this <a href="https://make.wordpress.org/themes/handbook/review/required/sample-readme/">format for your readme.txt file</a>',
						],
					],
				],
				[
					'title' => 'Presentation vs Functionality',
					'url'   => 'https://make.wordpress.org/themes/handbook/review/required/#presentation-vs-functionality',
					'items' => [
						[
							'description' => 'The theme options should not be pseudo custom post types and save non-trivial user data.',
						],
						[
							'description' => 'Non-design related functionality is not allowed. (See:&nbsp;<a href="https://make.wordpress.org/themes/handbook/review/required/explanations-and-examples/#plugin-territory">Plugin territory examples</a>)',
						],
						[
							'description' => 'Demo content may be used to show the user how the options work. Use <a href="https://make.wordpress.org/core/2016/11/30/starter-content-for-themes-in-4-7/">starter content</a>, existing content, or installation instructions instead of placeholder content. Installation instructions should only be visible to users with the edit_theme_options capability, not to visitors.',
							'greps'       => [
								[
									'cmd' => 'grep -RE "(starter-content|starter_content)" <THEME>/*',
									'highlights' => [ 'starter-content', 'starter_conotent' ],
								],
							],
						],
						[
							'description' => 'Showing preview/demo data or manipulating the preview on WordPress.org is not allowed and can result in your user account being terminated.',
						],
						[
							'description' => 'Adding custom blocks for Gutenberg (the new text editor in WordPress) is not allowed. Use a companion plugin instead.',
							'greps'       => [
								[
									'cmd' => 'grep -RE "(gutenberg|wp-blocks|wp-element)" <THEME>/*',
									'highlights' => [ 'gutenberg', 'wp-blocks', 'wp-element' ],
								],
							],
						],
						[
							'description' => 'Placeholder/default images for posts without defined featured images <a href="https://make.wordpress.org/themes/handbook/review/required/explanations-and-examples/#featured-images" target="_blank" rel="noreferrer noopener"><strong>need to follow these rules</strong></a>',
						],
					],
				],
				[
					'title' => 'Documentation',
					'url'   => 'https://make.wordpress.org/themes/handbook/review/required/#documentation',
					'items' => [
						[
							'description' => 'Any custom features, templates, options or any limitations (for example menu restrictions), should be explained. Enough documentation should be provided.',
						],
					],
				],
				[
					'title' => 'Language',
					'url'   => 'https://make.wordpress.org/themes/handbook/review/required/#language',
					'items' => [
						[
							'description' => 'All theme text strings are to be translatable.',
							'greps'       => [
								[
									'cmd' => 'grep -RE --include \*.php "(echo|print)" <THEME>/*',
									'highlights' => [ 'echo', 'print' ],
								],
								[
									'cmd' => 'grep -RE --include \*.php "(__\(|_e\()" <THEME>/*',
									'highlights' => [ '__', '_e' ],
								],
							],
						],
						[
							'description' => 'Include a text domain in style.css.',
						],
						[
							'description' => 'Use a single unique theme slug – as the theme slug appears in style.css. If it uses a framework then no more than 2 unique slugs.',
						],
						[
							'description' => 'Can use any language for text, but only use the same one for all text.',
						],
					],
				],
				[
					'title' => 'Licensing',
					'url'   => 'https://make.wordpress.org/themes/handbook/review/required/#licensing',
					'items' => [
						[
							'description' => 'Be 100% GPL and/or <a href="https://make.wordpress.org/themes/handbook/review/resources/#licenses-bundled-resources">100% GPL-compatible</a> licensed.',
						],
						[
							'description' => 'Declare copyright and license explicitly. Use the license and license uri header slugs to style.css. Declare licenses of any resources included such as fonts or images.',
						],
						[
							'description' => 'Declare licenses of any resources included such as fonts or images.',
							'greps'       => [
								[
									'cmd' => 'grep -RE "(license|copyright)" <THEME>/*',
									'highlights' => [ 'license', 'copyright' ],
								],
							],
						],
						[
							'description' => 'All code and design should be your own or legally yours. Cloning of designs is not acceptable.',
						],
						[
							'description' => 'Any copyright statements on the front end should display the user\'s copyright, not the theme author\'s copyright.',
						],
					],
				],
				[
					'title' => 'Naming',
					'url'   => 'https://make.wordpress.org/themes/handbook/review/required/#naming',
					'items' => [
						[
							'description' => 'Theme names must not use: WordPress, Theme.',
						],
						[
							'description' => 'Child themes should not include the name of the parent theme unless the themes have the same author.',
						],
						[
							'description' => 'Spell “WordPress” correctly in all public facing text: all one word, with both an uppercase W and P.',
							'greps'       => [
								[
									'cmd' => 'grep -Ri "wordpress" <THEME>/* | grep -v "WordPress"',
									'highlights' => [ 'wordpress' ],
								],
							],
						],
					],
				],
				[
					'title' => 'Options and Settings',
					'url'   => 'https://make.wordpress.org/themes/handbook/review/required/#options-and-settings',
					'items' => [
						[
							'description' => '<a href="https://make.wordpress.org/themes/2015/04/22/details-on-the-new-theme-settings-customizer-guideline/">Use the Customizer for implementing theme options</a>.',
						],
						[
							'description' => 'Save options in a single array.',
							'greps'       => [
								[
									'cmd' => 'grep -RE "(update_option|add_option)" <THEME>/*',
									'highlights' => [ 'update_option', 'add_option' ],
								],
							],
						],
						[
							'description' => 'Don’t use transients for things they shouldn’t be used for, like storing theme options.',
						],
						[
							'description' => 'Use <a href="https://make.wordpress.org/themes/2014/07/09/using-sane-defaults-in-themes/">sane defaults</a> and don’t&nbsp;write default setting values to the database.',
						],
						[
							'description' => 'Use <em>edit_theme_options</em> capability for determining user permission to edit options, rather than rely on a role (e.g. “administrator”), or a different capability (e.g. “edit_themes”, “manage_options”).',
							'greps'       => [
								[
									'cmd' => 'grep -Ri "user_can" <THEME>/*',
									'highlights' => [ 'user_can' ],
								],
							],
						],
					],
				],
				[
					'title' => 'Plugins',
					'url'   => 'https://make.wordpress.org/themes/handbook/review/required/#plugins',
					'items' => [
						[
							'description' => 'Themes cannot include plugins.',
						],
						[
							'description' => 'Themes cannot require plugins to work.',
						],
						[
							'description' => 'Themes may recommend plugins from WordPress.org or third-party sites (link to them as free or upsell plugins, GPL licensed only).',
						],
						[
							'description' => 'Themes may use <a href="http://tgmpluginactivation.com/">TGM Plugin Activation</a> to recommend only plugins hosted on WordPress.org (by using <code>\'required\' =&gt; false</code> for each plugin).',
						],
						[
							'description' => 'Themes may include libraries such as option frameworks (these must pass the requirements).',
						],
					],
				],
				[
					'title' => 'Screenshot',
					'url'   => 'https://make.wordpress.org/themes/handbook/review/required/#screenshot',
					'items' => [
						[
							'description' => 'The screenshot should be a reasonable representation of what the theme can look like.',
						],
						[
							'description' => 'The screenshot may optionally show supported plugins, settings and templates.',
						],
						[
							'description' => 'The screenshot should not be a logo or mockup.',
						],
						[
							'description' => 'The screenshot should be no bigger than 1200 x 900px.',
						],
						[
							'description' => 'Screenshots are allowed to display only dummy text that doesn’t suggest/describe theme features, functionality, or statistics. If it looks like an AD, then it’s not allowed. Dummy text examples: Lorem ipsum (or similar generators), text that doesn’t describe your theme, company, service, or products.',
						],
					],
				],
				[
					'title' => 'Privacy',
					'url'   => 'https://make.wordpress.org/themes/handbook/review/required/#privacy',
					'items' => [
						[
							'description' => 'Don’t phone home without informed user consent. Make any collection of user data “opt-in” only and have a theme option that is set to disabled by default.',
							'greps'       => [
								[
									'cmd' => 'grep -RE "(curl|wp_remote|fopen)" <THEME>/*',
									'highlights' => [ 'curl', 'wp_remote', 'fopen' ],
								],
							],
						],
						[
							'description' => 'No URL shorteners used in the theme.',
						],
					],
				],
				[
					'title' => 'Selling, credits and links',
					'url'   => 'https://make.wordpress.org/themes/handbook/review/required/#selling-credits-and-links',
					'items' => [
						[
							'description' => 'Theme URI is optional. If used, it must be about the theme we’re hosting on WordPress.org. If the URI is a demo site, the content must be about the theme itself and not test data. Using WordPress.org in the Theme URI is reserved for official themes.',
						],
						[
							'description' => 'Author URI is optional. If used it is required to link to a page or website about the author, author theme shop, or author project/development website.',
						],
						[
							'description' => 'Themes may have a single footer credit link, which is restricted to the Theme URI or Author URI defined in style.css.',
						],
						[
							'description' => 'Themes may also have an additional footer credit link pointing to WordPress.org.',
						],
						[
							'description' => 'Your site needs to state explicitly that the products you’re selling are GPL compatible. It needs to be in an easy-to-find place for the reviewer and customers.',
						],
						[
							'description' => 'Themes should not display “obtrusive” upselling. <a href="https://make.wordpress.org/themes/handbook/review/required/explanations-and-examples/#selling-credits-and-links">Examples</a>.',
						],
						[
							'description' => 'Themes are not allowed to have affiliate URLs or links.',
						],
					],
				],
				[
					'title' => 'Stylesheets and Scripts',
					'url'   => 'https://make.wordpress.org/themes/handbook/review/required/#stylesheets-and-scripts',
					'items' => [
						[
							'description' => 'No hard coding of script and style files.',
							'greps'       => [
								[
									'cmd' => 'grep -REi "(text/css|\<*link )" <THEME>/* | grep -Ev "(@link)"',
									'highlights' => [ 'text/css', 'link' ],
								],
							],
						],
						[
							'description' => 'No minification of scripts or files unless you provide original files.',
							'greps'       => [
								[
									'cmd' => 'grep -R "(\.min)" <THEME>/*',
									'highlights' => [ '.min' ],
								],
							],
						],
						[
							'description' => 'Required to use core-bundled scripts rather than including their own version of that script. For example jQuery.',
						],
						[
							'description' => 'Include all scripts and resources it uses rather than hot-linking. The exception to this is Google Fonts.',
							'greps'       => [
								[
									'cmd' => 'grep -R "*script*src" <THEME>/*',
									'highlights' => [ 'script', 'src' ],
								],
								[
									'cmd' => 'grep -R "*link*href" <THEME>/*',
									'highlights' => [ 'link', 'href' ],
								],
							],
						],
					],
				],
				[
					'title' => 'Templates',
					'url'   => 'https://make.wordpress.org/themes/handbook/review/required/#templates',
					'items' => [
						[
							'description' => '<em>If used in the theme</em>, standard template files are required to be called by their respective function: header.php (via <a href="https://codex.wordpress.org/Function_Reference/get_header">get_header()</a>), footer.php (via <a href="https://codex.wordpress.org/Function_Reference/get_footer">get_footer()</a>)., sidebar.php (via <a href="https://codex.wordpress.org/Function_Reference/get_sidebar">get_sidebar()</a>), searchform.php (via <a href="https://codex.wordpress.org/Function_Reference/get_search_form">get_search_form()</a>).',
							'greps'       => [
								[
									'cmd' => 'grep -REi "grep -RE "(header\.php|footer\.php|sidebar\.php|searchform\.php)" <THEME>/*',
									'highlights' => [ 'header.php', 'footer.php', 'sidebar.php', 'searchform.php' ],
								]
							],
						],
						[
							'description' => '<em>If you use the relevant templates,</em> your theme should include: <a href="https://developer.wordpress.org/reference/functions/wp_head">wp_head()</a> – (immediately before <code>&lt;/head&gt;</code>), <a href="https://developer.wordpress.org/reference/functions/body_class">body_class()</a> – (inside <code>&lt;body&gt;</code> tag), <a href="https://codex.wordpress.org/Content_Width">$content_width</a>, <a href="https://developer.wordpress.org/reference/functions/post_class">post_class()</a>, <a href="https://developer.wordpress.org/reference/functions/wp_link_pages">wp_link_pages()</a>, <a href="https://developer.wordpress.org/reference/functions/the_comments_navigation/">the_comments_navigation()</a>, <a href="https://developer.wordpress.org/reference/functions/the_comments_pagination/">the_comments_pagination()</a>, <a href="https://developer.wordpress.org/reference/functions/the_posts_pagination/">the_posts_pagination()</a>, <a href="https://developer.wordpress.org/reference/functions/the_posts_navigation/">the_posts_navigation()</a>, <a href="https://developer.wordpress.org/reference/functions/wp_footer">wp_footer()</a> – (immediately before &lt;/body&gt;).',
						],
						[
							'description' => 'Have a valid DOCTYPE declaration and include <code>language_attributes()</code>.',
						],
						[
							'description' => 'Custom template files should be called using <a href="https://developer.wordpress.org/reference/functions/get_template_part/">get_template_part()</a> or <a href="https://developer.wordpress.org/reference/functions/locate_template/">locate_template()</a>.',
						],
						[
							'description' => 'Display the correct content according to the front page setting. (<a href="https://make.wordpress.org/themes/2014/06/28/correct-handling-of-static-front-page-and-custom-blog-posts-index-template/">See explanation</a>)',
						],
					],
				],
			],
		],
		[
			'title'    => 'Theme Review Team > Handbook > Review Process > How to do a review (Draft)',
			'url'      => 'https://make.wordpress.org/themes/handbook/review/how-to-do-a-review-draft/',
			'sections' => [
				[
					'title' => 'Backwards compatibility',
					'url'   => 'https://make.wordpress.org/themes/handbook/review/how-to-do-a-review-draft/#backwards-compatibility',
					'items' => [
						[
							'description' => 'Themes may be backwards compatible, but only for 3 major WordPress versions (version 4.5 if 4.8 is latest).<br />- Themes do not need to wrap older WordPress functions in <a href="http://php.net/manual/en/function.function-exists.php"><code>function_exists</code></a>.<br />- Themes should not provide fallbacks for WordPress functions added more than 3 versions ago, since we want to encourage users to upgrade their WordPress installation. This is a fairly common problem when theme authors has used an older version of <a href="http://underscores.me/">underscores</a> as a base for their theme.',
							'greps'       => [
								[
									'cmd' => 'grep -R "function_exists" <THEME>/*',
									'highlights' => [ 'function_exists' ],
								],
							],
						],
					],
				],
			],
		],
	],
];