                            
                             <ol class="breadcrumb  col-xs-12 col-md-7">
                                   你的位置：<?php get_breadcrumbs()?>

                             </ol>
                             <div class="club col-xs-12 col-md-5">
                                    <div class="bdsharebuttonbox clearfix " id="shareBox">
                                       <span class="visible-lg-inline placeholder"></span>
                                       <a title="分享到微信" class="sweixin" href="#" data-cmd="weixin"></a>
                                       <a title="分享到新浪微博" class="stsina" href="#" data-cmd="tsina"></a>
                                       <a title="分享到QQ好友" class="sqq" href="#" data-cmd="sqq"></a>
                                       <a title="分享到百度贴吧" class="stieba" href="#" data-cmd="tieba"></a>
                                       <a title="分享到Twitter" class="stwi" href="#" data-cmd="twi"></a>
                                       <a class="bds_more" href="#" data-cmd="more"></a>

                                       <style type="text/css">

                                          #shareBox .placeholder{width:120px; height: 32px; float: left; display: inline-block;}
                                          #shareBox a.sqq{background-position: -27px -28px;}
                                          #shareBox a.sweixin{background-position: -27px -95px;}
                                          #shareBox  a.stsina {background-position: -137px -95px;}
                                          #shareBox  a.stieba {background-position: -83px -158px;}
                                          #shareBox a.stwi{background-position: -138px -28px;}
                                          #shareBox  a.bds_more {background-position: -194px -159px; }
                                          #shareBox  a{
                                            background-image:url(/wp/wp-content/themes/bootstrap3_tolotolo/static/images/sns_icon.png);
                                            background-size: 256px;
                                            padding-left:0px;
                                            width: 32px; height: 32px;
                                            line-height: 32px; 
                                            margin: 3px;                                    
                                          } 
                                          #shareBox  a:hover{opacity: 1;}
                                       </style>
                                        <!--百度分享javascript-->
                                       <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"<?php echo get_post_thumbnail_url($post->ID); ?>","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
                                       </script>
                                       <!--百度分享javascript-->
                                    </div>
                              </div>
