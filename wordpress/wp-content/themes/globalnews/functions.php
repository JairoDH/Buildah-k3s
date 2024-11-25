<?php
if (!function_exists('globalnews_theme_enqueue_styles')) {
    add_action('wp_enqueue_scripts', 'globalnews_theme_enqueue_styles');

    function globalnews_theme_enqueue_styles()
    {
        $min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        $globalnews_version = wp_get_theme()->get('Version');
        $parent_style = 'morenews-style';

        // Enqueue Parent and Child Theme Styles
        wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap' . $min . '.css', array(), $globalnews_version);
        wp_enqueue_style($parent_style, get_template_directory_uri() . '/style' . $min . '.css', array(), $globalnews_version);
        wp_enqueue_style(
            'globalnews',
            get_stylesheet_directory_uri() . '/style.css',
            array('bootstrap', $parent_style),
            $globalnews_version
        );

        // Enqueue RTL Styles if the site is in RTL mode
        if (is_rtl()) {
            wp_enqueue_style(
                'morenews-rtl',
                get_template_directory_uri() . '/rtl.css',
                array($parent_style),
                $globalnews_version
            );
        }
    }
}

// Set up the WordPress core custom background feature.
add_theme_support('custom-background', apply_filters('morenews_custom_background_args', array(
    'default-color' => 'f5f5f5',
    'default-image' => '',
)));


function globalnews_custom_header_setup($default_custom_header){
    $default_custom_header['default-text-color'] = 'ffffff';
    return $default_custom_header;
}
add_filter('morenews_custom_header_args', 'globalnews_custom_header_setup', 1);

function globalnews_override_morenews_header_section()
{
    remove_action('morenews_action_header_section', 'morenews_header_section', 40);
}

add_action('wp_loaded', 'globalnews_override_morenews_header_section');

function globalnews_header_section()
{

    $morenews_header_layout = morenews_get_option('header_layout');


?>

    <header id="masthead" class="<?php echo esc_attr($morenews_header_layout); ?> morenews-header">
        <?php morenews_get_block('layout-centered', 'header');  ?>
    </header>

<?php
}

add_action('morenews_action_header_section', 'globalnews_header_section', 40);

function globalnews_filter_default_theme_options($defaults)
{
    $defaults['global_site_mode_setting']    = 'aft-dark-mode';
    $defaults['dark_background_color']     = '#1A1A1A';
    $defaults['site_title_font_size'] = 64;
    $defaults['site_title_uppercase']  = 0;
    $defaults['disable_header_image_tint_overlay']  = 1;
    $defaults['show_primary_menu_desc']  = 0;
    $defaults['header_layout'] = 'header-layout-centered';
    $defaults['flash_news_title'] = __('Breaking News', 'globalnews');
    $defaults['aft_custom_title']           = __('Watch Video', 'globalnews');   
    $defaults['main_popular_news_section_title'] = __('Popular News', 'morenews'); 
    $defaults['main_latest_news_section_title'] = __('Latest News', 'morenews'); 
    $defaults['secondary_color'] = '#ff0000';
    $defaults['global_fetch_content_image_setting'] = 'disable';
    $defaults['global_show_min_read'] = 'no';
    $defaults['frontpage_content_type']  = 'frontpage-widgets-and-content';
    $defaults['featured_news_section_title'] = __('Featured News', 'morenews');
    $defaults['show_featured_post_list_section'] = 1;
    $defaults['featured_post_list_section_title_1']           = __('General News', 'globalnews');
    $defaults['featured_post_list_section_title_2']           = __('Central News', 'globalnews');
    $defaults['featured_post_list_section_title_3']           = __('More News', 'globalnews');
    
    return $defaults;
}
add_filter('morenews_filter_default_theme_options', 'globalnews_filter_default_theme_options', 1);
