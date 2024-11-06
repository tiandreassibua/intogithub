<header class="header-sidebar header-1 <?php if(get_theme_mod('header_layout','2')=='center'){echo "spnc-header-center";}?>" itemscope itemtype="http://schema.org/WPHeader">
	<?php get_template_part( 'partials/header/top-header' ); $newscrunch_sticky_header = get_theme_mod('hide_show_sticky_header',false);?>
	<nav class="spnc spnc-custom <?php if($newscrunch_sticky_header != false):?>header-sticky<?php endif; ?> trsprnt-menu " role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">	
		<div class="spnc-navbar">
			<div class="spnc-container">
				<?php do_action('newscrunch_header_logo');?>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<button class="spnc-menu-open spnc-toggle" type="button" aria-controls="menu"aria-expanded="false" onclick="openNav()" aria-label="<?php esc_attr_e('Menu','newscrunch'); ?>"><i class="fas fa-bars"></i></button>
				<div class="collapse spnc-collapse" id="spnc-menu-open">
					<a class="spnc-menu-close" onclick="closeNav()" href="#" title="<?php esc_attr_e('Close Off-Canvas','newscrunch'); ?>"><i class="fa-solid fa-xmark"></i></a>
					<?php do_action('newscrunch_header_logo');?>
					<div class="ml-auto">
						<?php
						$newscrunch_nav = '<ul class="nav spnc-nav spnc-right">%3$s';
						$newscrunch_nav .= '</ul>'; 
						$newscrunch_menu_class='';
						wp_nav_menu( array (
							'theme_location'	=>	'primary', 
							'menu_class'    	=>	'nav spnc-nav spnc-right '.$newscrunch_menu_class.'',
							'items_wrap'    	=>	$newscrunch_nav,
							'fallback_cb'   	=>	'newscrunch_fallback_page_menu',
							'walker'        	=>	new Newscrunch_Nav_Walker()
						));
						?>
					</div>
				</div>
				<!-- /.spnc-collapse -->

				<div class=spnc-head-wrap>
					<div class="spnc-header-right">		
						<?php if( get_theme_mod('hide_show_search_icon',true ) == true ):?>
						<ul class="nav spnc-nav">
							<li class="menu-item dropdown">
								<a href="#searchbar_fullscreen" class="search-icon" aria-haspopup="true" aria-expanded="false" title="<?php esc_attr_e('Search','newscrunch'); ?>"><i class="fas fa-search"></i></a>
							</li>
						</ul>
						<div id="searchbar_fullscreen">
							<button type="button" class="close" aria-label="<?php esc_attr_e('Close Search','newscrunch'); ?>">×</button>
							<form method="get" id="searchform" autocomplete="off" class="search-form" action="<?php echo esc_url( home_url( '/' )); ?>">
								<label>
									<input autofocus type="search" class="search-field" placeholder="<?php echo esc_attr__('Search','newscrunch'); ?>" value="" name="s" id="s" autofocus>
								</label>
								<input type="submit" class="search-submit btn" value="<?php echo esc_attr__('Search','newscrunch');?>">
							</form>
						</div>
						<?php endif; if( get_theme_mod('hide_show_dark_light_icon',true ) == true ):?>
						<div class="spnc-dark-layout">
							<a class="spnc-dark-icon" id="spnc-layout-icon" href="#" title="<?php esc_attr_e('Dark Light Layout','newscrunch'); ?>"><i class="fas fa-solid fa-moon"></i></a>
						</div>
						<?php endif; if( get_theme_mod('hide_show_toggle_icon',true ) == true ):?>
						<div class="spnc-widget-toggle">
							<a class="spnc-toggle-icon" onclick="spncOpenPanel()" href="#" title="<?php esc_attr_e('Toggle Icon','newscrunch'); ?>"><i class="fas fa-bars"></i></a>
						</div>
						<?php endif;?>
					</div>
				</div>
			</div>
			<div class="spnc-nav-menu-overlay"></div>
		</div>
	</nav>
</header>
<?php if( get_theme_mod('hide_show_toggle_icon',true ) == true ):?>		
<!-- Sidebar panel-->
<div id="spnc_panelSidebar" class="spnc_sidebar_panel">
	<a href="javascript:void(0)" class="spnc_closebtn" onclick="spncClosePanel()" title="<?php esc_attr_e('Close Icon','newscrunch'); ?>">×</a>
	<div class="spnc-right-sidebar">
		<div class="spnc-sidebar" id="spnc-sidebar-panel-fixed">
	    	<div class="right-sidebar">      
				<?php newscrunch_side_panel_widget_area( 'menu-widget-area' );?>       
			</div>
		</div>
	</div>
</div>
<!-- /Sidebar panel-->
<?php endif;?>