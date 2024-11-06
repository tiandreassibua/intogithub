<?php
/**
* Widget API: Single Column Widget Class
* @package Newscrunch
*/
class Newscrunch_Single_Column_Widget_Controller extends WP_Widget {

    //construct part
    function __construct()
    {
        parent::__construct(
        //Base ID of widget
        'newscrunch_single_column',

        //widget name will appear in UI
        esc_html__('Newscrunch : Single Column Sidebar','newscrunch'),

        // Widget description
        array( 'description' => esc_html__('Display your blog in a single-column layout.','newscrunch'))  
        );

    }

    //Widget Front End
    public function widget( $args, $instance ) {
        if ( ! isset( $args['widget_id'] ) ) { $args['widget_id'] = $this->id;}
        $title    = isset( $instance['title'] ) ? $instance['title'] : '';
        $category = isset( $instance['category'] ) ? $instance['category'] : '';
        if ( ! is_numeric($category) && !empty($category) ) {  $term = get_term_by('slug', $category, 'category'); $category = $term->term_id; }
        $number   = isset( $instance['number'] ) ? $instance['number'] : 4;
        $date     = isset( $instance['date'] ) ? $instance['date'] : '';
        $show_comments = isset( $instance['show_comments'] ) ? $instance['show_comments'] : '';
        if ( class_exists('Newscrunch_Plus') ): $show_read_time = isset( $instance['show_read_time'] ) ? $instance['show_read_time'] : ''; endif;
        $ctitle    = isset( $instance['ctitle'] ) ? $instance['ctitle'] : __('Comments','newscrunch');
        echo wp_kses_post($args['before_widget']);
        if ( $title ) { echo wp_kses_post($args['before_title']) . esc_html($title) . wp_kses_post($args['after_title']); } ?>
            <ul class="single-column">
                <?php
                global $post;
                $query_args = new WP_Query( apply_filters( 'widget_posts_args', array(
                    'no_found_rows'       => true,
                    'post_status'         => 'publish',
                    'cat'                 => $category,
                    'posts_per_page'      => $number,
                    'order'               => 'DESC',
                    'ignore_sticky_posts' => true
                ) ) );
                if ( $query_args->have_posts() ) { 
                    while ( $query_args->have_posts() ) {
                    $query_args->the_post();?>                        
                        <li>
                            <div class="wp-block-latest-posts__featured-image <?php echo esc_attr(get_theme_mod('img_animation','i_effect1'));?>">
                                <?php 
                                if ( has_post_thumbnail() ) { the_post_thumbnail( 'attachment-thumbnail size-thumbnail wp-post-image' ); }
                                else { ?>
                                    <img class="attachment-thumbnail size-thumbnail wp-post-image" src="<?php echo esc_url( NEWSCRUNCH_TEMPLATE_DIR_URI ); ?>/assets/images/no-preview.jpg" alt="<?php the_title_attribute(); ?>">
                                    <?php
                                } ?>
                            </div>
                            <div class="spnc-post-content">
                                <a class="<?php echo esc_attr(get_theme_mod('link_animate','a_effect1'));?>" href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a>
                                <div class="spnc-entry-meta">
                                    <?php if($date=='on') { ?>
                                        <span class="date"><?php echo newcrunch_post_date_time(get_the_ID(), 'no'); ?></span>
                                    <?php } 
                                    if($show_comments=='on') { ?>
                                        <span <?php if (is_rtl()) { echo 'dir="rtl"'; } ?> class="comment-links"><?php echo esc_html(get_comments_number()); echo' '; echo esc_html($ctitle);?></span>
                                    <?php } 
                                    if ( class_exists('Newscrunch_Plus') ):
                                        if(get_theme_mod('reading_time_enable',false) === true):
                                            if($show_read_time=='on'){ ?>
                                                <span class="spnc-read-time"> <?php spncp_reading_time();?></span>
                                    <?php } endif; endif;?>
                                </div>
                            </div>
                        </li>
                        <?php }
                    wp_reset_postdata();
                } ?>
            </ul>    
        <?php
        echo wp_kses_post($args['after_widget']);
    }

    //Widget Back End
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ])){ $title = $instance[ 'title' ]; } else { $title = esc_html__('Widget Title','newscrunch' ); }
        if ( isset( $instance[ 'category' ])){ $category = $instance[ 'category' ]; } else {  }
        if ( isset( $instance[ 'number' ])){ $number = $instance[ 'number' ]; } else { $number = 4; }
        if ( isset( $instance[ 'date' ])){ $date = $instance[ 'date' ]; } else {  }
        if ( isset( $instance[ 'show_comments' ])){ $show_comments = $instance[ 'show_comments' ]; } else {  }
        if ( class_exists('Newscrunch_Plus') ): 
            if ( isset( $instance[ 'show_read_time' ])){ $show_read_time = $instance[ 'show_read_time' ]; } else {  } 
            if ( isset( $instance[ 'ctitle' ])){ $ctitle = $instance[ 'ctitle' ]; } else { $ctitle = __('Comments','newscrunch' ); }
        endif;
        if ( ! is_numeric($category) ) { $category = get_term_by('slug', $category, 'category'); $category =$category->term_id; }
        ?>
            <!-- Heading -->
            <p class="newscrunch-widet-area">
                <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__( 'Widget Title','newscrunch' ); echo ':'; ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <!-- Category -->
            <p class="newscrunch-widet-area">
                <label for="<?php echo esc_attr($this->get_field_id( 'category' )); ?>"><?php echo esc_html__( 'Categories','newscrunch' ); echo ':'; ?></label>
                <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'category' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'category' )); ?>">
                    <option value=""><?php echo esc_html__( 'Select category', 'newscrunch' );?></option>
                    <?php  
                    $categories = get_categories(); 
                    foreach( $categories as $cat ): ?>
                    <option  value="<?php echo $cat->term_id;?>" <?php if($cat->term_id == $category) { echo 'selected'; } ?>><?php echo esc_html($cat->name). ' (' .esc_html($cat->count). ') ';?></option>
                    <?php endforeach;?>
                </select>
            </p>
             <!-- No of post -->
            <p class="newscrunch-widet-area">
                <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"> <?php echo esc_html__( 'Number of posts to show','newscrunch' ); echo ':'; ?> </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="number" value="<?php echo esc_attr( $number ); ?>" min="1" max="10" />
            </p>
             <!-- date -->
            <p class="newscrunch-widet-area" style="float: left; width: 100%;">
                <input <?php if($date=='on') { echo 'checked'; }?> class="widefat" id="<?php echo esc_attr($this->get_field_id( 'date' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'date' )); ?>" type="checkbox" />
                <label for="<?php echo esc_attr($this->get_field_id( 'date' )); ?>"> <?php echo esc_html__( 'Show post date','newscrunch' ); ?> </label>
            </p>
            <!-- Show Category -->
            <p class="newscrunch-widet-area" style="float: left; width: 100%;">
                <input <?php if($show_comments=='on') { echo 'checked'; }?> class="widefat" id="<?php echo esc_attr($this->get_field_id( 'show_comments' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_comments' )); ?>" type="checkbox"/>
                <label for="<?php echo esc_attr($this->get_field_id( 'show_comments' )); ?>"> <?php echo esc_html__( 'Show comments','newscrunch' ); ?> </label>
            </p>
            <!-- Show read time -->
            <?php if ( class_exists('Newscrunch_Plus') ): ?>
            <p class="newscrunch-widet-area" style="float: left; width: 100%;">
                <input <?php if($show_read_time=='on') { echo 'checked'; }?> class="widefat" id="<?php echo esc_attr($this->get_field_id( 'show_read_time' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_read_time' )); ?>" type="checkbox"/>
                <label for="<?php echo esc_attr($this->get_field_id( 'show_read_time' )); ?>"> <?php echo esc_html__( 'Show read time','newscrunch' ); ?> </label>
                <label style="color: #11b524;" > <?php echo esc_html__( 'If you want display post read time, then you should need to enable this setting from customizer ( Global >> Read Time )','newscrunch' ); ?> </label>
            </p>
             <!-- Comments -->
            <p class="newscrunch-widet-area">
                <label for="<?php echo esc_attr($this->get_field_id( 'ctitle' )); ?>"><?php echo esc_html__( 'Comments','newscrunch' ); echo ':'; ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'ctitle' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'ctitle' )); ?>" type="text" value="<?php echo esc_attr( $ctitle ); ?>" />
            </p>
           
        <?php
            endif;
    }

    //save or uption option
    public function update( $new_instance, $old_instance)
    {
      $instance = $old_instance;
      $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
      $instance['category'] = ( ! empty( $new_instance['category'] ) ) ? sanitize_text_field( $new_instance['category'] ) : '';
      $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? absint( $new_instance['number'] ) : '';
      $instance['date'] = ( ! empty( $new_instance['date'] ) ) ? newscrunch_sanitize_checkbox( $new_instance['date'] ) : '';
      $instance['show_comments'] = ( ! empty( $new_instance['show_comments'] ) ) ? newscrunch_sanitize_checkbox( $new_instance['show_comments'] ) : '';
      if ( class_exists('Newscrunch_Plus') ): 
        $instance['show_read_time'] = ( ! empty( $new_instance['show_read_time'] ) ) ? newscrunch_sanitize_checkbox( $new_instance['show_read_time'] ) : ''; 
        $instance['ctitle'] = ( ! empty( $new_instance['ctitle'] ) ) ? sanitize_text_field( $new_instance['ctitle'] ) : '';
    endif;
      return $instance;
    }

}