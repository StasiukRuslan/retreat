<?php
/**
 * Event Conference functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Event Conference
 */

include get_theme_file_path( 'vendor/wptrt/autoload/src/Event_Conference_Loader.php' );

$Event_Conference_Loader = new \WPTRT\Autoload\Event_Conference_Loader();

$Event_Conference_Loader->event_conference_add( 'WPTRT\\Customize\\Section', get_theme_file_path( 'vendor/wptrt/customize-section-button/src' ) );

$Event_Conference_Loader->event_conference_register();

if ( ! function_exists( 'event_conference_setup' ) ) :

	function event_conference_setup() {

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		*/
		add_theme_support( 'post-formats', array('image','video','gallery','audio',) );

		load_theme_textdomain( 'event-conference', get_template_directory() . '/languages' );
		add_theme_support( 'woocommerce' );
		add_theme_support( "responsive-embeds" );
		add_theme_support( "align-wide" );
		add_theme_support( "wp-block-styles" );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
        add_image_size('event-conference-featured-header-image', 2000, 660, true);

        register_nav_menus( array(
            'primary' => esc_html__( 'Primary','event-conference' ),
	        'footer'=> esc_html__( 'Footer Menu','event-conference' ),
        ) );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		add_theme_support( 'custom-background', apply_filters( 'event_conference_custom_background_args', array(
			'default-color' => 'f7ebe5',
			'default-image' => '',
		) ) );

		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support( 'custom-logo', array(
			'height'      => 50,
			'width'       => 50,
			'flex-width'  => true,
		) );

		add_editor_style( array( '/editor-style.css' ) );
		add_action('wp_ajax_event_conference_dismissable_notice', 'event_conference_dismissable_notice');
	}
endif;
add_action( 'after_setup_theme', 'event_conference_setup' );


function event_conference_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'event_conference_content_width', 1170 );
}
add_action( 'after_setup_theme', 'event_conference_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function event_conference_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'event-conference' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'event-conference' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'event-conference' ),
		'id'            => 'event-conference-footer1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="footer-column-widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'event-conference' ),
		'id'            => 'event-conference-footer2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="footer-column-widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'event-conference' ),
		'id'            => 'event-conference-footer3',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="footer-column-widget-title">',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'event_conference_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function event_conference_scripts() {

	require_once get_theme_file_path( 'inc/wptt-webfont-loader.php' );

	wp_enqueue_style(
		'inter',
		wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap' ),
		array(),
		'1.0'
	);

	wp_enqueue_style( 'event-conference-block-editor-style', get_theme_file_uri('/assets/css/block-editor-style.css') );

	// load bootstrap css
    wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.css');

    wp_enqueue_style( 'owl.carousel-css', get_template_directory_uri() . '/assets/css/owl.carousel.css');

	wp_enqueue_style( 'event-conference-style', get_stylesheet_uri() );
	require get_parent_theme_file_path( '/custom-option.php' );
	wp_add_inline_style( 'event-conference-style',$event_conference_theme_css );

	// fontawesome
	wp_enqueue_style( 'fontawesome-style', get_template_directory_uri() .'/assets/css/fontawesome/css/all.css' );

    wp_enqueue_script('event-conference-theme-js', get_template_directory_uri() . '/assets/js/theme-script.js', array('jquery'), '', true );

    wp_enqueue_script('owl.carousel-js', get_template_directory_uri() . '/assets/js/owl.carousel.js', array('jquery'), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'event_conference_scripts' );

/**
 * Enqueue Preloader.
 */
function event_conference_preloader() {

  $event_conference_theme_color_css = '';
  $event_conference_preloader_bg_color = get_theme_mod('event_conference_preloader_bg_color');
  $event_conference_preloader_dot_1_color = get_theme_mod('event_conference_preloader_dot_1_color');
  $event_conference_preloader_dot_2_color = get_theme_mod('event_conference_preloader_dot_2_color');
  $event_conference_logo_max_height = get_theme_mod('event_conference_logo_max_height');

  	if(get_theme_mod('event_conference_logo_max_height') == '') {
		$event_conference_logo_max_height = '24';
	}

	if(get_theme_mod('event_conference_preloader_bg_color') == '') {
		$event_conference_preloader_bg_color = '#0F1330';
	}
	if(get_theme_mod('event_conference_preloader_dot_1_color') == '') {
		$event_conference_preloader_dot_1_color = '#AD00FF';
	}
	if(get_theme_mod('event_conference_preloader_dot_2_color') == '') {
		$event_conference_preloader_dot_2_color = '#FF8A00';
	}
	$event_conference_theme_color_css = '
		.custom-logo-link img{
			max-height: '.esc_attr($event_conference_logo_max_height).'px;
	 	}
		.loading{
			background-color: '.esc_attr($event_conference_preloader_bg_color).';
		 }
		 @keyframes loading {
		  0%,
		  100% {
		  	transform: translatey(-2.5rem);
		    background-color: '.esc_attr($event_conference_preloader_dot_1_color).';
		  }
		  50% {
		  	transform: translatey(2.5rem);
		    background-color: '.esc_attr($event_conference_preloader_dot_2_color).';
		  }
		}
	';
    wp_add_inline_style( 'event-conference-style',$event_conference_theme_color_css );

}
add_action( 'wp_enqueue_scripts', 'event_conference_preloader' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Meta Feild
 */
require get_stylesheet_directory() . '/inc/feature-meta.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

function event_conference_sanitize_dropdown_posts($input) {
    return sanitize_text_field($input);
}

function event_conference_sanitize_checkbox( $input ) {
  // Boolean check
  return ( ( isset( $input ) && true == $input ) ? true : false );
}

function event_conference_sanitize_select( $input, $setting ){
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/*radio button sanitization*/
function event_conference_sanitize_choices( $input, $setting ) {
    global $wp_customize;
    $control = $wp_customize->get_control( $setting->id );
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function event_conference_sanitize_number_absint( $number, $setting ) {
	// Ensure $number is an absolute integer (whole number, zero or greater).
	$number = absint( $number );

	// If the input is an absolute integer, return it; otherwise, return the default
	return ( $number ? $number : $setting->default );
}

function event_conference_sanitize_number_range( $number, $setting ) {
	
	// Ensure input is an absolute integer.
	$number = absint( $number );
	
	// Get the input attributes associated with the setting.
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;
	
	// Get minimum number in the range.
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
	
	// Get maximum number in the range.
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
	
	// Get step.
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
	
	// If the number is within the valid range, return it; otherwise, return the default
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'event_conference_loop_columns');
if (!function_exists('event_conference_loop_columns')) {
	function event_conference_loop_columns() {
		$columns = get_theme_mod( 'event_conference_products_per_row', 3 );
		return $columns; // 3 products per row
	}
}

function event_conference_get_all_posts() {
    $posts = get_posts(array('post_type' => 'post', 'numberposts' => -1));
    $post_choices = array();

    foreach ($posts as $post) {
        $post_choices[$post->ID] = $post->post_title;
    }

    return $post_choices;
}

/**
 * Get CSS
 */

function event_conference_getpage_css($hook) {
	wp_register_script( 'admin-notice-script', get_template_directory_uri() . '/inc/admin/js/admin-notice-script.js', array( 'jquery' ) );
    wp_localize_script('admin-notice-script','event_conference',
		array('admin_ajax'	=>	admin_url('admin-ajax.php'),'wpnonce'  =>	wp_create_nonce('event_conference_dismissed_notice_nonce')
		)
	);
	wp_enqueue_script('admin-notice-script');

    wp_localize_script( 'admin-notice-script', 'event_conference_ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
    );
	if ( 'appearance_page_event-conference-info' != $hook ) {
		return;
	}
	wp_enqueue_style( 'event-conference-demo-style', get_template_directory_uri() . '/assets/css/demo.css' );
}
add_action( 'admin_enqueue_scripts', 'event_conference_getpage_css' );

if ( ! defined( 'EVENT_CONFERENCE_CONTACT_SUPPORT' ) ) {
define('EVENT_CONFERENCE_CONTACT_SUPPORT',__('https://wordpress.org/support/theme/event-conference/','event-conference'));
}
if ( ! defined( 'EVENT_CONFERENCE_REVIEW' ) ) {
define('EVENT_CONFERENCE_REVIEW',__('https://wordpress.org/support/theme/event-conference/reviews/','event-conference'));
}
if ( ! defined( 'EVENT_CONFERENCE_LIVE_DEMO' ) ) {
define('EVENT_CONFERENCE_LIVE_DEMO',__('https://www.themagnifico.net/demo/event-conference/','event-conference'));
}
if ( ! defined( 'EVENT_CONFERENCE_GET_PREMIUM_PRO' ) ) {
define('EVENT_CONFERENCE_GET_PREMIUM_PRO',__('https://www.themagnifico.net/themes/event-wordpress-theme/','event-conference'));
}
if ( ! defined( 'EVENT_CONFERENCE_PRO_DOC' ) ) {
define('EVENT_CONFERENCE_PRO_DOC',__('https://www.themagnifico.net/eard/wathiqa/event-conference-pro-docs/','event-conference'));
}
if ( ! defined( 'EVENT_CONFERENCE_FREE_DOC' ) ) {
define('EVENT_CONFERENCE_FREE_DOC',__('https://www.themagnifico.net/eard/wathiqa/event-conference-free-doc/','event-conference'));
}

add_action('admin_menu', 'event_conference_themepage');
function event_conference_themepage(){

	$event_conference_theme_test = wp_get_theme();

	$event_conference_theme_info = add_theme_page( __('Theme Options','event-conference'), __(' Theme Options','event-conference'), 'manage_options', 'event-conference-info.php', 'event_conference_info_page' );
}

function event_conference_info_page() {
	$event_conference_theme_user = wp_get_current_user();
	$event_conference_theme = wp_get_theme();
	?>
	<div class="wrap about-wrap event-conference-add-css">
		<div>
			<h1>
				<?php esc_html_e('Welcome To ','event-conference'); ?><?php echo esc_html( $event_conference_theme ); ?>
			</h1>
			<div class="feature-section three-col">
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php esc_html_e("Contact Support", "event-conference"); ?></h3>
						<p><?php esc_html_e("Thank you for trying Event Conference , feel free to contact us for any support regarding our theme.", "event-conference"); ?></p>
						<p><a target="_blank" href="<?php echo esc_url( EVENT_CONFERENCE_CONTACT_SUPPORT ); ?>" class="button button-primary get">
							<?php esc_html_e("Contact Support", "event-conference"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php esc_html_e("Checkout Premium", "event-conference"); ?></h3>
						<p><?php esc_html_e("Our premium theme comes with extended features like demo content import , responsive layouts etc.", "event-conference"); ?></p>
						<p><a target="_blank" href="<?php echo esc_url( EVENT_CONFERENCE_GET_PREMIUM_PRO ); ?>" class="button button-primary get prem">
							<?php esc_html_e("Get Premium", "event-conference"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php esc_html_e("Review", "event-conference"); ?></h3>
						<p><?php esc_html_e("If You love Event Conference theme then we would appreciate your review about our theme.", "event-conference"); ?></p>
						<p><a target="_blank" href="<?php echo esc_url( EVENT_CONFERENCE_REVIEW ); ?>" class="button button-primary get">
							<?php esc_html_e("Review", "event-conference"); ?>
						</a></p>
					</div>
				</div>

				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php esc_html_e("Free Documentation", "event-conference"); ?></h3>
						<p><?php esc_html_e("Our guide is available if you require any help configuring and setting up the theme. Easy and quick way to setup the theme.", "event-conference"); ?></p>
						<p><a target="_blank" href="<?php echo esc_url( EVENT_CONFERENCE_FREE_DOC ); ?>" class="button button-primary get">
							<?php esc_html_e("Free Documentation", "event-conference"); ?>
						</a></p>
					</div>
				</div>
			</div>
		</div>
		<hr>

		<h2><?php esc_html_e("Free Vs Premium","event-conference"); ?></h2>
		<div class="event-conference-button-container">
			<a target="_blank" href="<?php echo esc_url( EVENT_CONFERENCE_PRO_DOC ); ?>" class="button button-primary get">
				<?php esc_html_e("Checkout Documentation", "event-conference"); ?>
			</a>
			<a target="_blank" href="<?php echo esc_url( EVENT_CONFERENCE_LIVE_DEMO ); ?>" class="button button-primary get">
				<?php esc_html_e("View Theme Demo", "event-conference"); ?>
			</a>
		</div>


		<table class="wp-list-table widefat">
			<thead class="table-book">
				<tr>
					<th><strong><?php esc_html_e("Theme Feature", "event-conference"); ?></strong></th>
					<th><strong><?php esc_html_e("Basic Version", "event-conference"); ?></strong></th>
					<th><strong><?php esc_html_e("Premium Version", "event-conference"); ?></strong></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><?php esc_html_e("Header Background Color", "event-conference"); ?></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Custom Navigation Logo Or Text", "event-conference"); ?></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Hide Logo Text", "event-conference"); ?></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>

				<tr>
					<td><?php esc_html_e("Premium Support", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Fully SEO Optimized", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Recent Posts Widget", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>

				<tr>
					<td><?php esc_html_e("Easy Google Fonts", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Pagespeed Plugin", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Only Show Header Image On Front Page", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Show Header Everywhere", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Custom Text On Header Image", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Full Width (Hide Sidebar)", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Only Show Upper Widgets On Front Page", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Replace Copyright Text", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Upper Widgets Colors", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Navigation Color", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Post/Page Color", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Blog Feed Color", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Footer Color", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Sidebar Color", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Background Color", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Importable Demo Content	", "event-conference"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
			</tbody>
		</table>
		<div class="event-conference-button-container">
			<a target="_blank" href="<?php echo esc_url( EVENT_CONFERENCE_GET_PREMIUM_PRO ); ?>" class="button button-primary get prem">
				<?php esc_html_e("Go Premium", "event-conference"); ?>
			</a>
		</div>
	</div>
	<?php
}

//Admin Notice For Getstart
function event_conference_ajax_notice_handler() {
    if ( isset( $_POST['type'] ) ) {
        $type = sanitize_text_field( wp_unslash( $_POST['type'] ) );
        update_option( 'dismissed-' . $type, TRUE );
    }
}

function event_conference_deprecated_hook_admin_notice() {

    $dismissed = get_user_meta(get_current_user_id(), 'event_conference_dismissable_notice', true);
    if ( !$dismissed) { ?>
        <div class="updated notice notice-success is-dismissible notice-get-started-class" data-notice="get_started" style="background: #f7f9f9; padding: 20px 10px; display: flex;">
	    	<div class="tm-admin-image">
	    		<img style="width: 100%;max-width: 320px;line-height: 40px;display: inline-block;vertical-align: top;border: 2px solid #ddd;border-radius: 4px;" src="<?php echo esc_url(get_stylesheet_directory_uri()) .'/screenshot.png'; ?>" />
	    	</div>
	    	<div class="tm-admin-content" style="padding-left: 30px; align-self: center">
	    		<h2 style="font-weight: 600;line-height: 1.3; margin: 0px;"><?php esc_html_e('Thank You For Choosing ', 'event-conference'); ?><?php echo wp_get_theme(); ?><h2>
	    		<p style="color: #3c434a; font-weight: 400; margin-bottom: 30px;"><?php _e('Get Started With Theme By Clicking On Getting Started.', 'event-conference'); ?><p>
	        	<a class="admin-notice-btn button button-primary button-hero" href="<?php echo esc_url( admin_url( 'themes.php?page=event-conference-info.php' )); ?>"><?php esc_html_e( 'Get started', 'event-conference' ) ?></a>
	        	<a class="admin-notice-btn button button-primary button-hero" target="_blank" href="<?php echo esc_url( EVENT_CONFERENCE_FREE_DOC ); ?>"><?php esc_html_e( 'Documentation', 'event-conference' ) ?></a>
	        	<span style="padding-top: 15px; display: inline-block; padding-left: 8px;">
	        	<span class="dashicons dashicons-admin-links"></span>
	        	<a class="admin-notice-btn"	 target="_blank" href="<?php echo esc_url( EVENT_CONFERENCE_LIVE_DEMO ); ?>"><?php esc_html_e( 'View Demo', 'event-conference' ) ?></a>
	        	</span>
	    	</div>
        </div>
    <?php }
}

add_action( 'admin_notices', 'event_conference_deprecated_hook_admin_notice' );

function event_conference_switch_theme() {
    delete_user_meta(get_current_user_id(), 'event_conference_dismissable_notice');
}
add_action('after_switch_theme', 'event_conference_switch_theme');
function event_conference_dismissable_notice() {
    update_user_meta(get_current_user_id(), 'event_conference_dismissable_notice', true);
    die();
}