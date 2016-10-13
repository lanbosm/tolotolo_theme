<?php global $dm_settings; ?>

<?php get_header(); ?>


<div class="wrap">
    
    <!-- nav bar start-->
    <?php 
        if ($dm_settings['show_header'] != 0){get_template_part('template-parts/content', 'navbar'); }
    ?>
    <!-- nav bar end-->

    <!-- start content container -->
    <div class="container">
        
          
         <div class="page-header  row1 ">
                <?php if ( display_header_text() ) : ?>   
                  <h1><a class="custom-header-text-color" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
                  <h4 class="custom-header-text-color"><?php bloginfo( 'description' ); ?></h4>
                <?php endif; ?>
         </div>
      
         
        <div class="row row2" >
            <!-- content start -->
            <div class="col-sm-<?php devdmbootstrap3_main_content_width(); ?>  col-lg-10" style="">
                <div class="panel panel-content panel-info row">
                    <div class="panel-heading colour">
                        <div class="row">
                                <?php  get_template_part('template-parts/content', 'panelhead');   ?>
                         </div>  
                    </div>
                    <div class="panel-body">
                        <div class="banner row">      
                               
                                 <?php if ( get_header_image() != '' ) : ?>           
                                  <a href="http://fgo.biligame.com/" target="blank"><img  class="img-responsive" src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt=""  />  </a>
                                <?php endif; ?>
                        </div>
                        <div class="posts row">
                            <?php
                            //if this was a search we display a page header with the results count. If there were no results we display the search form.
                            if (is_search()) :

                                 $total_results = $wp_query->found_posts;
                                 echo'<div class="col-xs-12"';
                                 echo"<h2 class='page-header'>" . sprintf( __('%s Search Results for "%s"','devdmbootstrap3'),  $total_results, get_search_query() ) . "</h2>";

                                 if ($total_results == 0) :
                                     get_search_form(true);
                                 endif;
                                  echo '</div>';
                                
                            endif;
                            if ( have_posts() ) : // list of posts   
                          ?><!-- article start -->
                            <?php 
                                while ( have_posts() ) : the_post();
                                   echo get_template_part('template-parts/content', 'article');    
                                endwhile;  
                            ?>
                            <!-- article end-->                     
                            <?php // If no content, include the "No posts found" template.
                            else :
                                echo "sorry here is no thing!..";
                            endif;//endloopif 
                            ?>
                        
                        </div>
                        <div class="last-line"></div>
                    </div><!-- pbody -->
                    <div class="panel-footer">
                        <?php  $pagenavi=wp_pagenavi(array("echo"=>false) );   //Previous/next page navigation    
                        //$str= preg_replace('/\n/', '', $pagenavi);
                        if($pagenavi!=""):?>

                        <div class="row">
                            <?php echo  $pagenavi ."\n"?>
                        </div> <!-- pagenavi -->
                        <?php endif; ?>
                    </div>
                </div><!-- panel -->
    
            
            </div>  
            <!-- content end -->
                
             <?php //get the right sidebar ?>
             <?php get_sidebar( 'right' ); ?>

             <?php //left sidebar ?>
             <?php get_sidebar( 'left' ); ?>    
        </div>
       
     
          
        
        <div class="row row3" style=" height: auto; display:none;">
                
                <div class="jumbotron">
                  <h1>join, us!</h1>
                  <p>tolotolo 是个喜欢石头门的组织</p>
                  <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
                </div>
        </div>
</div>
<!-- end content container -->


<?php get_footer(); ?>