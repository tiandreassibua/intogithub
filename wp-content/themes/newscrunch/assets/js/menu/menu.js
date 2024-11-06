/* ---------------------------------------------- /*
 * Preloader
 /* ---------------------------------------------- */
(function(){

    jQuery(document).ready(function() {

        /* ---------------------------------------------- /*
         * Initialization General Scripts for all pages
         /* ---------------------------------------------- */

        var homeSection = jQuery('.home-section'),
            spnc      = jQuery('.spnc-custom'),
            navHeight   = spnc.height(),
           // worksgrid   = jQuery('#works-grid'),
            width       = Math.max(jQuery(window).width(), window.innerWidth),
            mobileTest  = false;

        if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            mobileTest = true;
        }

        buildHomeSection(homeSection);
        spncAnimation(spnc, homeSection, navHeight);
        spncSubmenu(width);
        spncSubmenuTouch(width)
        hoverDropdown(width, mobileTest);

        jQuery(window).resize(function() {
            var width = Math.max(jQuery(window).width(), window.innerWidth);
            buildHomeSection(homeSection);
            hoverDropdown(width, mobileTest);
        });

       /* ---------------------------------------------- /*
         * Home section height
         /* ---------------------------------------------- */

        function buildHomeSection(homeSection) {
            if (homeSection.length > 0) {
                if (homeSection.hasClass('home-full-height')) {
                    homeSection.height(jQuery(window).height());
                } else {
                    homeSection.height(jQuery(window).height() * 0.85);
                }
            }
        }


        /* ---------------------------------------------- /*
         * Transparent spnc animation
         /* ---------------------------------------------- */

        function spncAnimation(spnc, homeSection, navHeight) {
            var topScroll = jQuery(window).scrollTop();
            if (spnc.length > 0 && homeSection.length > 0) {
                if(topScroll >= navHeight) {
                    spnc.removeClass('spnc-transparent');
                } else {
                    spnc.addClass('spnc-transparent');
                }
            }
        }

        /* ---------------------------------------------- /*
         * spnc submenu
         /* ---------------------------------------------- */

        function spncSubmenu(width) {
            if (width > 1100) {
                 jQuery('.spnc-custom .spnc-nav > li.dropdown a').hover(function() {
                    var MenuLeftOffset  = jQuery(this).parent().offset().left+100;
                    var Menu1LevelWidth = jQuery('.dropdown-menu', jQuery(this).parent()).width();
                    if (width - MenuLeftOffset < Menu1LevelWidth * 2) {
                        jQuery(this).parent().children('.dropdown-menu').addClass('leftauto');
                    } else {
                        jQuery(this).parent().children('.dropdown-menu').removeClass('leftauto');
                    }
                    if (jQuery('.dropdown', jQuery(this).parent()).length > 0) {
                        var Menu2LevelWidth = jQuery('.dropdown-menu', jQuery(this).parent()).width();
                        if (width - MenuLeftOffset - Menu1LevelWidth < Menu2LevelWidth) {
                            jQuery(this).parent().children('.dropdown-menu').addClass('left-side');
                        } else {
                            jQuery(this).parent().children('.dropdown-menu').removeClass('left-side');
                        }
                    }
                });
                 jQuery('.spnc-custom .spnc-nav > li.dropdown a').focus(function() {
                    var MenuLeftOffsets  = jQuery(this).parent().offset().left+100;
                    var Menu1LevelWidth = jQuery('.dropdown-menu', jQuery(this).parent()).width();
                    if (width - MenuLeftOffsets < Menu1LevelWidth * 2) {
                        jQuery(this).parent().children('.dropdown-menu').addClass('leftauto');
                    } else {
                        jQuery(this).parent().children('.dropdown-menu').removeClass('leftauto');
                    }
                    if (jQuery('.dropdown', jQuery(this).parent()).length > 0) {
                        var Menu2LevelWidth = jQuery('.dropdown-menu', jQuery(this).parent()).width();
                        if (width - MenuLeftOffsets - Menu1LevelWidth < Menu2LevelWidth) {
                            jQuery(this).parent().children('.dropdown-menu').addClass('left-side');
                        } else {
                            jQuery(this).parent().children('.dropdown-menu').removeClass('left-side');
                        }
                    }
                });
            }
        }

          /* ---------------------------------------------- /*
         * spnc submenu click on firebox 
         /* ---------------------------------------------- */
         
        function spncSubmenuTouch(width) {
            if (width > 1100 && navigator.userAgent.toLowerCase().indexOf("firefox") > -1) {
               jQuery('li.dropdown').find('.fa-angle-down').each(function(){
                   jQuery(this).on('click', function(){
                    var thisVal=jQuery(this).parent().parent();
                   var MenuLeftOffsetss  =thisVal.offset().left; 
                    var Menu1LevelWidth = jQuery('.dropdown-menu', thisVal).width();
                    if (width - MenuLeftOffsetss < Menu1LevelWidth * 2) {
                       thisVal.children('.dropdown-menu').addClass('leftauto');
                    } else {
                        thisVal.children('.dropdown-menu').removeClass('leftauto');
                    }
                    if (jQuery('.dropdown', thisVal).length > 0) {
                        var Menu2LevelWidth = jQuery('.dropdown-menu', thisVal).width();
                        if (width - MenuLeftOffsetss - Menu1LevelWidth < Menu2LevelWidth) {
                            thisVal.children('.dropdown-menu').addClass('left-side');
                        } else {
                            thisVal.children('.dropdown-menu').removeClass('left-side');
                        }
                    }
                });
            });
        }}

        /* ---------------------------------------------- /*
         * spnc hover dropdown on desktop
         /* ---------------------------------------------- */

        function hoverDropdown(width, mobileTest) {
            if ((width > 1100) && (mobileTest !== true)) {
                jQuery('.spnc-custom').removeClass('open');
                var delay = 0;
                var setTimeoutConst;
                jQuery('.spnc-custom .spnc-nav > li.dropdown, .spnc-custom li.dropdown > ul > li.dropdown').hover(function() {
                        var jQuerythis = jQuery(this);
                        setTimeoutConst = setTimeout(function() {
                            jQuerythis.addClass('open');
                            jQuerythis.find('.dropdown-toggle').addClass('disabled');
                        }, delay);
                    },
                    function() {
                        clearTimeout(setTimeoutConst);
                        jQuery(this).removeClass('open');
                        jQuery(this).find('.dropdown-toggle').removeClass('disabled');
                    });
            } else {
                jQuery('.spnc-custom .spnc-nav > li.dropdown, .spnc-custom li.dropdown > ul > li.dropdown').unbind('mouseenter mouseleave');
                jQuery('.spnc-custom [data-toggle=dropdown]').not('.binded').addClass('binded').on('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    jQuery(this).parent().siblings().removeClass('open');
                    jQuery(this).parent().siblings().find('[data-toggle=dropdown]').parent().removeClass('open');
                    jQuery(this).parent().toggleClass('open');
                });
            }
        }

        /* ---------------------------------------------- /*
         * spnc collapse on click
         /* ---------------------------------------------- */
       
        /*jQuery('.spnc-toggle').on('click', function(){
              jQuery('.collapse.spnc-collapse').toggleClass('in');
        });
        jQuery('.spnc-toggle').on('click','.spnc-collapse.in',function(e) {
            if( jQuery(e.target).is('a') && jQuery(e.target).attr('class') != 'dropdown-toggle' ) {
                jQuery(this).collapse('hide');
            }
        });*/

        if( jQuery(window).width() > 1100) {
           jQuery('.nav li.dropdown').hover(function() {
             if( jQuery(window).width() > 1100 ) {
                jQuery('.dropdown-menu').removeAttr("style");
              }
               jQuery(this).addClass('open');

           }, function() {
               jQuery(this).removeClass('open');
           }); 
           jQuery('.nav li.dropdown-submenu').hover(function() {
               jQuery(this).addClass('open');
           }, function() {
               jQuery(this).removeClass('open');
           }); 
        }
        
         jQuery('li.dropdown').find('a').each(function (){
           var link = jQuery(this).attr('href');
              if (link==='' || link==="#") {
                jQuery(this).on('click', function(){
                if( jQuery(window).width() < 1100) {
                    jQuery('li.dropdown,li.dropdown-submenu').removeClass('open');
                    jQuery(this).next().slideToggle();
                }
                return false;
                }); 
              }
       });


        jQuery('li.dropdown').find('.fa-angle-down').each(function(){
            jQuery(this).on('click', function(){
              if(jQuery(window).width() > 1100 && window.matchMedia("(pointer: coarse)").matches && navigator.userAgent.toLowerCase().indexOf("firefox") > -1) {
                 jQuery(this).parent().parent().siblings().removeClass('open');
                jQuery(this).parent().parent().toggleClass('open');
              }
                return false;
            });
        
        });


        /* ---------------------------------------------- /*
         * Focus dropdown on desktop
        /* ---------------------------------------------- */
        const topLevelLinks = Array.prototype.slice.call(document.querySelectorAll(".spnc-custom .spnc-nav > li.dropdown a"), 0);
          topLevelLinks.forEach(function(link){
             return link.addEventListener('focus', function(e) {
                this.parentElement.classList.add('open')
                e.preventDefault();
               
                var div_list = e.target.parentElement.querySelectorAll( ".open" );
                var div_array = Array.prototype.slice.call(div_list);
                  div_array.forEach(function(e){
                   return e.classList.remove( "open" ) 
                });
              })             
        });
        jQuery('li a').focus(function() { 
              jQuery(this).parent().siblings().removeClass('open');
              jQuery(this).parent().siblings().find(".open").removeClass('open');
        });
     
        jQuery('a,input').bind('focus', function() {
            if(!jQuery(this).closest(".menu-item").length ) {
                topLevelLinks.forEach(function(link){
                    return link.parentElement.classList.remove('open')
                });
            }
        });
        jQuery('li.dropdown').find('.fa-angle-down').each(function(){
            jQuery(this).on('click', function(){
                if( jQuery(window).width() < 1100) {
                    jQuery('li.dropdown,li.dropdown-submenu').removeClass('open');
                    jQuery(this).parent().next().slideToggle();
                }
                return false;
            });
        });
        jQuery('a,input').bind('focus', function() {
            if(!jQuery(this).closest(".menu-item").length && ( jQuery(window).width() <= 1100) ) {
                jQuery('.spnc-collapse').removeClass('in');
            }
        });
    
    });
})(jQuery);