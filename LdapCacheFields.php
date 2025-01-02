<?php
/**
 * LdapCacheFields Plugin for MantisBT
 * @link https://github.com/Association-cocktail/LdapCacheFields
 *
 * @author    Marc-Antoine TURBET-DELOF<marc-antoine.turbet-delof@asso-cocktail.fr>
 * @copyright Copyright (c) 2020 Association Cocktail, Marc-Antoine TURBET-DELOF
 */

class LdapCacheFieldsPlugin extends MantisPlugin {
	/**
	 * A method that populates the plugin information and minimum requirements.
	 * @return void
	 */
	function register() {
		$this->name = plugin_lang_get( 'title' );    # Proper name of plugin
		$this->description = plugin_lang_get( 'description' );    # Short description of the plugin
		$this->page = 'config_page';           # Default plugin page

		$this->version = '0.5';     # Plugin version string
		$this->requires = array(    # Plugin dependencies
		    'MantisCore' => '2.28',  # Should always depend on an appropriate
		                            # version of MantisBT
		);

		$this->author = 'Association Cocktail';         # Author/team name
		$this->contact = 'resp-infra@asso-cocktail.fr';        # Author/team e-mail address
		$this->url = 'https://asso-cocktail.fr';            # Support webpage
    }

	function hooks() {
        return array(
            'EVENT_LDAP_CACHE_ATTRS' => 'fields'
        );
    }

	function schema() {
		return array(
            array('CreateTableSQL',
                array( plugin_table('field', 'LdapCacheFields'), "
                    id                 I       NOTNULL UNSIGNED AUTOINCREMENT PRIMARY,
                    title              C(32)   NOTNULL DEFAULT '',
                    name               C(32)   NOTNULL DEFAULT ''"
                )
            )
		);
	}

	function fields( $p_event ) {
		$t_field_table = plugin_table('field');
		$t_fields_array = array();
		$t_query = "SELECT name
		            FROM $t_field_table";
		$t_result = db_query($t_query);
		while( $t_row = db_fetch_array( $t_result ) ) {
			array_push( $t_fields_array, $t_row['name'] );
		}
		return $t_fields_array;
	}

}

