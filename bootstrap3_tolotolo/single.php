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

      
       <div class="page-header row1">
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
                    <div class="panel-body print">
                   		<div class="row">
                           <article class="post col-xs-12" id="<?php echo 'postid-'.get_post()->ID ?>">
                            <?php
                            if ( have_posts() ) :the_post();
                                $data = get_post( get_the_ID()); 
                            ?>
                            <header class="post-header row">
                                <h1 class="title"><?php echo $data->post_title;?></h1>
                                <div class="author  col-xs-4">作者: <span><?php the_author_posts_link();?></span></div>
                                <div class="time  col-xs-4"><span><?php the_time('Y-m-d');?> <?php  the_time('G:i'); ?></span></div>
                                <div class="views  col-xs-4"><span><?php if(function_exists('the_views')) {the_views();} ?> </span></div>
                            </header>
                           <?php 
                                    echo do_shortcode( apply_filters( 'the_content', $data->post_content) );
                            else :
                                    echo "sorry here is no thing!..";
                            endif; //endloopif 
                            ?>
                            </article>
                        </div>
                        <div class="last-line"></div>
                    </div><!-- pbody -->
                    <div class="panel-footer">

                        <div class="emoji_posts">
                          <?php mood_comment(); ?>
                        </div>
                        <div class="related_posts">
                              <h3>也许你还喜欢</h3>
                              <?php  post_related_list(6);?>

                        </div>

                          <?php 
                               if ( is_singular( 'attachment' ) ) {
                                              // Parent post navigation.
                                              // the_post_navigation( array(
                                              //     'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'twentysixteen' ),
                                              // ) );
                               } elseif ( is_singular( 'post' ) ) {
                                              // Previous/next post navigation.
                                              // If comments are open or we have at least one comment, load up the comment template.
                                         

                                          $post_navigation= get_the_post_navigation( array(
                                                  'next_text' => '<span class="meta-nav" aria-hidden="true">'.
                                                      '<span class="screen-reader-text">' . __( '下一篇') . '：</span> '.
                                                      '<span class="post-title">%title</span>'. __( '') . '</span> ',
                                                  'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( '' ) . '</span> ' .'<span class="screen-reader-text">' . __( '上一篇' ) . '：</span> ' .
                                                      '<span class="post-title">%title</span>',
                                                   'taxonomy'                   => __( 'post_tag' ),
                                                   'screen_reader_text' =>' ',
                                              ) );
                                            $post_navigation=  str_replace(
                                                    array("nav-links","nav-previous","nav-next",'<h2 class="screen-reader-text"> </h2>'),
                                                    array("nav-links row","nav-previous col-xs-12 col-md-4","nav-next col-xs-12 col-md-4 col-md-offset-4",""),
                                                     $post_navigation);
                                         echo  $post_navigation;
                                }
                          ?>
                        
                    </div>
                </div><!-- panel -->
                
                <!-- comment -->
                <div class="comment row">
                    
                    	
                         <?php 
                              if ( comments_open() || get_comments_number() ) {
                                       comments_template();
                              } 
                         ?> 
                              
          
                </div>
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