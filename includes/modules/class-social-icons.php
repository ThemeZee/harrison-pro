<?php
/**
 * Social Icons Menus
 *
 * @package Harrison Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header Bar Class
 */
class Harrison_Pro_Social_Icons {

	/**
	 * Class Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Harrison Theme is not active.
		if ( ! current_theme_supports( 'harrison-pro' ) ) {
			return;
		}

		// Replace menu links with social icons.
		add_filter( 'walker_nav_menu_start_el', array( __CLASS__, 'social_icons_menu_walker' ), 10, 4 );
	}

	/**
	 * Displays social icons menu
	 *
	 * @return void
	 */
	static function display_social_icons_menu( $menu ) {
		wp_nav_menu( array(
			'theme_location' => $menu,
			'container'      => false,
			'menu_class'     => $menu . '-menu social-icons-menu',
			'echo'           => true,
			'fallback_cb'    => '',
			'link_before'    => '<span class = "screen-reader-text">',
			'link_after'     => '</span>',
			'depth'          => 1,
		) );
	}

	/**
	 * Return SVG markup for social icons.
	 *
	 * @param string $icon SVG icon id.
	 * @return string $svg SVG markup.
	 */
	static function get_social_svg( $icon = null ) {
		// Return early if no icon was defined.
		if ( empty( $icon ) ) {
			return;
		}

		// Create SVG markup.
		$svg  = '<svg class="icon icon-' . esc_attr( $icon ) . '" aria-hidden="true" role="img">';
		$svg .= ' <use xlink:href="' . HARRISON_PRO_PLUGIN_URL . 'assets/icons/social-icons.svg?ver=20251219#icon-' . esc_html( $icon ) . '"></use> ';
		$svg .= '</svg>';

		return $svg;
	}

	/**
	 * Display SVG icons in social links menu.
	 *
	 * @param  string  $item_output The menu item output.
	 * @param  WP_Post $item        Menu item object.
	 * @param  int     $depth       Depth of the menu.
	 * @param  array   $args        wp_nav_menu() arguments.
	 * @return string  $item_output The menu item output with social icon.
	 */
	static function social_icons_menu_walker( $item_output, $item, $depth, $args ) {
		// Return early if no social menu is filtered.
		if ( ! ( 'social-header' === $args->theme_location || 'social-footer' === $args->theme_location ) ) {
			return $item_output;
		}

		// Get supported social icons.
		$social_icons = self::supported_social_icons();

		// Search if menu URL is in supported icons.
		$icon = 'star';
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== stripos( $item_output, $attr ) ) {
				$icon = esc_attr( $value );
			}
		}

		// Get SVG.
		$svg = apply_filters( 'harrison_pro_get_social_svg', self::get_social_svg( $icon ), $item_output );

		// Add SVG to menu item.
		$item_output = str_replace( $args->link_after, $args->link_after . $svg, $item_output );

		return $item_output;
	}

	/**
	 * Returns an array of supported social links (URL and icon name).
	 *
	 * @return array $social_links_icons
	 */
	static function supported_social_icons() {
		// Supported social links icons.
		$supported_social_icons = array(
			'500px'           => '500px',
			'amazon'          => 'amazon',
			'apple'           => 'apple',
			'bandcamp'        => 'bandcamp',
			'behance.net'     => 'behance',
			'bitbucket'       => 'bitbucket',
			'bsky.app'        => 'bluesky',
			'codepen'         => 'codepen',
			'deviantart'      => 'deviantart',
			'digg.com'        => 'digg',
			'discord'         => 'discord',
			'dribbble'        => 'dribbble',
			'dropbox.com'     => 'dropbox',
			'etsy.com'        => 'etsy',
			'facebook.com'    => 'facebook',
			'feed'            => 'rss',
			'rss'             => 'rss',
			'flickr.com'      => 'flickr',
			'foursquare.com'  => 'foursquare',
			'github.com'      => 'github',
			'instagram.com'   => 'instagram',
			'linkedin.com'    => 'linkedin',
			'mailto:'         => 'envelope',
			'mastodon'        => 'mastodon',
			'medium.com'      => 'medium-m',
			'meetup.com'      => 'meetup',
			'patreon'         => 'patreon',
			'pinterest'       => 'pinterest-p',
			'getpocket.com'   => 'get-pocket',
			'reddit.com'      => 'reddit-alien',
			'skype.com'       => 'skype',
			'skype:'          => 'skype',
			'slideshare'      => 'slideshare',
			'snapchat.com'    => 'snapchat',
			'soundcloud.com'  => 'soundcloud',
			'spotify.com'     => 'spotify',
			'steam'           => 'steam',
			'strava'          => 'strava',
			'stumbleupon.com' => 'stumbleupon',
			'telegram'        => 'telegram',
			't.me'            => 'telegram',
			'tumblr.com'      => 'tumblr',
			'twitch.tv'       => 'twitch',
			'twitter.com'     => 'twitter',
			'vimeo.com'       => 'vimeo',
			'vine.co'         => 'vine',
			'vk.com'          => 'vk',
			'whatsapp'        => 'whatsapp',
			'wa.me'           => 'whatsapp',
			'wordpress.org'   => 'wordpress',
			'wordpress.com'   => 'wordpress',
			'x.com'           => 'x-twitter',
			'xing.com'        => 'xing',
			'yelp.com'        => 'yelp',
			'youtube.com'     => 'youtube',
		);

		return apply_filters( 'harrison_pro_supported_social_icons', $supported_social_icons );
	}

	/**
	 * Register navigation menus
	 *
	 * @return void
	 */
	static function register_nav_menus() {

		// Return early if Harrison Theme is not active.
		if ( ! current_theme_supports( 'harrison-pro' ) ) {
			return;
		}

		register_nav_menus( array(
			'social-header' => esc_html__( 'Social Icons (Header)', 'harrison-pro' ),
			'social-footer' => esc_html__( 'Social Icons (Footer)', 'harrison-pro' ),
		) );

	}
}

// Run Class.
add_action( 'init', array( 'Harrison_Pro_Social_Icons', 'setup' ) );

// Register navigation menus in backend.
add_action( 'after_setup_theme', array( 'Harrison_Pro_Social_Icons', 'register_nav_menus' ), 30 );
