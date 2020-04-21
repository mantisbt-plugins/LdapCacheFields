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

		$this->version = '0.1';     # Plugin version string
		$this->requires = array(    # Plugin dependencies
		    'MantisCore' => '2.24',  # Should always depend on an appropriate
		                            # version of MantisBT
		);

		$this->author = 'Association Cocktail';         # Author/team name
		$this->contact = 'resp-infra@asso-cocktail.fr';        # Author/team e-mail address
		$this->url = 'https://asso-cocktail.fr';            # Support webpage
    }

	public function config() {
		return array(
			'fields' => plugin_lang_get( 'default_fields' ),
		);
	}

	function hooks() {
        return array(
            'EVENT_LDAP_USER_FIELDS' => 'fields',
			'EVENT_USER_ADDITIONAL_ATTRIBUTES' => 'display'
        );
    }

	function fields( $p_event ) {
		$t_fields_string = plugin_config_get( 'fields' );
		$t_fields_array = array();

		$t_fields_array = explode( ',', $t_fields_string );
		return array_map( 'trim', $t_fields_array );
	}

	function display( $p_event, $p_username ) {
		foreach ( $this->fields( '' ) as $ldap_field ) {
			echo '<tr><th class="category">' . $ldap_field . '</th><td>' . ldap_get_field_from_username( $p_username, $ldap_field ) . '</td></tr>';
		}
	}
}

