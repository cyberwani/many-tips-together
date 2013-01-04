<?php
!defined( 'ABSPATH' ) AND exit;


/**
 * Admin Page Class Validate
 * version 2012.12.24
 */
if( !class_exists( 'BF_Admin_Page_Class_Validate' ) ):

    class BF_Admin_Page_Class_Validate
    {

        public function validate_loginout_url( $value )
        {
            // false doesn't allow #
            $url                          = MTT_Plugin_Utils::check_url( $value['url'], false );
            if( !$url )
                $value['url'] = '';
            return $value;
        }


        public function validate_adminbar_sitename( $value )
        {
            $url                            = MTT_Plugin_Utils::check_url( $value['adminbar_sitename_url'], true );
            if( !$url )
                $value['adminbar_sitename_url'] = '';
            return $value;
        }


        public function validate_adminbar_custom( $value )
        {
            $url0                           = MTT_Plugin_Utils::check_url( $value['adminbar_custom_0_url'], true );
            if( !$url0 )
                $value['adminbar_custom_0_url'] = '';

            $url1                           = MTT_Plugin_Utils::check_url( $value['adminbar_custom_1_url'], true );
            if( !$url1 )
                $value['adminbar_custom_1_url'] = '';

            $url2                           = MTT_Plugin_Utils::check_url( $value['adminbar_custom_2_url'], true );
            if( !$url2 )
                $value['adminbar_custom_2_url'] = '';

            $url3                           = MTT_Plugin_Utils::check_url( $value['adminbar_custom_3_url'], true );
            if( !$url3 )
                $value['adminbar_custom_3_url'] = '';

            $url4                           = MTT_Plugin_Utils::check_url( $value['adminbar_custom_4_url'], true );
            if( !$url4 )
                $value['adminbar_custom_4_url'] = '';

            $url5                           = MTT_Plugin_Utils::check_url( $value['adminbar_custom_5_url'], true );
            if( !$url5 )
                $value['adminbar_custom_5_url'] = '';

            return $value;
        }


        public function validate_simple_full_url( $value )
        {
            $url   = MTT_Plugin_Utils::check_url( $value, false );
            if( !$url )
                $value = '';
            return $value;
        }


        /**
         * Validates Numbers and CSS Numbers (stripping px and %)
         * @param type $value
         * @return type
         */
        public function validate_number( $value )
        {
            $num   = MTT_Plugin_Utils::validate_css_number( $value );
            if( !$num )
                $value = '';
            else
                $value = $num;

            return $value;
        }


        public function validate_thumb_column( $value )
        {
            $prop                = MTT_Plugin_Utils::validate_css_number( $value['proportion'] );
            if( !$prop )
                $value['proportion'] = '';
            else
                $value['proportion'] = $prop; // cleaned value

            $width          = MTT_Plugin_Utils::validate_css_px_percent( $value['width'] );
            if( !$width )
                $value['width'] = '';
            else
                $value['width'] = $width; // cleaned value

            return $value;
        }

        public function validate_html( $value )
        {
            if( isset( $value['dashboard_mtt1_content'] ) )
                $value['dashboard_mtt1_content'] = esc_html( stripslashes( $value['dashboard_mtt1_content'] ) );

            if( isset( $value['dashboard_mtt2_content'] ) )
                $value['dashboard_mtt2_content'] = esc_html( stripslashes( $value['dashboard_mtt2_content'] ) );

            if( isset( $value['dashboard_mtt3_content'] ) )
                $value['dashboard_mtt3_content'] = esc_html( stripslashes( $value['dashboard_mtt3_content'] ) );

            return $value;
        }
    }

    
endif;