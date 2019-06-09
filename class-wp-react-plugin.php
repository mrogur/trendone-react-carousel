<?php
class TrendOne_WpReactPlugin {
    private $reactAppPath;
    /**
     * @var callable
     */
    private $hookResolver;

    /**
     * TrendOne_WpReactSlider constructor.
     * @param null|string $reactAppPath
     */
    public function __construct($reactAppPath = null)
    {
        $this->reactAppPath = $reactAppPath;
    }

    public function get_react_dist_path($fileType) {
        $basePath = plugin_dir_path(__FILE__). $this->reactAppPath;
        $baseUrl = plugins_url($this->reactAppPath, __FILE__);
        $path = glob("$basePath/$fileType/*.$fileType");
        if(empty($path)) {
            return "";
        }

        $output = [];

	    foreach ( $path as $p ) {
		    $filePath = pathinfo($p, PATHINFO_BASENAME);
		    $fileUrl = "$baseUrl/$fileType/$filePath";
		    $output[] = $fileUrl;
	    }

        return $output;
    }
    public function enqueue_scripts($hook) {
        if ($this->hookResolver !== null && !call_user_func_array($this->hookResolver, $hook)) {
            return;
        }


	    foreach ( $this->get_react_dist_path( "css" ) as $key=>$p ) {
		    wp_enqueue_style("trendone-slider-$key", $p);
	    }

	    foreach ( $this->get_react_dist_path( "js" ) as $key => $p ) {
		    wp_enqueue_script("trendone-slider-$key", $p, [], true, true );
	    }
    }

    /**
     * @return mixed
     */
    public function getReactAppPath()
    {
        return $this->reactAppPath;
    }

    /**
     * @param mixed $reactAppPath
     * @return TrendOne_WpReactPlugin
     */
    public function setReactAppPath($reactAppPath)
    {
        $this->reactAppPath = $reactAppPath;
        return $this;
    }

    /**
     * @return callable
     */
    public function getHookResolver()
    {
        return $this->hookResolver;
    }

    /**
     * @param callable $hookResolver
     */
    public function setHookResolver($hookResolver)
    {
        $this->hookResolver = $hookResolver;
    }



    public function init_actions()
    {
        add_action('wp_enqueue_scripts',  [$this, 'enqueue_scripts'],10, 1);
	    add_action('rest_api_init', function () {
		    $api = new TrendOne_ReactCarouselApi("numery-archiwalne");
		    $api->register_routes();
	    });

    }

}



