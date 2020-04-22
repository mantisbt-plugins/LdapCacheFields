<?php
/**
 * LdapCacheFields Plugin for MantisBT
 * @link https://github.com/Association-cocktail/LdapCacheFields
 *
 * @author    Marc-Antoine TURBET-DELOF<marc-antoine.turbet-delof@asso-cocktail.fr>
 * @copyright Copyright (c) 2020 Association Cocktail, Marc-Antoine TURBET-DELOF
 */

form_security_validate( 'plugin_LdapCacheFields_config_edit' );

auth_reauthenticate( );

$f_submit_type = gpc_get_string( 'submit' );
$t_field_table = plugin_table( 'field' );
$t_rows_affected = 0;

if( $f_submit_type == plugin_lang_get( 'config_new_field' ) ) {
    $f_field_name = gpc_get_string( 'field_name' );
    $f_field_title = gpc_get_string( 'field_title' );
    $t_query = "INSERT INTO $t_field_table (title, name)
				VALUES (?, ?)";
    $t_result = db_query( $t_query, array( trim( $f_field_title ), trim( $f_field_name ) ) );
    $t_rows_affected = db_num_rows( $t_result );
} else if( $f_submit_type == plugin_lang_get( 'config_save_field' ) ) {
    $f_field_id    = gpc_get_string( 'field_id' );
    $f_field_name  = gpc_get_string( 'field_name' );
    $f_field_title = gpc_get_string( 'field_title' );
    $t_query = "UPDATE $t_field_table
				SET title=?,
					name=?
				WHERE id=?";
    $t_result = db_query( $t_query, array( trim( $f_field_title ), trim( $f_field_name ), $f_field_id ) );
    $t_rows_affected = db_num_rows( $t_result );
} else if( $f_submit_type == plugin_lang_get( 'config_delete_field' ) ) {
    $f_field_id    = gpc_get_string( 'field_id' );
    $f_field_name  = gpc_get_string( 'field_name' );
    $f_field_title = gpc_get_string( 'field_title' );
    $t_query = "DELETE FROM $t_field_table
				WHERE id=?";
    $t_result = db_query( $t_query, array( $f_field_id ) );
    $t_rows_affected = db_num_rows( $t_result );
} else {
    trigger_error(ERROR_INVALID_REQUEST_METHOD, ERROR );
}

# FIXME : allways 0
#if( $t_rows_affected == 0 ) {
#    trigger_error(ERROR_DB_QUERY_FAILED, ERROR );
#}

form_security_purge( 'plugin_LdapCacheFields_config_edit' );

$t_redirect_url = plugin_page( 'config_page', TRUE );

layout_page_header( null, $t_redirect_url );
layout_page_begin( );
html_operation_successful( $t_redirect_url );
layout_page_end( );

