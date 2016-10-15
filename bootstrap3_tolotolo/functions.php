<?php

/**
*  Theme Information
*/

    $themename = "DevDmBootstrap3";
    $developer_uri = "http://devdm.com";
    $shortname = "dm";
    $version = '1.80';
    load_theme_textdomain( 'devdmbootstrap3', get_template_directory() . '/languages' );

/**
* include Theme-options.php for Admin Theme settings
*/

   include 'theme-options.php';


//找回上传设置
if(get_option('upload_path')=='wp-content/uploads' || get_option('upload_path')==null) {
    update_option('upload_path',WP_CONTENT_DIR.'/uploads');
}


//Editor Style
add_editor_style('css/editor-style.css');
//Editor font
function custum_fontfamily($initArray){
   $initArray['font_formats'] = "微软雅黑='微软雅黑';宋体='宋体';黑体='黑体';仿宋='仿宋';楷体='楷体';隶书='隶书';幼圆='幼圆';Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings";
   return $initArray;
}

add_filter('tiny_mce_before_init', 'custum_fontfamily');
function customize_text_sizes($initArray){
  $initArray['fontsize_formats'] = "10px 12px 14px 16px 18px 24px 36px 48px 72px 12pt 1em";
   return $initArray;
}
add_filter('tiny_mce_before_init', 'customize_text_sizes');

function enable_more_buttons($buttons) {
    $buttons[] = 'styleselect';
    $buttons[] = 'fontselect';
    return $buttons;
}
add_filter("mce_buttons", "enable_more_buttons");

// 替换 WordPress 默认 Emoji 资源地址
function c7sky_change_wp_emoji_baseurl($url){
    return set_url_scheme('//twemoji.maxcdn.com/72x72/');
}
add_filter('emoji_url', 'c7sky_change_wp_emoji_baseurl');

//添加编辑器快捷按钮
add_action('admin_print_scripts', 'my_quicktags');
function my_quicktags() {
    wp_enqueue_script(
        'my_quicktags',
       get_stylesheet_directory_uri().'/js/my_quicktags.js',
       array('quicktags')
   );
};


/**
* Register Bootstrap JS with jquery
*/
   
 
/**
* Add Title Tag Support with Regular Title Tag injection Fall back.
  notice: seo plugins over this!
*/

function devdmbootstrap3_title_tag() {
    add_theme_support( 'title-tag' );
}

add_action( 'after_setup_theme', 'devdmbootstrap3_title_tag' );


if(!function_exists( '_wp_render_title_tag')) {

    function devdmbootstrap3_render_title() {
        ?>
        <title><?php wp_title( '-', true, 'right' ); ?></title>
    <?php
    }
    add_action( 'wp_head', 'devdmbootstrap3_render_title' );

}


/**
* Register Custom Navigation Walker include custom menu widget to use walkerclass
*/

    require_once('lib/wp_bootstrap_navwalker.php');
    require_once('lib/bootstrap-custom-menu-widget.php');

/**
* Register Menus
*/

        register_nav_menus(
            array(
                'main_menu' => 'Main Menu',
                'footer_menu' => 'Footer Menu'
            )
        );

/**
* Register the Sidebar(s)
*/

        register_sidebar(
            array(
            'name' => 'Right Sidebar',
            'id' => 'right-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));

        register_sidebar(
            array(
            'name' => 'Left Sidebar',
            'id' => 'left-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));


        register_sidebar(
            array(
            'name' => 'Footer Sidebar',
            'id' => 'footer-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));

/**
* Register hook and action to set Main content area col-md- width based on sidebar declarations
*/

add_action( 'devdmbootstrap3_main_content_width_hook', 'devdmbootstrap3_main_content_width_columns');

function devdmbootstrap3_main_content_width_columns () {

    global $dm_settings;

    $columns = '12';

    if ($dm_settings['right_sidebar'] != 0) {
        $columns = $columns - $dm_settings['right_sidebar_width'];
    }

    if ($dm_settings['left_sidebar'] != 0) {
        $columns = $columns - $dm_settings['left_sidebar_width'];
    }



    echo $columns;
}


function rename_upload_file_prefilter($file){
 //$time=date("Y-m-d");
    $time=date("YmdHis");
    if(preg_match ("/image/i", $file['type']) ){ //image
        if(!ctype_alnum(pathinfo($file['name'] , PATHINFO_FILENAME))){
      
             $file['name'] = $time."".mt_rand(1,100).".".pathinfo($file['name'] , PATHINFO_EXTENSION);
        }
    }
    return $file;
 }
 add_filter('wp_handle_upload_prefilter', 'rename_upload_file_prefilter');


function tolotolo_bootstrap_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>

    <li class="media" id="li-comment-<?php comment_ID() ?>" >
        <div id="comment-<?php comment_ID(); ?>">
            <div class="comment-author vcard media-left">
                 <?php echo get_avatar($comment,$size='48',$default='',$alt='gravatar',array('size'=> 32,'class'=>"media-object img-circle") ); ?>
            </div>
            <?php if ($comment->comment_approved == '0') : ?>
                 <em><?php _e('Your comment is awaiting moderation.') ?></em>
            <br />
            <?php endif; ?>
            <div class="comment-meta commentmetadata media-body">
                    <b class="media-heading"><?php _e(get_comment_author_link()) ?> <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),' ','') ?></b>
                        <?php comment_text() ?>
                    <buttom class="reply btn btn-info btn-xs colour">
                        <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                    </buttom>
            </div>

        </div>
    </li>
        <?php
}

function devdmbootstrap3_main_content_width() {
    do_action('devdmbootstrap3_main_content_width_hook');
}

/**
* Add support for a featured image and the size
*/



add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size(200,200, true);

/**
* Adds RSS feed links to for posts and comments.
*/

add_theme_support( 'automatic-feed-links' );

/**
*Set Content Width
*/

if ( ! isset( $content_width ) ) $content_width = 980;


/*
   * Switch default core markup for search form, comment form, and comments
   * to output valid HTML5.
   */
 
function prefix_setup() {
    add_theme_support( 'html5',  array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
    ) );
}
add_action( 'after_setup_theme', 'prefix_setup' );

  /*
   * Enable support for Post Formats.
   *
   * See: https://codex.wordpress.org/Post_Formats
   */
  add_theme_support( 'post-formats', array(
    'aside',
    'image',
    'video',
    'quote',
    'link',
    'gallery',
    'status',
    'audio',
    'chat',
  ) );
/**
 * add link manager function
 */
add_filter( 'pre_option_link_manager_enabled', '__return_true' );


/**
 * control per page article count  show
 */

function control_page_article_count_show($query){
    $is_home = $query->get('is_home');
    if($is_home){
            //$t=$query->get('posts_per_page');;
            //$query->set('posts_per_page',$t);

    }
    if(empty($is_home)){
            if(is_category()){
               $query->set('posts_per_page',3);

            }
            if(is_tag()){
                $query->set('posts_per_page',13);
            }
    }
}
add_action('pre_get_posts','control_page_article_count_show');

/**
 * show admin bar
*/
//if ( !current_user_can( 'manage_options' ) ) {  
    
     remove_action( 'init', '_wp_admin_bar_init' );  
     add_filter('show_admin_bar', '__return_false');
// }



/**
 *  loadScriptsAndCss
*/

function loadScriptsAndCss() {  

  $domain="localtolotolo";
    // wp_deregister_style( 'open-sans' );   //注销谷歌字体
    // wp_register_style( 'open-sans', '//'.$domain.'/source/css/googleFont.css?family=Open+Sans:300italic,400italic,600italic,300,400,600&subset=$subsets',array(),'1' );  
  if ( !is_admin() ) { /** Load Scripts and Style on Website Only */  
         wp_deregister_script( 'jquery' );      //注销原先的jquery
        
          
        
         wp_register_script( 'jquery','//cdn.bootcss.com/jquery/1.11.3/jquery.min.js',array(), '1.11.3',true);  
        wp_register_script( 'jquery-lazy','//cdn.bootcss.com/jquery_lazyload/1.9.7/jquery.lazyload.min.js',array(), '1.9.7',true);  
         wp_register_script( 'bootstrap','//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js', array(), '3.3.5',true ); 
        /// wp_register_script( 'jssdk','//res.wx.qq.com/open/js/jweixin-1.0.0.js', array(), '1',true );
        // wp_register_script( 'wechat', "//www.tolotolo.cn/source/js/weChatShare.js",array(), '1', 'all' ); 
         wp_register_style( 'bootstrap', "//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css",array(), '3.3.5', 'all' ); 
        
          
         
         //out put css
         wp_enqueue_script( 'jquery' );  
         wp_enqueue_script( 'jquery-lazy' );  
         wp_enqueue_script( 'bootstrap');
        // wp_enqueue_script( 'jssdk');
         //wp_enqueue_script( 'wechat');

         wp_enqueue_style( 'bootstrap');
        // wp_enqueue_style('open-sans');   
         wp_enqueue_style( 'style', get_stylesheet_uri(), array(), '1.0', 'all' );
    }  
}  

add_action( 'init', 'loadScriptsAndCss' );


 //图片延迟加载
function lazyload($content) {
    $loadimg_url=get_bloginfo('template_directory').'/static/images/img_loading.gif';
    if(!is_feed()||!is_robots) {
        $content=preg_replace('/<img(.+)src=[\'"]([^\'"]+)[\'"](.*)>/i',"<img\$1data-original=\"\$2\" src=\"$loadimg_url\"\$3>\n<noscript>\$0</noscript>",$content);
    }
    return $content;
}

add_filter ('the_content', 'lazyload');


/**
 *  header_diy
*/
function header_diy() {
        ?>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no" />
     <?php
        echo "<!--页面设计：lanbo | 页面制作: lanbo | 个人博客：http://www.cgblogs.com/lanbosm -->\n";
        echo "\n";
}
add_action( 'wp_head', 'header_diy',6 );

function footer_diy() {
     ?>   

          <script type='text/javascript'>
           $(document).ready(function(){

              $("img").lazyload({ 

              	  threshold : 200
              

              });
              
            });
           var meta = document.getElementsByTagName('meta');
            var share_desc = '';
            for(i in meta){
             if(typeof meta[i].name!="undefined"&&meta[i].name.toLowerCase()=="description"){
              share_desc = meta[i].content;
             }
            }

           
          
      </script>


<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/static/js/weChatShare.js"></script>
<script type="text/javascript">

            var meta = document.getElementsByTagName('meta');
            var share_desc = '';
            for(i in meta){
             if(typeof meta[i].name!="undefined"&&meta[i].name.toLowerCase()=="description"){
              share_desc = meta[i].content;
             }
            }

           weChatShare({
            shareTitle:document.title, //不设置或设置为空时，页面有title，则调取title
            shareDesc:window.share_desc,  //不设置或设置为空时，页面有Description，则调取Description
            shareImgUrl:'//www.tolotolo.cn/static/images/m1.jpg', //分享图片尺寸200*200，且填写绝对路径
            shareLink:location.href,
            debug: false, //是否开启debug模式
            ShareCallBack: function (ex) {
             //   alert("share suc")
              }
            })

</script>
     <?php
      

}
add_action( 'wp_footer', 'footer_diy',99 );

/**
 * desc
*/
function new_excerpt_length($length) {
     return 50;
}
 add_filter('excerpt_length', 'new_excerpt_length');

function wpdocs_excerpt_more( $more ) {
    return '...<a class="read-more" href="'.get_the_permalink().'" rel="nofollow" >[阅读全文]</a>';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

/**
 * thumbnail
*/
function get_current_thumbnail($post=null,$class='',$mini=false){
     $path=get_bloginfo('template_directory').'/static/images/';
    //默认的图片。
    if($mini){
         

         $thumbnail='<img src="'.$path.'thumbnail-200x200.jpg" class="'.$class.'" alt="thumbnail" >' ;
    }else{
        $thumbnail='<img src="'.$path.'thumbnail.jpg" class="'.$class.'" alt="thumbnail" >' ;
    } 
    $thumbnail_back= $thumbnail;
    if ( !$post ){return  $thumbnail;}
  
    
    if ( has_post_thumbnail() ){  //特色图片

        $thumbnail=get_the_post_thumbnail(null,$size = 'post-thumbnail',"class=$class") ; 

    }
    else{   // 如果文章内包含有图片，就用第一张图片做为缩略图

           ob_start();       
           ob_end_clean();
           $content = $post->post_content;  
                      
           preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $strResult);  
            
            $name= substr($strResult[1], 0, strrpos($strResult[1], '.'));
            $type= substr($strResult[1], strrpos($strResult[1], '.'));
           
         
            $thumbnail= $name.'-200x200'.$type;

        
            if( @fopen( 'http:'.$thumbnail, 'r')|| @fopen( 'https:'.$thumbnail, 'r' ) )   
            {       

                 $thumbnail='<img src="'.$thumbnail.'" class="'.$class.'" alt="thumbnail">' ;
            }else{
                 $thumbnail=$thumbnail_back;
            }
           
          
    }
    return $thumbnail;
}

/**
 *related_list
*/
function post_related_list($len,$echo=true){
  global $post;
  $html="";
  $post_num=0;

  $post_num=$len;
  $exclude_id = $post->ID;

  $html.='<ul class="row" >';
  $posttags = get_the_tags(); $i = 0;


  //用标签补充post_num
  if ( $posttags ) {
    $tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->term_id . ',';
    $args = array(
      'post_status' => 'publish',
      'tag__in' => explode(',', $tags),
      'post__not_in' => explode(',', $exclude_id),
      'caller_get_posts' => 1,
      'orderby' => 'comment_date',
      'posts_per_page' => $post_num,
    );      
    query_posts($args);
    while( have_posts() ) { the_post();

       $thumbnail=get_current_thumbnail($post,"thumbnail mini","mini");
       $html.='<li class="col-xs-4 col-sm-3 col-lg-2"> <a rel="bookmark"   href="'.get_permalink().'" title="'.$post->post_title.'" target="_blank">'.$thumbnail.'</a>
            <h5><a href="'.get_permalink().'">'.$post->post_title.'</a></h5></li>';
       $exclude_id .= ',' . $post->ID; $i ++;
    } 
    wp_reset_query();
  }
  //用分类补充post_num
  if ( $i < $post_num ) {
      $cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
      $args = array(
        'category__in' => explode(',', $cats),
        'post__not_in' => explode(',', $exclude_id),
        'caller_get_posts' => 1,
        'orderby' => 'comment_date',
        'posts_per_page' => $post_num - $i
      );
      query_posts($args);
      while( have_posts() ) { the_post(); 
         $thumbnail=get_current_thumbnail($post,"thumbnail mini","mini");
         $html.='<li class="col-xs-4 col-sm-3 col-lg-2"> <a rel="bookmark"   href="'.get_permalink().'" title="'.$post->post_title.'" target="_blank">'.$thumbnail.'</a>
            <h5>'.$post->post_title.'</h5></li>';

         $i++; 
      }
      wp_reset_query();
  }

  //没有相关文章
  if ( $i  == 0 )  echo '<li>没有相关文章!</li>';

   $html.='</ul>';

  if($echo)
    _e($html);
  else
  return $html;
}


/*breadcrumbs*/
function get_current_category_id($single='') {
    if($single=='single'){
         $current_category = get_the_category();
         return  get_cat_ID( $current_category[0]->cat_name );
    }else{
         $current_category = single_cat_title('', false);//获得当前分类目录名称
         return get_cat_ID($current_category);//获得当前分类目录ID
    }
}

function get_current_tag_id() {
 $current_tag = single_tag_title('', false);//获得当前TAG标签名称
 $tags = get_tags();//获得所有TAG标签信息的数组
   foreach($tags as $tag) {
  if($tag->name == $current_tag) return $tag->term_id; //获得当前TAG标签ID，其中term_id就是tag ID
 }
}
function get_category_dir( $id,$active=true , $nicename = false, $visited = array()) {
    $chain = '';
    $parent = get_term( $id, 'category' );
    if ( is_wp_error( $parent ) )
        return $parent;

    if ( $nicename )
        $name = $parent->slug;
    else
        $name = $parent->name;

   
    if ( $parent->parent && ( $parent->parent != $parent->term_id ) && !in_array( $parent->parent, $visited ) ) {
        $visited[] = $parent->parent;
       
        $chain .= get_category_dir( $parent->parent, $nicename, $visited );
          
    }

    if($active){$active='class="active"';}

   
     $chain .= '<li '.$active.'><a href="' . esc_url( get_category_link( $parent->term_id ) ) . '">'.$name.'</a></li>';
    
    return $chain;
}

function get_breadcrumbs()
{
    global $wp_query;

    $flag="";
    $home= '<li><a href="'. get_settings('home') .'">'.get_bloginfo( 'name' ).'</a></li>';

    if ( is_home() ){
        $flag=$home;
    }
    elseif ( is_category())  //分类
    {   
         $cat_id = get_current_category_id();
         $category= get_category_dir( $cat_id) ;
         $flag=$home.$category;
    }
    elseif (is_tag()) {    //标签
        $tag_id=get_current_tag_id();
        $tag= '<li class="active"><a href="'.get_tag_link($tag_id).'">'.single_tag_title('', false).'</li>'; 
        $flag=$home.$tag;
    }
    elseif (  is_singular( 'post' ) )//文章
    {      

        $cat_id = get_current_category_id('single');
        $category=  get_category_dir( $cat_id,false) ;
        $single = '<li class="active"> '. the_title('','', FALSE) ."</li>";
        $flag=$home.$category.$single;
    }
    elseif ( is_archive() && !is_category() )
    {  
           if (is_day()) {echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';}
           elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'</li>';}
           elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'</li>';}
           elseif (is_author()) {echo"<li>Author Archive"; echo'</li>';}
           elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>';}

    }
    elseif ( is_search() ) {

        echo $home."<li> 搜索</li>";
    }
    elseif ( is_404() )
    {
        echo $home."<li> 404页面</li>";
    }
    else {  
        echo $home.'<li> '. the_title('','', FALSE) ."</li>";
    }

    echo $flag;
}


/**baidushare 
*获取分享特色图片
*/
function get_post_thumbnail_url($post_id){
$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
$thumbnail_id = get_post_thumbnail_id($post->ID);
if($thumbnail_id ){
$thumb = wp_get_attachment_image_src($thumbnail_id, 'thumbnail');
return $thumb[0];
   }else{
return false;
  }
}

function get_ssl_avatar($avatar) {
  $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="https://secure.gravatar.com/avatar/$1?s=100&d=mm&r=g" class="avatar avatar-50 photo"  height="50" width="50">',$avatar);  
  return $avatar;
  }
  add_filter('get_avatar', 'get_ssl_avatar');

// function more_posts() {
//   global $wp_query;
//   return $wp_query->current_post + 0 < $wp_query->post_count;
// }

?>