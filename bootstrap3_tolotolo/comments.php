<?php if ( is_single() || is_page() ) : ?>
    <div class="clear"></div>
    <div class="dmbs-comments col-xs-12  ">
        <a name="comments"></a>
            <?php if (   comments_open() ) :

        $newfields= array(

          'author' =>
            '<div class="comment-form-author form-group col-xs-12 col-md-6">
                <label for="author">' . __( '昵称', 'domainreference' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
                '<input id="author" name="author" type="text" class="form-control" placeholder="name"  value="'  . esc_attr( $commenter['comment_author'] ) .'" size="30"' . $aria_req . ' />
             </div>',
          'email' =>
            '<div  class="comment-form-email form-group col-xs-12 col-md-6">
                <label for="email">' . __( 'Email', 'domainreference' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
                '<input id="email" name="email" type="text"  class="form-control" placeholder="Email" value="' . esc_attr(  $commenter['comment_author_email'] ) .'" size="30"' . $aria_req . ' />
             </div>',

          'url' =>
            '<div class="comment-form-url form-group col-xs-12 col-xs-12">
                <label for="url">' . __( '个人网站', 'domainreference' ) . '</label>' .
                    '<input id="url" name="url" type="text" class="form-control" placeholder="webSite" value="' . esc_attr( $commenter['comment_author_url'] ) .'" size="30" /></div>',
        );


        $comments_args = array(

                'fields' => apply_filters( 'comment_form_default_fields', $newfields ),
                // change the title of send button 
                'title_reply'       => null,
                'label_submit'=>'提交',
                'class_submit'      => 'submit btn btn-info ',

                'comment_notes_before'=>'<p class="col-xs-12"> 电子邮件地址不会被公开。 必填项已用*标注 <br/>如果想修改头像请前往 <a href="http://cn.gravatar.com/" target="blank" >Gravatar</a> 注册</p>',
                'comment_field' => '<div class="comment-form-comment form-group col-xs-12"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><br /><textarea id="comment" class="form-control" name="comment" aria-required="true"></textarea></div>'
                //https://codex.wordpress.org/Function_Reference/comment_form#.24args
        ); ?>
    
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                 <div class="panel panel-info">
                    <div class="panel-heading" role="tab" id="writecomment">
                       <a class=" btn btn-info  btn-block " data-parent="#accordion" href="#writecommentbody" aria-expanded="true" aria-controls="writecommentbody">写评论 </a>  
                    </div>
                    <div id="writecommentbody" class="panel-collapse" role="tabpanel" aria-labelledby="writecommentbody">
                        <div class="panel-body">
                             <?php comment_form($comments_args);?>
                        </div>
                    </div>
                </div>
               
                <div class="panel panel-info">
                        <div class="panel-heading" role="tab" id="showcomment">
                             <a class=" btn btn-info  btn-block " type="button" data-toggle="collapse" data-parent="#accordion" href="#showcommentbody" aria-expanded="true" aria-controls="showcommentbody"> 
                                  <?php _e(' Comments','devdmbootstrap3');?> <span class="badge"><?php comments_number(0, '%', '%'  );?></span>
                             </a> 
                        </div> 
                </div>
                <div id="showcommentbody" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="showcommentbody">
                            <div class="panel-body">
                                <?php if ( have_comments()  ) : ?>
                                    <ul class="commentlist">
                                        <?php wp_list_comments('type=comment&callback=tolotolo_bootstrap_comment'); ?>
                                        <?php paginate_comments_links(); ?>
                                        <?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
                                    </ul>
                                <?php else : ?>
                                    <div class="col-xs-12"><h4 class="text-center">沙发是空的</h4></div>
                                <?php endif; ?>
                             </div>
                 </div>  
               
            </div>       
    <?php else : ?>
                <h4 class="text-center" >评论已关闭</h4>
    <?php endif; ?>
         
    </div>
    <script src="//cdn.bootcss.com/holder/2.9.3/holder.min.js"></script>
                      
<?php endif; ?>