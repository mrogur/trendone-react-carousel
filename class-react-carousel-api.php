<?php
/**
 * Created by IntelliJ IDEA.
 * User: pwlazlo
 * Date: 16.02.2018
 * Time: 21:43
 */

class TrendOne_ReactCarouselApi extends WP_REST_Controller
{
    private $trendoneSliderSlug;

    public function __construct($trendoneSliderSlug)
    {

        $this->trendoneSliderSlug = $trendoneSliderSlug;
    }
    public function register_routes()
    {
        $version = '1';
        $namespace = 'trendone/v' . $version;
        $base = 'slides';
        register_rest_route($namespace, '/' . $base, [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'get_slides']
        ]);
    }

    public function get_slides()
    {
        return new WP_REST_Response($this->make_response_data(), 200);
    }

    public function make_response_data()
    {
        $slider = get_posts(['post_type' => 'slider',
            'tax_query' => [
                ['taxonomy' => 'slider-name', 'field' => 'slug', 'terms' => $this->trendoneSliderSlug]
            ]
        ]);
        $count = 0;
        $responseData = [];
        /**
         * @var $post WP_Post
         */
        foreach ($slider as $post) {
            $attachment_id = get_post_thumbnail_id($post->ID);
            $size = 'trendone_carousel';
            $image = wp_get_attachment_image_src($attachment_id, $size, null);
            $buttonUrl = get_post_meta($post->ID, 'tro_button_url', true);
            if (!$image) {
                continue;
            }
            list($src, $width, $height) = $image;
            $responseData[] = [
                'postId' => $post->ID,
                'imgUrl' => $src,
                'buttonUrl' => $buttonUrl != null ? $buttonUrl : ""
            ];
        }
        return $responseData;
    }

}

