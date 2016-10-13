<?php

load_theme_textdomain( 'devdmbootstrap3', get_template_directory() . '/languages' );

/////////////////////////////////////////////////////////////////////
// Add DevDm Theme Options to the Appearance Menu and Admin Bar
////////////////////////////////////////////////////////////////////

    function dmbs_theme_options_menu() {
        add_theme_page( 'bootstrap' . __('Options','devdmbootstrap3'), 'bootstrap' . __('Options','devdmbootstrap3'), 'manage_options', 'devdm-theme-options', 'devdm_theme_options' );
    }
    add_action( 'admin_menu', 'dmbs_theme_options_menu' );

    add_action( 'admin_bar_menu', 'toolbar_link_to_dmbs_options', 999 );

    function toolbar_link_to_dmbs_options( $wp_admin_bar ) {
        $args = array(
            'id'    => 'devdm_theme_options',
            'title' => __('DevDm Options','devdmbootstrap3'),
            'href'  => home_url() . '/wp-admin/themes.php?page=devdm-theme-options',
            'meta'  => array( 'class' => 'devdm-theme-options' ),
            'parent' => 'site-name'
        );
        $wp_admin_bar->add_node( $args );
    }

////////////////////////////////////////////////////////////////////
// Add admin.css enqueue
////////////////////////////////////////////////////////////////////

    function devdm_theme_style() {
        wp_enqueue_style('devdm-theme', get_template_directory_uri() . '/css/admin.css');
    }
    add_action('admin_enqueue_scripts', 'devdm_theme_style');

////////////////////////////////////////////////////////////////////
// Custom background theme support
////////////////////////////////////////////////////////////////////

    $defaults = array(
        'default-color'          => '',
        'default-image'          => '',
        'wp-head-callback'       => function(){},
        'admin-head-callback'    => '',
        'admin-preview-callback' => ''
    );
    add_theme_support( 'custom-background', $defaults );

    function wrap_bg_setting() {
        // $background is the saved custom image, or the default image.
        $background = set_url_scheme( get_background_image() );

        // $color is the saved custom color.
        // A default has to be specified in style.css. It will not be printed here.
        $color = get_background_color();

        if ( $color === get_theme_support( 'custom-background', 'default-color' ) ) {
            $color = false;
        }

        if ( ! $background && ! $color )
            return;

        $bgcolor = "background: #$color;";
        $style ='';

        if ( $background ) {
            

            $repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );
            if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
                $repeat = 'repeat';
            $repeat = "$repeat";

            $position = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
            if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
                $position = 'left';
            $position = "top $position";

            $attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );
            if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
                $attachment = 'scroll';
            $attachment = "$attachment";

            $style = " background:url('$background') $repeat $position $attachment ;background-size:100%;" ;
        }


        if ( get_header_textcolor() != 'blank' ) {
            $textcolor= "color:#".get_header_textcolor(); 
        }

    ?>

    <!-- theme wrap start-->
    <style type="text/css" id="custom-background-css">
     body{ <?php echo trim( $bgcolor ); ?> }
     body,a {<?php echo trim( $textcolor );?> }
     .wrap { <?php echo trim( $style ); ?> }
    </style>
    <!-- theme wrap End-->
    <?php
}

  add_action ('wp_head', 'wrap_bg_setting',30);
////////////////////////////////////////////////////////////////////
// Custom header theme support
////////////////////////////////////////////////////////////////////

    register_default_headers( array(
        'wheel' => array(
            'url' => '%s/static/banner.jpg',
            'thumbnail_url' => '%s/static/images/banner.jpg',
            'description' => __( 'tolotolo', '分享技术 分享快乐' )
        ))

    );

    $defaults = array(
        'default-image'          => get_template_directory_uri() . '/static/images/banner.jpg',
        'width'                  => 1200,
        'height'                 => 360,
        'flex-height'            => true,
        'flex-width'             => true,
        'default-text-color'     => '000',
        'header-text'            => true,
        'uploads'                => true,
        'wp-head-callback'       => '',
        'admin-head-callback'    => '',
        'admin-preview-callback' => '',
    );
    add_theme_support( 'custom-header', $defaults );

    
   
////////////////////////////////////////////////////////////////////
// Register our settings options (the options we want to use)
////////////////////////////////////////////////////////////////////

    $dm_options = array(
        'author_credits' => true,
        'right_sidebar' => true,
        'right_sidebar_width' => 3,
        'left_sidebar' => false,
        'left_sidebar_width' => 3,
        'footer_sidebar' => true,
        'show_header' => true,
        'show_postmeta' => true
    );

    $dm_sidebar_sizes = array(
        '1' => array (
            'value' => '1',
            'label' => '1'
        ),
        '2' => array (
            'value' => '2',
            'label' => '2'
        ),
        '3' => array (
            'value' => '3',
            'label' => '3'
        ),
        '4' => array (
            'value' => '4',
            'label' => '4'
        ),
        '5' => array (
            'value' => '5',
            'label' => '5'
        )

    );

    function dm_register_settings() {
        register_setting( 'dm_theme_options', 'dm_options', 'dm_validate_options' );
    }

    add_action ('admin_init', 'dm_register_settings');
    $dm_settings = get_option( 'dm_options', $dm_options );


////////////////////////////////////////////////////////////////////
// Validate Options
////////////////////////////////////////////////////////////////////

    function dm_validate_options( $input ) {

        global $dm_options, $dm_sidebar_sizes;

        $settings = get_option( 'dm_options', $dm_options );

        $prev = $settings['right_sidebar_width'];
        if ( !array_key_exists( $input['right_sidebar_width'], $dm_sidebar_sizes ) ) {
            $input['right_sidebar_width'] = $prev;
        }

        $prev = $settings['left_sidebar_width'];
        if ( !array_key_exists( $input['left_sidebar_width'], $dm_sidebar_sizes ) ) {
            $input['left_sidebar_width'] = $prev;
        }

        if ( ! isset( $input['author_credits'] ) ) {
            $input['author_credits'] = null;
        } else {
            $input['author_credits'] = ( $input['author_credits'] == 1 ? 1 : 0 );
        }

        if ( ! isset( $input['show_header'] ) ) {
            $input['show_header'] = null;
        } else {
            $input['show_header'] = ( $input['show_header'] == 1 ? 1 : 0 );
        }

        if ( ! isset( $input['right_sidebar'] ) ) {
            $input['right_sidebar'] = null;
        } else {
            $input['right_sidebar'] = ( $input['right_sidebar'] == 1 ? 1 : 0 );
        }

        if ( ! isset( $input['left_sidebar'] ) ) {
            $input['left_sidebar'] = null;
        } else {
            $input['left_sidebar'] = ( $input['left_sidebar'] == 1 ? 1 : 0 );
        }

        if ( ! isset( $input['show_postmeta'] ) ) {
            $input['show_postmeta'] = null;
        } else {
            $input['show_postmeta'] = ( $input['show_postmeta'] == 1 ? 1 : 0 );
        }

        return $input;
    }

////////////////////////////////////////////////////////////////////
// Display Options Page
////////////////////////////////////////////////////////////////////

    function devdm_theme_options() {

    if ( !current_user_can( 'manage_options' ) )  {
        wp_die('You do not have sufficient permissions to access this page.');
    }

        //get our global options
        global $dm_options, $dm_sidebar_sizes, $developer_uri;

        //get our logo
        $logo = get_template_directory_uri() . '/static/images/tolotolo.jpg'; ?>

        <div class="wrap">

        <div class="dm-logo-wrap"><a href="//www.tolotolo.cn/" target="_blank"><img src="<?php echo $logo; ?>" class="dm-logo" title="logo" /></a></div>

            <div class="icon32" id="icon-options-general"></div>

            <h2><a href="http://v3.bootcss.com/" target="_blank">Bootstrap文档</a></h2>

               <?php

               if ( ! isset( $_REQUEST['settings-updated'] ) )

                   $_REQUEST['settings-updated'] = false;

               ?>

               <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>

               <div class='saved'><p><strong><?php _e('Options Saved!','devdmbootstrap3') ;?></strong></p></div>

               <?php endif; ?>

            <form action="options.php" method="post">

                <?php
                    $settings = get_option( 'dm_options', $dm_options );
                    settings_fields( 'dm_theme_options' );
                ?>

                <table cellpadding='10'>

                    <tr valign="top"><th scope="row"><?php _e('Right Sidebar','devdmbootstrap3') ;?></th>
                        <td>
                            <input type="checkbox" id="right_sidebar" name="dm_options[right_sidebar]" value="1" <?php checked( true, $settings['right_sidebar'] ); ?> />
                            <label for="right_sidebar"><?php _e('Show the Right Sidebar','devdmbootstrap3') ;?></label>
                        </td>
                    </tr>

                    <tr valign="top"><th scope="row"><?php _e('Right Sidebar Size','devdmbootstrap3') ;?></th>
                        <td>
                    <?php foreach( $dm_sidebar_sizes as $sizes ) : ?>
                        <input type="radio" id="<?php echo $sizes['value']; ?>" name="dm_options[right_sidebar_width]" value="<?php echo esc_attr($sizes['value']); ?>" <?php checked( $settings['right_sidebar_width'], $sizes['value'] ); ?> />
                        <label for="<?php echo $sizes['value']; ?>"><?php echo $sizes['label']; ?></label><br />
                    <?php endforeach; ?>
                        </td>
                    </tr>

                    <tr valign="top"><th scope="row"><?php _e('Left Side Bar','devdmbootstrap3') ;?></th>
                        <td>
                            <input type="checkbox" id="left_sidebar" name="dm_options[left_sidebar]" value="1" <?php checked( true, $settings['left_sidebar'] ); ?> />
                            <label for="left_sidebar"><?php _e('Show the Left Sidebar','devdmbootstrap3') ;?></label>
                        </td>
                    </tr>

                    <tr valign="top"><th scope="row"><?php _e('Left Sidebar Size','devdmbootstrap3') ;?></th>
                        <td>
                            <?php foreach( $dm_sidebar_sizes as $sizes ) : ?>
                                <input type="radio" id="<?php echo $sizes['value']; ?>" name="dm_options[left_sidebar_width]" value="<?php echo esc_attr($sizes['value']); ?>" <?php checked( $settings['left_sidebar_width'], $sizes['value'] ); ?> />
                                <label for="<?php echo $sizes['value']; ?>"><?php echo $sizes['label']; ?></label><br />
                            <?php endforeach; ?>
                        </td>
                    </tr>
                     <tr valign="top"><th scope="row"><?php _e('Footer Sidebar','devdmbootstrap3') ;?></th>
                        <td>
                            <input type="checkbox" id="footer_sidebar" name="dm_options[footer_sidebar]" value="1" <?php checked( true, $settings['footer_sidebar'] ); ?> />
                            <label for="footer_sidebar"><?php _e('Show the footer Sidebar','devdmbootstrap3') ;?></label>
                        </td>
                    </tr>
                    <tr valign="top"><th scope="row"><?php _e('Show Header','devdmbootstrap3') ;?></th>
                        <td>
                            <input type="checkbox" id="show_header" name="dm_options[show_header]" value="1" <?php checked( true, $settings['show_header'] ); ?> />
                            <label for="show_header"><?php _e('Show The Main Header in the Template (logo/sitename/etc.)','devdmbootstrap3') ;?></label>
                        </td>
                    </tr>

                    <tr valign="top"><th scope="row"><?php _e('Show Post Meta','devdmbootstrap3') ;?></th>
                        <td>
                            <input type="checkbox" id="show_postmeta" name="dm_options[show_postmeta]" value="1" <?php checked( true, $settings['show_postmeta'] ); ?> />
                            <label for="show_postmeta"><?php _e('Show Post Meta data (author, category, date created)','devdmbootstrap3') ;?></label>
                        </td>
                    </tr>

                    <tr valign="top"><th scope="row"><?php _e('Give Danny His Credit?','devdmbootstrap3') ;?></th>
                        <td>
                            <input type="checkbox" id="author_credits" name="dm_options[author_credits]" value="1" <?php checked( true, $settings['author_credits'] ); ?> />
                            <label for="author_credits"><?php _e('Show me some love and keep a link to DevDm.com in your footer.','devdmbootstrap3') ;?></label>
                        </td>
                    </tr>

                </table>

                <p class="submit">
                    <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes','devdmbootstrap3'); ?>" />
                </p>

            </form>

        </div>
<?php

}
?>
