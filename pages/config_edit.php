<?php
/**
 * LdapCacheFields Plugin for MantisBT
 * @link https://github.com/Association-cocktail/LdapCacheFields
 *
 * @author    Marc-Antoine TURBET-DELOF<marc-antoine.turbet-delof@asso-cocktail.fr>
 * @copyright Copyright (c) 2020 Association Cocktail, Marc-Antoine TURBET-DELOF
 */

form_security_validate( 'plugin_ldap_cache_fields_config_edit' );

auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$t_reset_fields = gpc_get_bool( 'reset', false );

if( $t_reset_fields ) {
    $t_new_fields = plugin_lang_get( 'default_fields' );
} else {
    $t_new_fields = gpc_get_string( 'fields' );
}

if( plugin_config_get( 'fields' ) != $t_new_fields ) {
    plugin_config_set( 'fields', $t_new_fields );
}


form_security_purge( 'plugin_ldap_cache_fields_config_edit' );

print_successful_redirect( plugin_page( 'config_page', true ) );

