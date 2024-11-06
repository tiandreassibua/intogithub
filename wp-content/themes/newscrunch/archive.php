<?php
/**
 * The template for displaying archive pages
 *
 * @package Newscrunch
 */

get_header();

do_action( 'newscrunch_breadcrumbs_filter' );
newscrunch_highlight_views('inner');
if ('Newscrunch' == wp_get_theme() || 'Newscrunch Child' == wp_get_theme() || 'Newscrunch child' == wp_get_theme() ) {
    if(get_theme_mod('archive_blog_variation','grid')=='list') {
        get_template_part( 'template-parts/content-archive-first');
    }
    $newscrunch_blog=get_theme_mod('archive_blog_variation','grid');
}
else {
    if(get_theme_mod('archive_blog_variation','list')=='list') {
        get_template_part( 'template-parts/content-archive-first');
    }
    $newscrunch_blog= get_theme_mod('archive_blog_variation','list');
}

//Sidebar Selection
if ( class_exists('Newscrunch_Plus') )
{
    //Right Sidebar
    $newscrunch_page_sidebar = get_theme_mod('newscrunch_blog_archive_right_sidebar','sidebar-1');

    //Left Sidebar
    $newscrunch_left_sidebar = get_theme_mod('newscrunch_blog_archive_left_sidebar','left-sidebar');
}
else
{
    // Meta Right Sidebar
    $newscrunch_page_sidebar = get_post_meta(get_the_ID(),'newscrunch_page_sidebar', true );
    if($newscrunch_page_sidebar =='') { $newscrunch_page_sidebar ='sidebar-1';}

    // Meta Left Sidebar
    $newscrunch_left_sidebar = get_post_meta(get_the_ID(),'newscrunch_page_left_sidebar', true );
    if($newscrunch_left_sidebar =='') { $newscrunch_left_sidebar ='left-sidebar';}
}
if((get_theme_mod('ad_type','banner')=='banner')): do_action('newscrunch_before_post_arc_ads','before post archive'); endif;?>
<section class="page-section-space blog spnc-category-page spnc-blog-archive spnc-blog-clr front-<?php echo esc_attr($newscrunch_blog).' '; do_action( 'spncp_check_bread_hook' ); ?>" id="content">
    <div class="spnc-container">
        <?php
        if(get_theme_mod('bredcrumb_position','page_header')=='content_area'):
            echo '<div class="spnc-row"><div class="spnc-col-1">';
            do_action('newscrunch_breadcrumbs_page_title_hook');
            echo '</div></div>';
        endif;
        ?>
        <div class="spnc-row">
            <?php
            //sidebar
            if(get_theme_mod('blog_sidebar_layout','right')=='left' || get_theme_mod('blog_sidebar_layout','right')=='both'){ 
                echo '<div class="'.((get_theme_mod('blog_sidebar_layout','right')=='left')?'spnc-col-9 '.newscrunch_blog_stickysidebar().'':'spnc-col-10 '.newscrunch_blog_stickysidebar().'').' "><div itemscope itemtype="https://schema.org/WPSideBar" class="spnc-sidebar spnc-main-sidebar"><div class="left-sidebar">'; 

                    if ((!is_active_sidebar('left-sidebar')) && (get_theme_mod('blog_sidebar_layout','right')=='both')) {
                        newscrunch_sleft_widget_area( 'left-sidebar' );
                    }

                    dynamic_sidebar(((get_theme_mod('blog_sidebar_layout','right')=='left')?'"'.$newscrunch_page_sidebar.'"':'"'.$newscrunch_left_sidebar.'"'));
                    echo '</div></div></div>';
            }

            //Main content
            if(get_theme_mod('blog_sidebar_layout','right')=='right' || get_theme_mod('blog_sidebar_layout','right')=='left')
            {
                echo '<div class="spnc-col-7 spnc-sticky-content">';
            }
            else if(get_theme_mod('blog_sidebar_layout','right')=='both')
            {
                echo '<div class="spnc-col-8 spnc-sticky-content">';
            }
            else
            {
                echo '<div class="spnc-col-1">';
            }

            if (have_posts()):
                
                if(class_exists('Newscrunch_Plus'))
                {
                    $result = newscrunch_advertisement_area('random post archive');
                    if(!empty($result)):
                        if(count($result)==1)
                        {
                            $divisor=6;
                        }
                        else if(count($result)==2)
                        {
                            $divisor=4;
                        }
                        else
                        {
                            $divisor=3;
                        } 
                    endif;
                    if ('Newscrunch' == wp_get_theme() || 'Newscrunch Child' == wp_get_theme() || 'Newscrunch child' == wp_get_theme() )
                    {
                        if(get_theme_mod('archive_blog_variation','grid')=='grid')
                        {
                            $i=1;
                            echo '<div class="spnc-blog-cat-wrapper">';
                                while (have_posts()): the_post();
                                    if($i==1){
                                        get_template_part( 'template-parts/content-first');
                                    }else{
                                         get_template_part( 'template-parts/content');
                                    }
                                    // Insert a random advertisement
                                    if(!empty($result)):
                                        if ($i % $divisor == 0) {
                                            $random_ads = $result[array_rand($result)];
                                            echo '<div class="random-post-ads">';
                                            echo wp_kses_post(newscrunch_advertisement_content($random_ads));
                                            echo '</div>';
                                        }
                                    endif;
                                $i++;
                                endwhile;
                            echo'</div>';
                        }
                        else
                        {
                            $i=1;
                            echo '<div class="spnc-blog-section"><div class="spnc-post-list-view-section">';
                            while (have_posts()): the_post();
                            get_template_part( 'template-parts/content-list');
                            // Insert a random advertisement
                            if(!empty($result)):
                                if ($i % $divisor == 0) {
                                    $random_ads = $result[array_rand($result)];
                                    echo '<div class="random-post-ads">';
                                    echo wp_kses_post(newscrunch_advertisement_content($random_ads));
                                    echo '</div>';
                                }
                            endif;
                            $i++;
                            endwhile;
                            echo'</div></div>';
                        }
                    }
                    else
                    {
                        if(get_theme_mod('archive_blog_variation','list')=='list')
                        {
                            $i=1;
                            echo '<div class="spnc-blog-section"><div class="spnc-post-list-view-section">';
                            while (have_posts()): the_post();
                            get_template_part( 'template-parts/content-list');
                            // Insert a random advertisement
                            if(!empty($result)):
                                if ($i % $divisor == 0) {
                                    $random_ads = $result[array_rand($result)];
                                    echo '<div class="random-post-ads">';
                                    echo wp_kses_post(newscrunch_advertisement_content($random_ads));
                                    echo '</div>';
                                }
                            endif;
                            $i++;
                            endwhile;
                            echo'</div></div>';
                        }
                        else
                        {
                            $i=1;
                            echo '<div class="spnc-blog-cat-wrapper">';
                                while (have_posts()): the_post();
                                    if($i==1){
                                        get_template_part( 'template-parts/content-first');
                                    }else{
                                         get_template_part( 'template-parts/content');
                                    }
                                    // Insert a random advertisement
                                    if(!empty($result)):
                                        if ($i % $divisor == 0) {
                                            $random_ads = $result[array_rand($result)];
                                            echo '<div class="random-post-ads">';
                                            echo wp_kses_post(newscrunch_advertisement_content($random_ads));
                                            echo '</div>';
                                        }
                                    endif;
                                $i++;
                                endwhile;
                            echo'</div>';
                        }
                    }
                }

                else
                {
                    if ('NewsBlogger' == wp_get_theme()) {
                        if(get_theme_mod('archive_blog_variation','list')=='list')
                        {
                            $i=1;
                            echo '<div class="spnc-blog-section"><div class="spnc-post-list-view-section">';
                            while (have_posts()): the_post();
                            get_template_part( 'template-parts/content-list');
                            $i++;
                            endwhile;
                            echo'</div></div>';
                        }
                        else
                        {
                            $i=1;
                            echo '<div class="spnc-blog-cat-wrapper">';
                                while (have_posts()): the_post();
                                    if($i==1){
                                        get_template_part( 'template-parts/content-first');
                                    }else{
                                         get_template_part( 'template-parts/content');
                                    }
                                $i++;
                                endwhile;
                            echo'</div>';
                        }
                    }
                    else {
                        if(get_theme_mod('archive_blog_variation','grid')=='grid')
                        {
                            $i=1;
                            echo '<div class="spnc-blog-cat-wrapper">';
                            while (have_posts()): the_post();
                                if($i==1){
                                    get_template_part( 'template-parts/content-first');
                                }else{
                                     get_template_part( 'template-parts/content');
                                }
                            $i++;
                            endwhile;
                            echo'</div>';
                        }
                        else
                        {
                            $i=1;
                            echo '<div class="spnc-blog-section"><div class="spnc-post-list-view-section">';
                            while (have_posts()): the_post();
                                get_template_part( 'template-parts/content-list');
                            $i++;
                            endwhile;
                            echo'</div></div>';
                        }
                    }
                }
                 
            else:
                get_template_part('template-parts/content', 'none');
            endif;

            echo '<div class="clrfix"></div>';
            // pagination
            do_action('newscrunch_page_navigation'); ?>
            </div>
            <?php if(get_theme_mod('blog_sidebar_layout','right')=='right' || get_theme_mod('blog_sidebar_layout','right')=='both'):
                echo '<div class="'.((get_theme_mod('blog_sidebar_layout','right')=='right')?'spnc-col-9 '.newscrunch_blog_stickysidebar().'':'spnc-col-10 '.newscrunch_blog_stickysidebar().'').' "><div itemscope itemtype="https://schema.org/WPSideBar" class="spnc-sidebar spnc-main-sidebar"><div class="right-sidebar">';
                    dynamic_sidebar($newscrunch_page_sidebar);
                echo '</div></div></div>';
            endif;?>
        </div>
    </div>
</section>
<?php
get_footer();