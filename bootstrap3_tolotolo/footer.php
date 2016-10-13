<?php
global $dm_settings;
if ($dm_settings['footer_sidebar'] != 0) : ?>
<!-- start footer container -->

<footer class="footer container-fluid">
    <?php
            global $dm_settings;
            if ($dm_settings['author_credits'] != 0) : ?>
                <div class="row dmbs-author-credits">
                    <p class="text-center"><a href="<?php global $developer_uri; echo esc_url($developer_uri); ?>">DevDmBootstrap3 <?php _e('created by','devdmbootstrap3') ?> Danny Machal</a></p>
                </div>
    <?php endif; ?>
    
                     <style type="text/css">
                                
                       
                        .footer-container{  margin:0 auto; position: relative; text-align: center;  font-size: 12px;}
                        .footer-copyrights{ margin: 0 auto; margin-top:40px;   }
                        .footer-copyrights p{ line-height: 20px; margin:20px 0;}
                        .footer a{color: #ededed; text-decoration: none;}
                        .footer-tips{   }
                        .footer-advice{ }
                        
                        </style>
                    <div class="footer-container container clearfix">
                            <div class="row">
                                <div class="footer-tips col-xs-12 col-md-2"><h5>Tips:</h5>请使用 Microsoft Edge,Chrome等现代游览器游览,<br/>手机也能看哦！</div>
                                <div class="footer-copyrights col-xs-12 col-md-8">
                                     <?php get_template_part('template-parts/footer', 'navbar'); ?>
                                  
                                </div>
                                <div class="footer-advice col-xs-12 col-md-2"><h5>Bug反馈:</h5>如果有侵权行为 在此表示歉意。请联系管理员mail
                                    <br/><a href="mailto:lanbosm@gmail.com">lanbosm@gmail.com</a>
                                </div>
                            </div>

                    </div>
   

    <hr>
    <p style="text-align: center;">感谢wordpress bootstrap 腾讯云 以及各位插件开发者的支持帮助！</p>
   
</footer>
<!-- end footer container -->
<?php endif; ?>

<!-- start enqueue content   -->
<?php wp_footer(); ?>

<!-- end enqueue content   -->
</body>
</html>