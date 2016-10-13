<?php
    global $dm_settings;
    if ($dm_settings['right_sidebar'] != 0) : ?>
    <div class="col-sm-<?php echo $dm_settings['right_sidebar_width']; ?> col-lg-2 ">
        
                <div class="rightbar row">
                	<div style="height:200px; line-height:200px; text-align:center;">
                		博主信息
                	</div>
                	<div style="height:100px; line-height:100px;text-align:center;">
                		注意事项
                	</div>
                    <?php //get the right sidebar
                   
                    dynamic_sidebar( 'Right Sidebar' ); ?>

                    <div class="hidden-xs">
            	        <div style="height:400px; line-height:400px;text-align:center;">
            	    		排行
            	    	</div>
            	    	<div class="ad " style="text-align:center ;padding-bottom:30px;">
            	    	      <a href="//www.qcloud.com/?utm_source=bdppzq&utm_medium=line&utm_campaign=baidu"><img  src="/wp/wp-content/themes/bootstrap3_tolotolo/ad/imgad.jpg" /></a>
            	    	</div>
            	    </div>
               </div>
       
    </div>
<?php endif; ?>