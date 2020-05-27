<?php

/*
* Add your own functions here. You can also copy some of the theme functions into this file. 
* Wordpress will use those functions instead of the original functions then.
*/

add_filter('avia_load_shortcodes', 'avia_include_shortcode_template', 15, 1);
function avia_include_shortcode_template($paths)
{
    $template_url = get_stylesheet_directory();
    array_unshift($paths, $template_url.'/shortcodes/');

    return $paths;
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/css/custom.css',
        array('parent-style')
    );
}

function show_portfolio_category_func() {
    global $post;
    $the_terms = get_the_terms( $post->ID , 'portfolio_entries');
    ob_start();

    echo $the_terms[0]->name;

    $output = ob_get_clean();
    return $output;
}
add_shortcode('portfolio_category', 'show_portfolio_category_func');

add_action('wp_footer', 'ava_new_custom_script_mobile');
function ava_new_custom_script_mobile(){
    ?>
    <script type="text/javascript">
        (function($) {
            $(window).load(function() {
                jQuery(".slide-entry.av_one_half").each(function() {
                    var el = jQuery(this);
                    el.append("<span class='custom-caption'>" + el.attr("data-avia-tooltip") + "</span>");
                    el.attr("data-avia-tooltip", "");
                });
            });
        })(jQuery);
    </script>
    <?php
}

add_action('wp_footer', 'ava_new_custom_script_desktop');
function ava_new_custom_script_desktop(){
    ?>
    <script type="text/javascript">
        (function($) {
            $(window).load(function() {
                jQuery(".slide-entry.av_one_eighth").each(function() {
                    var el = jQuery(this);
                    el.append("<span class='custom-caption'>" + el.attr("data-avia-tooltip") + "</span>");
                    el.attr("data-avia-tooltip", "");
                });
            });
        })(jQuery);
    </script>
    <?php
}
add_theme_support('add_avia_builder_post_type_option');
