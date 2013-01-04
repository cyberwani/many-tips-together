<?php

!defined( 'ABSPATH' ) AND exit;

if ( !class_exists( 'MTT_Hook_Login' ) ):
class MTT_Hook_Login
{
    // store the options
    protected $params;

    /**
     * Check options and dispatch hooks
     * 
     * @param  array $options
     * @return void
     */
    public function __construct( $options )
    {

        $this->params = $options;

        // REDIRECT LOGIN
        if ( !empty( $this->params['login_redirect_enable']['enabled'] ) )
            add_filter( 
                    'login_redirect', 
                    array( $this, 'login_redirect' )
                    , 10, 3 
            );

        // REDIRECT LOGOU
        if ( !empty( $this->params['logout_redirect_enable']['enabled'] ) )
            add_action( 
                    'wp_logout', 
                    array( $this, 'logout_redirect' ) 
            );

        // TOOLTIP FOR LOGO
        if ( !empty( $this->params['loginpage_logo_tooltip'] ) )
            add_filter( 
                    'login_headertitle', 
                    array( $this, 'logo_title' ), 
                    15 
            );

        // CUSTOM MESSAGE FOR LOGIN ERRORS
        if ( !empty( $this->params['loginpage_errors']['enabled'] ) )
            add_filter( 
                    'login_errors', 
                    array( $this, 'error_msg' ) 
            );

        // DISABLE SHAKING
        if ( !empty( $this->params['loginpage_disable_shaking'] ) )
            add_filter( 
                    'shake_error_codes', 
                    array( $this, 'no_shaking' ), 
                    15 
            );

        // CUSTOM URL FOR LOGO
        if ( !empty( $this->params['loginpage_logo_url'] ) )
            add_filter( 
                    'login_headerurl', 
                    array( $this, 'logo_link' ), 
                    15 
            );

        // ALL ACTIONS FOR CSS
        add_action( 
                'login_head', 
                array( $this, 'login_css' ), 
                999 
        );
    }


    /**
     * Redirect on login
     * 
     * @param type $redirect_to
     * @param type $request
     * @param type $user
     * @return string URL
     */
    public function login_redirect( $redirect_to, $request, $user )
    {
        if ( !empty( $this->params['login_redirect_enable']['url'] ) )
            return $this->params['login_redirect_enable']['url'];
        
        return $redirect_to;
    }


    /**
     * Redirect on logout
     * 
     * @return action Do redirect
     */
    public function logout_redirect()
    {
        if ( empty( $this->params['logout_redirect_enable']['url'] ) )
            return;
        
        wp_redirect( $this->params['logout_redirect_enable']['url'] );
        die();
    }


    /**
     * Custom Alt for logo
     * 
     * @return type
     */
    public function logo_title()
    {
        return $this->params['loginpage_logo_tooltip'];
    }


    /**
     * Custom link for logo
     * 
     * @return string URL
     */
     public function logo_link()
    {
       return $this->params['loginpage_logo_url'];
    }


    /**
     * Custom error message on login error
     * 
     * @return string
     */
    public function error_msg()
    {
        $errorMsg = esc_html( stripslashes( $this->params['loginpage_errors']['msg'] ) );
        return $errorMsg;
    }


    /**
     * Block shaking on errors
     * 
     * @return array Empty
     */
    public function no_shaking()
    {
        return array();
    }


    /**
     * Styles for the login page
     */
    function login_css()
    {
        $opts = $this->params;
        
        // LOGO
        $logo_height  = !empty( $opts['loginpage_logo_height'] ) 
            ? 'height:' . $opts['loginpage_logo_height'] . 'px; ' : '';
        
        $logo_img     = !empty($opts['loginpage_logo_img']['src']) 
            ? 'background-image:url(' . $opts['loginpage_logo_img']['src'] . ') !important;' : '';
        
        $div_login_h1 = '#login h1 a { margin:0px;width:auto; ' . $logo_height . $logo_img . '; background-size:100%} ';
        
                    
        // FORM CONTAINER (width)
        $frm_width    = !empty( $opts['loginpage_form_width'] ) 
            ? 'width: ' . $opts['loginpage_form_width'] . 'px;' : '';
        
        $div_login = '#login{' . $frm_width . '} ';//$logo_padding . 
        

        // FORM TAG
        $frm_height    = !empty( $opts['loginpage_form_height'] ) 
            ? 'height: ' . $opts['loginpage_form_height'] . 'px;;' : '';//padding-top:40px
        
        $frm_shadow    = !empty( $opts['loginpage_form_noshadow'] ) 
            ? '-moz-box-shadow: none;-webkit-box-shadow:none;box-shadow:none;' : '';
        
        $frm_rounded   = !empty( $opts['loginpage_form_rounded'] ) 
            ? '-webkit-border-radius:' . $opts['loginpage_form_rounded'] . 'px;border-radius:' . $opts['loginpage_form_rounded'] . 'px;' : '';
        
        $frm_border    = !empty( $opts['loginpage_form_border'] ) 
            ? 'border:0px;' : '';
        
        $frm_bg        = !empty( $opts['loginpage_form_bg_img']['src'] ) 
            ? 'background: url(' . $opts['loginpage_form_bg_img']['src'] . ') no-repeat;' : '';
        
        $frm_color     = ( !empty( $opts['loginpage_form_bg_color'] ) && '#' != $opts['loginpage_form_bg_color'] )
            ? 'background-color: ' . $opts['loginpage_form_bg_color'] . ';' : '';

        $div_loginform = '#loginform {' 
            . $frm_border . $frm_height . $frm_shadow 
            . $frm_rounded . $frm_bg . $frm_color 
            . '; margin-left:0} '; // margin-left Force full width

           
        
        // BODY
        $body_color     = ( !empty( $opts['loginpage_body_color'] ) && '#' != $opts['loginpage_body_color'] )
             ? 'background-color:' . $opts['loginpage_body_color'] . ';' : '';
        
        $body_position   = ' ';
        if( !empty( $opts['loginpage_body_position'] ) )
        {
            if( 'empty' != $opts['loginpage_body_position'] ) 
                $body_position = str_replace( '_', ' ', $opts['loginpage_body_position'] ) . ' ';
        }
        
        $body_repeat     = ' ';
        if( !empty( $opts['loginpage_body_repeat'] ) )
        {
             if( 'empty' != $opts['loginpage_body_repeat'] ) 
                 $body_repeat = $opts['loginpage_body_repeat'] . ' ';
        }
        
        $body_attachment = ' ';
        if( !empty( $opts['loginpage_body_attachment'] ) )
            $body_attachment = $opts['loginpage_body_attachment'] . ' ';
            
        $body_img        = !empty( $opts['loginpage_body_img']['src'] )
            ? 'url(' . $opts['loginpage_body_img']['src'] . ')' : '';
 
        $css_img         = ( $body_img != '') 
            ? 'background:' . $body_position . $body_repeat . $body_attachment . $body_img . ';' : '';

        $htmlbody        = 'body,body.login{height:100%;' . $css_img . $body_color . '} ';


        // BACK TO BLOG
        $p_backtoblog        = !empty( $opts['loginpage_backsite_hide'] ) 
            ? ' p#backtoblog{display:none;} ' : '';


        // REMOVE TEXT SHADOW
        $div_nav_backtoblog        = !empty( $opts['loginpage_text_shadow'] ) 
            ? ' #nav, #backtoblog { text-shadow: none !important; } ' : '';

        // EXTRA CSS
        $extra_css = ('.class-name {}' != $opts['loginpage_extra_css'] )
                ? $opts['loginpage_extra_css'] 
                : '';
        
        
        // ufs... PRINT OUR STUFF
        echo '
<style type="text/css">'  . "\r\n"
                . $div_login_h1  . "\r\n" . "\r\n"
                . $div_login  . "\r\n" . "\r\n"
                . $div_loginform  . "\r\n" . "\r\n"
                . $htmlbody . "\r\n" . "\r\n"
                . $p_backtoblog  . "\r\n" . "\r\n"
                . $div_nav_backtoblog  . "\r\n" . "\r\n"
                . $extra_css  . "\r\n" . "\r\n"
                . '</style>
';
          
         
    }
    
}
endif;