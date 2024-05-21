<?php
/**
 * Template Name: Home Template
 */

get_header(); ?>

<main id="skip-content">
  <section id="top-slider" class="pt-4">
    <div class="row m-0">
      <div class="col-lg-2 col-md-12 col-sm-12 col-12 p-0">
        <div class="row contact">
          <?php if ( get_theme_mod('event_conference_topbar_email_text') != "" || get_theme_mod('event_conference_topbar_email_id') != "" ) {?>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
              <div class="contct-box">
                <div class="contct-icon email">
                  <i class="fas fa-envelope"></i>
                </div>
                <div class="contct-content">
                  <h6 class="m-0"><?php echo esc_html(get_theme_mod('event_conference_topbar_email_text')); ?></h6>
                  <p class="m-0"><a href="mailto:<?php echo esc_url(get_theme_mod('event_conference_topbar_email_id')); ?>"><?php echo esc_html(get_theme_mod('event_conference_topbar_email_id')); ?></a></p>
                </div>
              </div>
              </p>
            </div>
          <?php }?>
          <?php if ( get_theme_mod('event_conference_topbar_phone_text') != "" || get_theme_mod('event_conference_topbar_phone_number') != "" ) {?>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
              <div class=" contct-box">
                <div class="contct-icon ">
                  <i class="fas fa-phone"></i>
                </div>
                <div class="contct-content">
                  <h6 class="m-0"><?php echo esc_html(get_theme_mod('event_conference_topbar_phone_text')); ?></h6>
                  <p class="m-0"><a href="tel:<?php echo esc_attr(get_theme_mod('event_conference_topbar_phone_number')); ?>"><?php echo esc_html(get_theme_mod('event_conference_topbar_phone_number')); ?></a></p>
                </div>
              </div>
            </div>
          <?php }?>
        </div>
      </div>
      <div class="col-lg-8 col-md-12 col-sm-12 col-12 box-slider">
        <?php
        $event_conference_slide_posts = array();
        for ($event_conference_count = 1; $event_conference_count <= 3; $event_conference_count++) {
            $event_conference_mod = intval(get_theme_mod('event_conference_top_slider_post' . $event_conference_count));

            if ($event_conference_mod != 0) {
                $event_conference_slide_posts[] = $event_conference_mod;
            }
        }
        if (!empty($event_conference_slide_posts)) :
            $event_conference_args = array(
                'post_type' => 'post',
                'post__in' => $event_conference_slide_posts,
                'orderby' => 'post__in'
            );

            $event_conference_query = new WP_Query($event_conference_args);

            if ($event_conference_query->have_posts()) :
                $i = 1;
        ?>
          <div class="owl-carousel" role="listbox">
              <?php while ($event_conference_query->have_posts()) : $event_conference_query->the_post(); ?>
                  <div class="slider-box">
                    <div class="slider-inner-box">
                      <div class="row mb-3">
                        <div class="col-lg-6 align-self-center">
                          <span class="slide-date"><?php echo esc_html( get_the_date('j F Y') ); ?></span>
                          <h2 class="m-0"><?php the_title(); ?></h2>
                        </div>
                        <div class="col-lg-6 align-self-center">
                          <p class="content mt-3"><?php echo esc_html(wp_trim_words(get_the_content(), 30)); ?></p>
                        </div>
                      </div>
                    </div>
                    <div class="slide-image">
                      <?php if(has_post_thumbnail()){
                        the_post_thumbnail();
                        } else{?>
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/slider.png" alt="" />
                      <?php } ?>
                        <?php if (has_post_thumbnail()) { ?><img src="<?php the_post_thumbnail_url('full'); ?>" /><?php } else { ?><div class="slide-bg"></div> <?php } ?>
                    </div>
                  </div>
              <?php $i++;
              endwhile;
              wp_reset_postdata(); ?>
          </div>
          <?php else : ?>
            <div class="no-postfound"></div>
        <?php
            endif;
        endif;
        ?>
      </div>
      <div class="col-lg-2 col-md-12 col-sm-12 col-12 text-right social-box">
        <div class="social-link">
          <?php if(get_theme_mod('event_conference_facebook_url') != ''){ ?>
            <a href="<?php echo esc_url(get_theme_mod('event_conference_facebook_url','')); ?>"><i class="<?php echo esc_attr( get_theme_mod('event_conference_facebook_icon') ); ?>"></i></a>
          <?php }?>
          <?php if(get_theme_mod('event_conference_twitter_url') != ''){ ?>
            <a href="<?php echo esc_url(get_theme_mod('event_conference_twitter_url','')); ?>"><i class="<?php echo esc_attr( get_theme_mod('event_conference_twitter_icon') ); ?>"></i></a>
          <?php }?>
          <?php if(get_theme_mod('event_conference_intagram_url') != ''){ ?>
            <a href="<?php echo esc_url(get_theme_mod('event_conference_intagram_url','')); ?>"><i class="<?php echo esc_attr( get_theme_mod('event_conference_intagram_icon') ); ?>"></i></a>
          <?php }?>
          <?php if(get_theme_mod('event_conference_linkedin_url') != ''){ ?>
            <a href="<?php echo esc_url(get_theme_mod('event_conference_linkedin_url','')); ?>"><i class="<?php echo esc_attr( get_theme_mod('event_conference_linkedin_icon') ); ?>"></i></a>
          <?php }?>
          <?php if(get_theme_mod('event_conference_pintrest_url') != ''){ ?>
            <a href="<?php echo esc_url(get_theme_mod('event_conference_pintrest_url','')); ?>"><i class="<?php echo esc_attr( get_theme_mod('event_conference_pintrest_icon') ); ?>"></i></a>
          <?php }?>
          <?php if(get_theme_mod('event_conference_facebook_url') != '' || get_theme_mod('event_conference_twitter_url') != '' || get_theme_mod('event_conference_intagram_url') != '' ||get_theme_mod('event_conference_linkedin_url') != '' || get_theme_mod('event_conference_pintrest_url') != '' ){ ?>
            <div class="social-heading">
              <h6 class="m-0"><?php esc_html_e('Connect with Us','event-conference'); ?></h6>
            </div>
          <?php }?>
        </div>
      </div>
    </div>
    
  </section>

  <section class="featured">
    <div class="container">
      <?php if(get_theme_mod('event_conference_services_sec_category','')){ ?>
        <div class="box-ser">
          <div class="ser-heading text-center">
            <?php if(get_theme_mod('event_conference_services_title') != ''){ ?>
              <h3 class="main-heading text-center"><?php echo esc_html(get_theme_mod('event_conference_services_title')); ?></h3>
            <?php }?>
            <?php if(get_theme_mod('event_conference_services_heading') != ''){ ?>
              <h4 class="main-heading text-center"><?php echo esc_html(get_theme_mod('event_conference_services_heading')); ?></h4>
            <?php }?>
          </div>
          <div class="row m-0 pt-4 px-3">
            <?php
              $event_conference_services_cat = get_theme_mod('event_conference_services_sec_category','');
              if($event_conference_services_cat){
                $event_conference_page_query5 = new WP_Query(array( 'category_name' => esc_html($event_conference_services_cat,'event-conference'),'posts_per_page' => 4));
                $i=1;
                while( $event_conference_page_query5->have_posts() ) : $event_conference_page_query5->the_post(); ?>
                  <div class="col-lg-3 col-md-4 col-sm-12 col-12">
                    <div class="feature-box mb-3">
                      <div class="featured-img text-center">
                        <img src="<?php the_post_thumbnail_url('full'); ?>" class="w-100"/>
                      </div>
                      <div class=" ser-content text-center">
                        <h4 class="mb-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <?php if(get_theme_mod('event_conference_services_designation') != ''){ ?>
                          <span class="designation text-center"><?php echo esc_html(get_theme_mod('event_conference_services_designation')); ?></span>
                        <?php }?>
                        <?php if( get_post_meta($post->ID, 'event_conference_text_1', true) ) {?>
                         <p class="text p-0 mb-4"><?php echo esc_html(get_post_meta($post->ID,'event_conference_text_1',true)); ?></p>
                        <?php }?>
                        <p><?php echo esc_html( wp_trim_words( get_the_content(), 15 )); ?></p>
                      </div>
                    </div>
                  </div>
                <?php $i++; endwhile;
              wp_reset_postdata();
            } ?>
          </div>
        </div>
      <?php }?>
    </div>
  </section>

  <section id="page-content">
    <div class="container">
      <div class="py-5">
        <?php
          if ( have_posts() ) :
            while ( have_posts() ) : the_post();
              the_content();
            endwhile;
          endif;
        ?>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>