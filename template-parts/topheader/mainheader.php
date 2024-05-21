<?php
/**
 * Displays main header
 *
 * @package Event Conference
 */
?>

<div class="main-header text-center text-md-start">
    <div class="row nav-box">
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 align-self-center">
            <div class="navbar-brand text-center text-md-start">
                <?php if ( has_custom_logo() ) : ?>
                    <div class="site-logo"><?php the_custom_logo(); ?></div>
                <?php endif; ?>
                <?php $event_conference_blog_info = get_bloginfo( 'name' ); ?>
                    <?php if ( ! empty( $event_conference_blog_info ) ) : ?>
                        <?php if ( is_front_page() && is_home() ) : ?>
                        <?php if( get_theme_mod('event_conference_logo_title_text',true) != ''){ ?>
                            <h1 class="site-title pt-2"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                        <?php } ?>
                        <?php else : ?>
                            <?php if( get_theme_mod('event_conference_logo_title_text',true) != ''){ ?>
                                <p class="site-title "><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                            <?php } ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php
                        $event_conference_description = get_bloginfo( 'description', 'display' );
                        if ( $event_conference_description || is_customize_preview() ) :
                    ?>
                    <?php if( get_theme_mod('event_conference_theme_description',false) != ''){ ?>
                        <p class="site-description pb-2"><?php echo esc_html($event_conference_description); ?></p>
                    <?php } ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-6 col-md-3 col-sm-4 col-3 align-self-center">
            <?php get_template_part('template-parts/navigation/nav'); ?>
        </div>
        <div class="col-lg-3 col-md-5 col-sm-6 col-9 align-self-center text-end">
            <?php if ( get_theme_mod('event_conference_header_button') != "" || get_theme_mod('event_conference_header_button_url') != ""  ) {?>
                <span class="head-btn"><a href="<?php echo esc_url(get_theme_mod('event_conference_header_button_url')); ?>"><?php echo esc_html(get_theme_mod('event_conference_header_button')); ?></a></span>
            <?php }?>
        </div>
    </div>
</div>
