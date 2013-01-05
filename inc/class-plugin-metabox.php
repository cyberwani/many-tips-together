<?php
!defined( 'ABSPATH' ) AND exit;

/**
 * Plugin Meta Box
 * version 2012.13.02
 */
if( !class_exists( 'MTT_Plugin_Meta_Box' ) ):

    class MTT_Plugin_Meta_Box
    {

        public function mtt_meta_box()
        {
            $logo         = MTT_Plugin_Init::get_url() . 'images/mtt-logo.png';
            $mtt_tb_title = MTT_Plugin_Init::$mtt_tb_title;
            $version      = MTT_Plugin_Init::$version;
            $multisite   = is_multisite() 
                ? ( is_super_admin() ) 
                : true;
            ?>

            <script>
                            
            </script>
            <div class="mtt-box">
                <div class="inner">
                    <div id="icon-options-mtt" class="icon32">
                        <a href="http://www.rodbuaiz.com">
                            <img src="<?php echo $logo; ?>" alt="rodbuaiz.com" title="rodbuaiz.com"/>
                        </a>
                    </div>
                    <h2>Many Tips Together<br/>
                        <em style="font-size:.5em;"><?php _e( 'version', 'mtt' ); ?> 
                            <?php if( $multisite ): ?>
                            <a id="open-tb" class="thickbox" title="<?php echo "Many Tips Together " . __( 'version', 'mtt' ) . $version; ?>" href="javascript:void(0);">
                            <?php endif; ?>
                                <?php echo $version; ?>
                            <?php if( $multisite ): ?>
                            </a>
                            <?php endif; ?>
                        </em>

                    </h2>
                    <ul class="left hl" style="margin: -12px 0 6px 0;text-align: right;">
                        <li id="bsf-link"><?php _e( "by", 'mtt' ); ?> brasofilo</li>
                    </ul>
                    <?php MTT_Plugin_Utils::print_repository_info(); ?>
                    <hr style="opacity:.3"/>

                    <br style="clear:both"/>

                    <label for="mtt_verbose_plugin_helper" class="no-class">
                        <input name="mtt_verbose_plugin_helper" id="mtt_verbose_plugin_helper" type="checkbox" class="no-toggle"> <?php _e( 'Hide all help tabs', 'mtt' ); ?>
                    </label>

                    <p class="desc-field">
                        <span style="color:#C5C5C5">
                            <?php _e( '(some settings need a second refresh<br />for being visible)', 'mtt' ); ?>
                        </span>
                    </p>
                    <br style="clear:both"/>


                    <div class="submit update-button mtt-update">
                        <button class="button-primary" id="mtt-submit" title="<?php _e( 'Update settings', 'mtt' ) ?>"/><?php _e( 'Update settings', 'mtt' ) ?></button>
                    </div>

                    <br style="clear:both"/>


                </div>


                <?php
                if( isset( $_POST['action'] ) && $_POST['action'] == 'save' )
                {
                    echo '<div id="alert_bar" class="footer">';
                    echo '<script type="text/javascript">jQuery(document).ready(function ($) {close_update_msg();});</script>';
                    echo '<p><strong>' . __( 'Settings updated.', 'mtt' ) . '</strong></p></div>';
                }
                /*
                  if ( $msg_revisions == 'yes' )
                  {
                  echo '<script type="text/javascript">jQuery(document).ready( function($) {	$("#alert_bar").slideDown(); window.setTimeout(function(){$("#alert_bar").slideUp()},7500);});</script>';
                  ?>
                  <p><strong><?php _e( 'Revisions deleted from database.', 'mtt' ); ?></strong></p><?php
                  }

                  if ( $msg_reset == 'yes' )
                  {
                  echo '<script type="text/javascript">jQuery(document).ready( function($) {	$("#alert_bar").slideDown(); window.setTimeout(function(){$("#alert_bar").slideUp()},7500);});</script>';
                  ?>
                  <p><strong><?php _e( 'Settings reset.', 'mtt' ); ?></strong></p><?php
                  }
                  ?>
                  </div> */
                ?>
                <div class="footer">

                    <ul class="right hl">
                        <li><a href="http://wordpress.org/extend/plugins/many-tips-together/"
                               target="_blank"><?php _e( "Rate this plugin in wordpress.org", 'mtt' ); ?></a></li>
                    </ul>
                </div>
            </div>
            <?php
        }


    }

    

    endif;


