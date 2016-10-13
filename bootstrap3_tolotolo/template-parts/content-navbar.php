<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" >
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
             <?php
               $menu_bar= wp_nav_menu( array(
                    'theme_location'  => 'main_menu',
                    'container'       => 'div',
                    'container_class' => 'collapse navbar-collapse',
                    'container_id'    => 'navbar-collapse-1',
                    'menu_class'      => 'nav navbar-nav',
                    'menu_id'         => 'navbar-nav',
                    'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
                    'depth'           => 0,
                    'walker'          => new wp_bootstrap_navwalker(),
                    'echo'     =>false
                 ) );
               $menu_bar = str_replace("</div>","",$menu_bar);
               $domain=home_url();
               $login_btn="登录";
               $login_href=wp_login_url( home_url(add_query_arg(array(),$wp->request)));

               if(is_user_logged_in()){
                     $login_btn="注销";
                     $login_href=wp_logout_url( $domain );;
               }
               $search_bar='<form class="navbar-form navbar-right" role="search"  method="get" id="searchform" action="'. $domain.'">';
               $search_bar.='<div class="form-group"><label class="label visible-xs-inline-block" for="s">搜索：</label>
                      <input type="text" value="" name="s" id="s"  class="form-control" placeholder="想找点什么?"></div>';
               $search_bar.=' <button type="submit " id="searchsubmit" class="btn btn-default hidden-xs">搜索</button>';
               $search_bar.='<div class="form-group visible-xs"><label class="label visible-xs-inline-block" for="l">登录：</label>
                      <a href="'. $login_href.'" id="l" class="btn btn-default btn-block">'.$login_btn.'</a></div>';
               $search_bar.=' <a href="'. $login_href.'" class="btn btn-default hidden-xs">'.$login_btn.'</a>';
               $search_bar.='</form></div>'."\n";
        
               $nav_bar=$menu_bar.$search_bar;
               echo  $nav_bar;
              ?>
         </div>
    </nav>
