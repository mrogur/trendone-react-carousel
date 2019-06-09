<?php
/*
Plugin Name: TrendOne React Carousel
Plugin URI:  http://trendair.info/react-slider
Description: TrenOne React Slick Carousel Plugin
Version:     2018.01.26.1
Author:      Pawel Wlazlo
Author URI:  http://trendair.info/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: tro-rc
Domain Path: /languages
*/
require_once(__DIR__ . "/class-wp-react-plugin.php");
require_once (__DIR__ . "/class-wp-react-carousel.php");
require_once(__DIR__ . "/class-react-carousel-api.php");

add_action("plugins_loaded", function () {
    add_image_size("trendone_carousel", 297, 403, false);
    $reactSliderBase = new TrendOne_WpReactPlugin();
    $trone = new TrendOne_WpReactCarousel("trendone-react-carousel-app/build/static", $reactSliderBase);
    $trone->init_actions();
    $trone->add_shortcodes();
});




/*function myplugin_register_endpoints() {
	register_rest_route(
		'hello-world/v1',
		'/phrase',
		array(
			'method'   => 'GET',
            'callback' => 'myplugin_get_endpoint_phrase',
        )
    );
}

function myplugin_get_endpoint_phrase() {
	return "dsfafdas";
};

add_action( 'rest_api_init', `myplugin_register_endpoints` );
*/



