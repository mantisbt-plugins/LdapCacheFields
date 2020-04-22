<?php
/**
 * LdapCacheFields Plugin for MantisBT
 * @link https://github.com/Association-cocktail/LdapCacheFields
 *
 * @author    Marc-Antoine TURBET-DELOF<marc-antoine.turbet-delof@asso-cocktail.fr>
 * @copyright Copyright (c) 2020 Association Cocktail, Marc-Antoine TURBET-DELOF
 */

auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

layout_page_header( plugin_lang_get( 'title' ) );

layout_page_begin( 'manage_overview_page.php' );
print_manage_menu( 'manage_plugin_page.php' );

$t_field_table = plugin_table('field');

$t_form_security_field  = form_security_field( 'plugin_LdapCacheFields_config_edit' );
?>

<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="form-container" >

	<form id="newfield-form" method="post" action="<?php echo plugin_page('config_edit') ?>">
	    <?php echo $t_form_security_field ?>
	    <div class="widget-box widget-color-blue2">
	        <div class="widget-header widget-header-small">
	            <h4 class="widget-title lighter">
	                <i class="ace-icon fa fa-plus"></i>
	                <?php echo plugin_lang_get('title') . ': ' . plugin_lang_get('config_new_field') ?>
	            </h4>
	        </div>
	        <div class="widget-body">
	            <div class="widget-main no-padding">
	                <div class="form-container">
	                    <div class="table-responsive">
	                        <table class="table table-bordered table-condensed table-striped">
	                            <tr>
	                                <td class="category">
	                                    <?php echo plugin_lang_get('new_field_title') ?>
	                                </td>
	                                <td>
	                                    <input name="field_title" maxlength="30" size="30" value="" />
	                                </td>
	                            </tr>
	                            <tr>
	                                <td class="category">
	                                    <?php echo plugin_lang_get('new_field_name') ?>
	                                </td>
	                                <td>
	                                    <input name="field_name" maxlength="30" size="30" value="" />
	                                </td>
	                            </tr>
	                        </table>
	                    </div>
	                </div>
	            </div>
	
	            <div class="widget-toolbox padding-8 clearfix">
	                <input type="submit" name="submit" class="btn btn-primary btn-white btn-round" value="<?php echo plugin_lang_get('config_new_field') ?>" />
	            </div>
	
	        </div>
	    </div>
	</form>
	<br><br>
        <div class="widget-box widget-color-blue2">
            <div class="widget-header widget-header-small">
                <h4 class="widget-title lighter">
                    <i class="ace-icon fa fa-th-list"></i>
                    <?php echo plugin_lang_get('title') . ': ' . plugin_lang_get('config_existing') ?>
                </h4>
            </div>
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <div class="form-container">
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed table-striped">

                                <tr>
                                    <th><?php echo plugin_lang_get( 'config_field_title' ); ?></th>
                                    <th><?php echo plugin_lang_get( 'config_field_name' ); ?></th>
                                    <th><?php echo plugin_lang_get( 'config_field_action' ); ?></th>
                                </tr>

                                <?php
                                $i = 0;
                                $t_query = "SELECT id, title, name
											FROM $t_field_table";
                                $t_result = db_query($t_query);
                                while( $t_row = db_fetch_array( $t_result ) ) {
                                    $i++;
                                    extract( $t_row, EXTR_PREFIX_ALL, 'v' );
									$v_id    = string_display_line( $v_id );
                                    $v_title = string_display_line( $v_title );
                                    $v_name  = string_display_line( $v_name );
                                ?>
                                <form id="editfield-form-<?php echo $v_id; ?>" method="post" action="<?php echo plugin_page('config_edit') ?>">
                                    <?php echo $t_form_security_field ?>
                                    <tr>
                                        <input type="hidden" name="field_id" value="<?php echo $v_id; ?>" />
                                        <td>
                                            <input name="field_title" maxlength="30" size="30" value="<?php echo $v_title; ?>" />
                                        </td>
                                        <td>
                                            <input name="field_name"  maxlength="30" size="30" value="<?php echo $v_name;  ?>" />
                                        </td>
                                        <td>
                                            <span class="pull-right">
                                            <?php
                                                echo '<input type="submit" name="submit" class="btn btn-primary btn-white btn-round btn-xs" value="' . plugin_lang_get('config_save_field') . '" />';
                                                echo '&#160;';
                                                echo '<input type="submit" name="submit" class="btn btn-primary btn-white btn-round btn-xs" value="' . plugin_lang_get('config_delete_field') . '" />';
                                            ?>
                                            </span>
                                        </td>
                                    </tr>
                                </form>
                                <?php
                                } # end for loop

                                if( $i == 0 ) {
                                    echo '<tr><td colspan="2">'. plugin_lang_get('no_fields_configured').'</td></tr>';
                                } ?>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="widget-toolbox padding-8 clearfix"></div>
            </div>
        </div>
    </div>
    <div class="space-10"></div>
</div>


<?php
layout_page_end();

