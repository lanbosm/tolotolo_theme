<?php global $dm_settings;
   $classes = array(
                                            'col-xs-12',
                                            'col-lg-6',
                                       
                                        );


//thumbnail
$thumbnail=get_current_thumbnail($post,"img-responsive");

$title=$post->post_title;

                                     
//desc
$desc=get_the_excerpt();

//cat
$cat_output="";
$cats=get_the_category();
if ($cats) {
    foreach ( $cats as $cat ) {
   // $sss=$cat[0]->cat_name;
    $cat_output.='<a class="label cat-'.$cat->category_nicename.'" href="'. esc_url( get_category_link( $cat->term_id )) . '"rel="category">'.$cat->cat_name.'</a>';
    }
}

                                                           
//tag
$tag_output="";
$tags = get_the_tags();
if ($tags) {
  foreach($tags as $tag) {
   // $tag_link = get_tag_link( $tag->term_id );
    $tag_output.= '<a class="label tag-'.$tag->name.'" href="'.esc_url( get_tag_link( $tag->term_id )).'"  />' . $tag->name . '</a>'; 
  }
}



?>

<?php if ($dm_settings['show_postmeta'] != 0) :?>                           
                              <article class="post col-xs-12 col-lg-6">
                                    <div class="row">
                                         <figure class="figure col-lg-6 col-xs-4">
                                                <div class="thumbnail"><a href="<?php the_permalink(); ?>"><?php echo $thumbnail?></a></div>
                                         </figure> 
                                         <div class="col-xs-8 col-lg-none">
                                         <div class="info col-lg-6 ">

                                                <h2> <a href="<?php the_permalink(); ?>" title="<?php  the_title_attribute() ?>" rel="bookmark"><?php echo $title; ?></a></h2>
                                                <p><?php  ?></p>
                                                <p><span class="glyphicon glyphicon-edit"></span> <?php the_time('F jS, Y');?> by <span class="author"> <?php the_author_posts_link(); ?></span></p>  
                                                <?php if(current_user_can( 'manage_options' )):?><p><span class="glyphicon glyphicon glyphicon-cog"></span> <?php edit_post_link(__('Edit','devdmbootstrap3'));endif ?></p>
                                                <p><span class="glyphicon glyphicon glyphicon-book"></span> 分类: <?php echo $cat_output; ?></p>
                                                <p><span class="glyphicon glyphicon-tags"></span> 标签: <?php echo $tag_output;?></p>
                                                <p><span class="glyphicon glyphicon glyphicon-heart"></span> <span class="show-view"><?php if(function_exists('the_views')) {the_views();} ?> </span>
                                                </p>
       
                                        </div>
                                        <div class="info col-lg-12">
                                                    <p class="desc"><?php echo  $desc; ?></p>
                                        </div>
                                        </div>
                                    </div>
                              </article>
<?php endif; ?>