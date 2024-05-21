<?php
/**
 * Event Conference Theme Customizer
 *
 * @link: https://developer.wordpress.org/themes/customize-api/customizer-objects/
 *
 * @package Event Conference
 */

if ( ! defined( 'EVENT_CONFERENCE_URL' ) ) {
    define( 'EVENT_CONFERENCE_URL', esc_url( 'https://www.themagnifico.net/themes/event-wordpress-theme/', 'event-conference') );
}
if ( ! defined( 'EVENT_CONFERENCE_TEXT' ) ) {
    define( 'EVENT_CONFERENCE_TEXT', __( 'Event Conference Pro','event-conference' ));
}
if ( ! defined( 'EVENT_CONFERENCE_BUY_TEXT' ) ) {
    define( 'EVENT_CONFERENCE_BUY_TEXT', __( 'Buy Event Conference Pro','event-conference' ));
}

use WPTRT\Customize\Section\Event_Conference_Button;

add_action( 'customize_register', function( $manager ) {

    $manager->register_section_type( Event_Conference_Button::class );

    $manager->add_section(
        new Event_Conference_Button( $manager, 'event_conference_pro', [
            'title'       => esc_html( EVENT_CONFERENCE_TEXT,'event-conference' ),
            'priority'    => 0,
            'button_text' => __( 'GET PREMIUM', 'event-conference' ),
            'button_url'  => esc_url( EVENT_CONFERENCE_URL )
        ] )
    );

} );

// Load the JS and CSS.
add_action( 'customize_controls_enqueue_scripts', function() {

    $version = wp_get_theme()->get( 'Version' );

    wp_enqueue_script(
        'event-conference-customize-section-button',
        get_theme_file_uri( 'vendor/wptrt/customize-section-button/public/js/customize-controls.js' ),
        [ 'customize-controls' ],
        $version,
        true
    );

    wp_enqueue_style(
        'event-conference-customize-section-button',
        get_theme_file_uri( 'vendor/wptrt/customize-section-button/public/css/customize-controls.css' ),
        [ 'customize-controls' ],
        $version
    );

} );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function event_conference_customize_register($wp_customize){

    // Pro Version
    class Event_Conference_Customize_Pro_Version extends WP_Customize_Control {
        public $type = 'pro_options';

        public function render_content() {
            echo '<span>For More <strong>'. esc_html( $this->label ) .'</strong>?</span>';
            echo '<a href="'. esc_url($this->description) .'" target="_blank">';
                echo '<span class="dashicons dashicons-info"></span>';
                echo '<strong> '. esc_html( EVENT_CONFERENCE_BUY_TEXT,'event-conference' ) .'<strong></a>';
            echo '</a>';
        }
    }

    // Custom Controls
    function Event_Conference_sanitize_custom_control( $input ) {
        return $input;
    }

    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';

    //Logo
    $wp_customize->add_setting('event_conference_logo_max_height',array(
        'default'   => '24',
        'sanitize_callback' => 'event_conference_sanitize_number_absint'
    ));
    $wp_customize->add_control('event_conference_logo_max_height',array(
        'label' => esc_html__('Logo Width','event-conference'),
        'section'   => 'title_tagline',
        'type'      => 'number'
    ));

    $wp_customize->add_setting('event_conference_logo_title_text', array(
        'default' => true,
        'sanitize_callback' => 'event_conference_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'event_conference_logo_title_text',array(
        'label'          => __( 'Enable Disable Title', 'event-conference' ),
        'section'        => 'title_tagline',
        'settings'       => 'event_conference_logo_title_text',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting('event_conference_theme_description', array(
        'default' => false,
        'sanitize_callback' => 'event_conference_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'event_conference_theme_description',array(
        'label'          => __( 'Enable Disable Tagline', 'event-conference' ),
        'section'        => 'title_tagline',
        'settings'       => 'event_conference_theme_description',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting('event_conference_logo_title_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'event_conference_logo_title_color', array(
        'label'    => __('Site Title Color', 'event-conference'),
        'section'  => 'title_tagline'
    )));

    $wp_customize->add_setting('event_conference_logo_tagline_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'event_conference_logo_tagline_color', array(
        'label'    => __('Site Tagline Color', 'event-conference'),
        'section'  => 'title_tagline'
    )));

    // Pro Version
    $wp_customize->add_setting( 'pro_version_logo', array(
        'sanitize_callback' => 'Event_Conference_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Event_Conference_Customize_Pro_Version ( $wp_customize,'pro_version_logo', array(
        'section'     => 'title_tagline',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'event-conference' ),
        'description' => esc_url( EVENT_CONFERENCE_URL ),
        'priority'    => 100
    )));

    // General Settings
     $wp_customize->add_section('event_conference_general_settings',array(
        'title' => esc_html__('General Settings','event-conference'),
        'priority'   => 30,
    ));

    $wp_customize->add_setting('event_conference_preloader_hide', array(
        'default' => 0,
        'sanitize_callback' => 'event_conference_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'event_conference_preloader_hide',array(
        'label'          => __( 'Show Theme Preloader', 'event-conference' ),
        'section'        => 'event_conference_general_settings',
        'settings'       => 'event_conference_preloader_hide',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting( 'event_conference_preloader_bg_color', array(
        'default' => '#0F1330',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'event_conference_preloader_bg_color', array(
        'label' => esc_html__('Preloader Background Color','event-conference'),
        'section' => 'event_conference_general_settings',
        'settings' => 'event_conference_preloader_bg_color'
    )));

    $wp_customize->add_setting( 'event_conference_preloader_dot_1_color', array(
        'default' => '#AD00FF',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'event_conference_preloader_dot_1_color', array(
        'label' => esc_html__('Preloader First Dot Color','event-conference'),
        'section' => 'event_conference_general_settings',
        'settings' => 'event_conference_preloader_dot_1_color'
    )));

    $wp_customize->add_setting( 'event_conference_preloader_dot_2_color', array(
        'default' => '#FF8A00',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'event_conference_preloader_dot_2_color', array(
        'label' => esc_html__('Preloader Second Dot Color','event-conference'),
        'section' => 'event_conference_general_settings',
        'settings' => 'event_conference_preloader_dot_2_color'
    )));

    $wp_customize->add_setting('event_conference_scroll_hide', array(
        'default' => false,
        'sanitize_callback' => 'event_conference_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'event_conference_scroll_hide',array(
        'label'          => __( 'Show Theme Scroll To Top', 'event-conference' ),
        'section'        => 'event_conference_general_settings',
        'settings'       => 'event_conference_scroll_hide',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting('event_conference_scroll_top_position',array(
        'default' => 'Right',
        'sanitize_callback' => 'event_conference_sanitize_choices'
    ));
    $wp_customize->add_control('event_conference_scroll_top_position',array(
        'type' => 'radio',
        'section' => 'event_conference_general_settings',
        'choices' => array(
            'Right' => __('Right','event-conference'),
            'Left' => __('Left','event-conference'),
            'Center' => __('Center','event-conference')
        ),
    ) );

    // Product Columns
    $wp_customize->add_setting( 'event_conference_products_per_row' , array(
       'default'           => '3',
       'transport'         => 'refresh',
       'sanitize_callback' => 'event_conference_sanitize_select',
    ) );

    $wp_customize->add_control('event_conference_products_per_row', array(
       'label' => __( 'Product per row', 'event-conference' ),
       'section'  => 'event_conference_general_settings',
       'type'     => 'select',
       'choices'  => array(
           '2' => '2',
           '3' => '3',
           '4' => '4',
       ),
    ) );

    //Products border radius
    $wp_customize->add_setting( 'event_conference_woo_product_border_radius', array(
        'default'              => '0',
        'transport'            => 'refresh',
        'sanitize_callback'    => 'event_conference_sanitize_number_range'
    ) );
    $wp_customize->add_control( 'event_conference_woo_product_border_radius', array(
        'label'       => esc_html__( 'Product Border Radius','event-conference' ),
        'section'     => 'event_conference_general_settings',
        'type'        => 'range',
        'input_attrs' => array(
            'step'             => 1,
            'min'              => 1,
            'max'              => 150,
        ),
    ) );

    // Pro Version
    $wp_customize->add_setting( 'pro_version_general_setting', array(
        'sanitize_callback' => 'Event_Conference_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Event_Conference_Customize_Pro_Version ( $wp_customize,'pro_version_general_setting', array(
        'section'     => 'event_conference_general_settings',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'event-conference' ),
        'description' => esc_url( EVENT_CONFERENCE_URL ),
        'priority'    => 100
    )));

     // Social Link
    $wp_customize->add_section('event_conference_social_link',array(
        'title' => esc_html__('Social Links','event-conference'),
    ));

    $wp_customize->add_setting('event_conference_facebook_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('event_conference_facebook_icon',array(
        'label' => esc_html__('Facebook Icon','event-conference'),
        'section' => 'event_conference_social_link',
        'setting' => 'event_conference_facebook_icon',
        'type'  => 'text',
        'default' => 'fab fa-facebook-f',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fab fa-facebook-f','event-conference')
    ));

    $wp_customize->add_setting('event_conference_facebook_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('event_conference_facebook_url',array(
        'label' => esc_html__('Facebook Link','event-conference'),
        'section' => 'event_conference_social_link',
        'setting' => 'event_conference_facebook_url',
        'type'  => 'url'
    ));


    $wp_customize->add_setting('event_conference_twitter_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('event_conference_twitter_icon',array(
        'label' => esc_html__('Twitter Icon','event-conference'),
        'section' => 'event_conference_social_link',
        'setting' => 'event_conference_twitter_icon',
        'type'  => 'text',
        'default' => 'fab fa-twitter',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fab fa-twitter','event-conference')
    ));

    $wp_customize->add_setting('event_conference_twitter_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('event_conference_twitter_url',array(
        'label' => esc_html__('Twitter Link','event-conference'),
        'section' => 'event_conference_social_link',
        'setting' => 'event_conference_twitter_url',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('event_conference_intagram_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('event_conference_intagram_icon',array(
        'label' => esc_html__('Intagram Icon','event-conference'),
        'section' => 'event_conference_social_link',
        'setting' => 'event_conference_intagram_icon',
        'type'  => 'text',
        'default' => 'fab fa-instagram',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fab fa-instagram','event-conference')
    ));

    $wp_customize->add_setting('event_conference_intagram_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('event_conference_intagram_url',array(
        'label' => esc_html__('Intagram Link','event-conference'),
        'section' => 'event_conference_social_link',
        'setting' => 'event_conference_intagram_url',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('event_conference_linkedin_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('event_conference_linkedin_icon',array(
        'label' => esc_html__('Linkedin Icon','event-conference'),
        'section' => 'event_conference_social_link',
        'setting' => 'event_conference_linkedin_icon',
        'type'  => 'text',
        'default' => 'fab fa-linkedin-in',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fab fa-linkedin-in','event-conference')
    ));

    $wp_customize->add_setting('event_conference_linkedin_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('event_conference_linkedin_url',array(
        'label' => esc_html__('Linkedin Link','event-conference'),
        'section' => 'event_conference_social_link',
        'setting' => 'event_conference_linkedin_url',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('event_conference_pintrest_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('event_conference_pintrest_icon',array(
        'label' => esc_html__('Pinterest Icon','event-conference'),
        'section' => 'event_conference_social_link',
        'setting' => 'event_conference_pintrest_icon',
        'type'  => 'text',
        'default' => 'fab fa-pinterest-p',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fab fa-pinterest-p','event-conference')
    ));

    $wp_customize->add_setting('event_conference_pintrest_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('event_conference_pintrest_url',array(
        'label' => esc_html__('Pinterest Link','event-conference'),
        'section' => 'event_conference_social_link',
        'setting' => 'event_conference_pintrest_url',
        'type'  => 'url'
    ));

    // Pro Version
    $wp_customize->add_setting( 'pro_version_social_setting', array(
        'sanitize_callback' => 'Event_Conference_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Event_Conference_Customize_Pro_Version ( $wp_customize,'pro_version_social_setting', array(
        'section'     => 'event_conference_social_link',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'event-conference' ),
        'description' => esc_url( EVENT_CONFERENCE_URL ),
        'priority'    => 100
    )));

    //TopBar
    $wp_customize->add_section('event_conference_topbar',array(
        'title' => esc_html__('Header Option','event-conference')
    ));

    $wp_customize->add_setting('event_conference_header_button',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('event_conference_header_button',array(
        'label' => esc_html__('Button Text','event-conference'),
        'section' => 'event_conference_topbar',
        'setting' => 'event_conference_header_button',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('event_conference_header_button_url',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('event_conference_header_button_url',array(
        'label' => esc_html__('Button Url','event-conference'),
        'section' => 'event_conference_topbar',
        'setting' => 'event_conference_header_button_url',
        'type'  => 'text'
    ));

    // Pro Version
    $wp_customize->add_setting( 'pro_version_topbar_setting', array(
        'sanitize_callback' => 'Event_Conference_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Event_Conference_Customize_Pro_Version ( $wp_customize,'pro_version_topbar_setting', array(
        'section'     => 'event_conference_topbar',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'event-conference' ),
        'description' => esc_url( EVENT_CONFERENCE_URL ),
        'priority'    => 100
    )));

     //Slider
    $wp_customize->add_section('event_conference_top_slider',array(
        'title' => esc_html__('Slider Settings','event-conference'),
        'description' => esc_html__('Here you have to add 3 different pages in below dropdown. Note: Image Dimensions 1400 x 550 px','event-conference')
    ));

     $wp_customize->add_setting('event_conference_topbar_phone_text',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('event_conference_topbar_phone_text',array(
        'label' => esc_html__('Phone Text','event-conference'),
        'section' => 'event_conference_top_slider',
        'setting' => 'event_conference_topbar_phone_text',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('event_conference_topbar_phone_number',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('event_conference_topbar_phone_number',array(
        'label' => esc_html__('Phone Number','event-conference'),
        'section' => 'event_conference_top_slider',
        'setting' => 'event_conference_topbar_phone_number',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('event_conference_topbar_email_text',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('event_conference_topbar_email_text',array(
        'label' => esc_html__('Email Text','event-conference'),
        'section' => 'event_conference_top_slider',
        'setting' => 'event_conference_topbar_email_text',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('event_conference_topbar_email_id',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('event_conference_topbar_email_id',array(
        'label' => esc_html__('Email Id','event-conference'),
        'section' => 'event_conference_top_slider',
        'setting' => 'event_conference_topbar_email_id',
        'type'  => 'text'
    ));

    for ($event_conference_count = 1; $event_conference_count <= 3; $event_conference_count++) {
        $wp_customize->add_setting('event_conference_top_slider_post' . $event_conference_count, array(
            'default'           => '',
            'sanitize_callback' => 'event_conference_sanitize_dropdown_posts'
        ));

        $wp_customize->add_control('event_conference_top_slider_post' . $event_conference_count, array(
            'label'    => __('Select Slide Post', 'event-conference'),
            'description' => __('Slider image size (1030 x 430)','event-conference'),
            'section'  => 'event_conference_top_slider',
            'type'     => 'select',
            'choices'  => event_conference_get_all_posts(),
        ));
    }

    //Slider height
    $wp_customize->add_setting('event_conference_slider_img_height',array(
        'default'=> '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('event_conference_slider_img_height',array(
        'label' => __('Slider Height','event-conference'),
        'description'   => __('Add the slider height in px(eg. 500px).','event-conference'),
        'input_attrs' => array(
            'placeholder' => __( '500px', 'event-conference' ),
        ),
        'section'=> 'event_conference_top_slider',
        'type'=> 'text'
    ));

    // Pro Version
    $wp_customize->add_setting( 'pro_version_slider_setting', array(
        'sanitize_callback' => 'Event_Conference_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Event_Conference_Customize_Pro_Version ( $wp_customize,'pro_version_slider_setting', array(
        'section'     => 'event_conference_top_slider',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'event-conference' ),
        'description' => esc_url( EVENT_CONFERENCE_URL ),
        'priority'    => 100
    )));

     // Featured
    $wp_customize->add_section('event_conference_services_section',array(
        'title' => esc_html__('Featured Option','event-conference'),
    ));

    $wp_customize->add_setting('event_conference_services_title',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('event_conference_services_title',array(
        'label' => esc_html__('Featured Text','event-conference'),
        'section' => 'event_conference_services_section',
        'setting' => 'event_conference_services_title',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('event_conference_services_heading',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('event_conference_services_heading',array(
        'label' => esc_html__('Featured Heading','event-conference'),
        'section' => 'event_conference_services_section',
        'setting' => 'event_conference_services_heading',
        'type'  => 'text'
    ));

    $categories = get_categories();
    $cat_post = array();
    $cat_post[]= 'select';
    $i = 0;
    foreach($categories as $category){
        if($i==0){
            $default = $category->slug;
            $i++;
        }
        $cat_post[$category->slug] = $category->name;
    }

    $wp_customize->add_setting('event_conference_services_sec_category',array(
        'default'   => 'select',
        'sanitize_callback' => 'event_conference_sanitize_select',
    ));
    $wp_customize->add_control('event_conference_services_sec_category',array(
        'type'    => 'select',
        'choices' => $cat_post,
        'label' => __('Select Category to display services','event-conference'),
        'section' => 'event_conference_services_section',
    ));

    $wp_customize->add_setting('event_conference_services_designation',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('event_conference_services_designation',array(
        'label' => esc_html__('Designation','event-conference'),
        'section' => 'event_conference_services_section',
        'setting' => 'event_conference_services_designation',
        'type'  => 'text'
    ));

    // Pro Version
    $wp_customize->add_setting( 'pro_version_services_setting', array(
        'sanitize_callback' => 'Event_Conference_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Event_Conference_Customize_Pro_Version ( $wp_customize,'pro_version_services_setting', array(
        'section'     => 'event_conference_services_section',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'event-conference' ),
        'description' => esc_url( EVENT_CONFERENCE_URL ),
        'priority'    => 100
    )));

    // Post Settings
     $wp_customize->add_section('event_conference_post_settings',array(
        'title' => esc_html__('Post Settings','event-conference'),
        'priority'   =>40,
    ));

    $wp_customize->add_setting('event_conference_post_page_title',array(
        'sanitize_callback' => 'event_conference_sanitize_checkbox',
        'default'           => 1,
    ));
    $wp_customize->add_control('event_conference_post_page_title',array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Enable Post Page Title', 'event-conference'),
        'section'     => 'event_conference_post_settings',
        'description' => esc_html__('Check this box to enable title on post page.', 'event-conference'),
    ));

    $wp_customize->add_setting('event_conference_post_page_meta',array(
        'sanitize_callback' => 'event_conference_sanitize_checkbox',
        'default'           => 1,
    ));
    $wp_customize->add_control('event_conference_post_page_meta',array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Enable Post Page Meta', 'event-conference'),
        'section'     => 'event_conference_post_settings',
        'description' => esc_html__('Check this box to enable meta on post page.', 'event-conference'),
    ));

    $wp_customize->add_setting('event_conference_post_page_thumb',array(
        'sanitize_callback' => 'event_conference_sanitize_checkbox',
        'default'           => 1,
    ));
    $wp_customize->add_control('event_conference_post_page_thumb',array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Enable Post Page Thumbnail', 'event-conference'),
        'section'     => 'event_conference_post_settings',
        'description' => esc_html__('Check this box to enable thumbnail on post page.', 'event-conference'),
    ));

    $wp_customize->add_setting('event_conference_single_post_navigation_show_hide',array(
        'default' => true,
        'sanitize_callback' => 'event_conference_sanitize_checkbox'
    ));
    $wp_customize->add_control('event_conference_single_post_navigation_show_hide',array(
        'type' => 'checkbox',
        'label' => __('Show / Hide Post Navigation','event-conference'),
        'section' => 'event_conference_post_settings',
    ));

    // Pro Version
    $wp_customize->add_setting( 'pro_version_post_setting', array(
        'sanitize_callback' => 'Event_Conference_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Event_Conference_Customize_Pro_Version ( $wp_customize,'pro_version_post_setting', array(
        'section'     => 'event_conference_post_settings',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'event-conference' ),
        'description' => esc_url( EVENT_CONFERENCE_URL ),
        'priority'    => 100
    )));
    
    // Footer
    $wp_customize->add_section('event_conference_site_footer_section', array(
        'title' => esc_html__('Footer', 'event-conference'),
    ));

    $wp_customize->add_setting('event_conference_footer_bg_image',array(
        'default'   => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'event_conference_footer_bg_image',array(
        'label' => __('Footer Background Image','event-conference'),
        'section' => 'event_conference_site_footer_section',
        'priority' => 1,
    )));

    $wp_customize->add_setting('event_conference_footer_text_setting', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('event_conference_footer_text_setting', array(
        'label' => __('Replace the footer text', 'event-conference'),
        'section' => 'event_conference_site_footer_section',
        'priority' => 1,
        'type' => 'text',
    ));

    $wp_customize->add_setting('event_conference_show_hide_copyright',array(
        'default' => true,
        'sanitize_callback' => 'event_conference_sanitize_checkbox'
    ));
    $wp_customize->add_control('event_conference_show_hide_copyright',array(
        'type' => 'checkbox',
        'label' => __('Show / Hide Copyright','event-conference'),
        'section' => 'event_conference_site_footer_section',
    ));

    $wp_customize->add_setting('event_conference_copyright_background_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'event_conference_copyright_background_color', array(
        'label'    => __('Copyright Background Color', 'event-conference'),
        'section'  => 'event_conference_site_footer_section',
    )));

     // Pro Version
    $wp_customize->add_setting( 'pro_version_footer_setting', array(
        'sanitize_callback' => 'Event_Conference_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Event_Conference_Customize_Pro_Version ( $wp_customize,'pro_version_footer_setting', array(
        'section'     => 'event_conference_site_footer_section',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'event-conference' ),
        'description' => esc_url( EVENT_CONFERENCE_URL ),
        'priority'    => 100
    )));
    
}
add_action('customize_register', 'event_conference_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function event_conference_customize_partial_blogname(){
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function event_conference_customize_partial_blogdescription(){
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function event_conference_customize_preview_js(){
    wp_enqueue_script('event-conference-customizer', esc_url(get_template_directory_uri()) . '/assets/js/customizer.js', array('customize-preview'), '20151215', true);
}
add_action('customize_preview_init', 'event_conference_customize_preview_js');

/*
** Load dynamic logic for the customizer controls area.
*/
function event_conference_panels_js() {
    wp_enqueue_style( 'event-conference-customizer-layout-css', get_theme_file_uri( '/assets/css/customizer-layout.css' ) );
    wp_enqueue_script( 'event-conference-customize-layout', get_theme_file_uri( '/assets/js/customize-layout.js' ), array(), '1.2', true );
}
add_action( 'customize_controls_enqueue_scripts', 'event_conference_panels_js' );