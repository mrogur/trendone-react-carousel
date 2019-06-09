<?php
/**
 * Created by IntelliJ IDEA.
 * User: pwlazlo
 * Date: 16.02.2018
 * Time: 21:39
 */

require_once(__DIR__ . "/class-wp-react-plugin.php");

class TrendOne_WpReactCarousel
{
    /**
     * @var string
     */
    private $assetsPath;
    /**
     * @var TrendOne_WpReactPlugin
     */
    private $wpReactSlider;

    public function __construct($reactAppPath, $wpReactSlider)
    {
        $this->assetsPath = $reactAppPath;

        $this->wpReactSlider = $wpReactSlider;
        $this->wpReactSlider->setReactAppPath($reactAppPath);
    }

    public function init_actions()
    {
        if ($this->wpReactSlider !== null) {
            $this->wpReactSlider->init_actions();
        }
    }

    public function add_shortcodes()
    {
        add_shortcode("trendone_react_slider", function () {
            ob_start();
            ?>
            <div id="trendone-react-slider"></div>
            <?php
            $contents = ob_get_contents();
            ob_get_clean();
            return $contents;
        });
    }
}