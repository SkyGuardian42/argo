<?php
/**
 * Plugin Name: GitHub-CD
 * Description: Automatic Theme Deployment using Github Actions
 * Version:     1.10.3
 */

/**
 * Generated by the WordPress Option Page generator
 * at http://jeremyhixon.com/wp-tools/option-page/
 */

class GitCDSettings {
	private $git_cd_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'git_cd_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'git_cd_settings_page_init' ) );
	}

	public function git_cd_settings_add_plugin_page() {
		add_options_page(
			'Git CD Settings', // page_title
			'Git CD Settings', // menu_title
			'manage_options', // capability
			'git-cd-settings', // menu_slug
			array( $this, 'git_cd_settings_create_admin_page' ) // function
		);
	}

	public function git_cd_settings_create_admin_page() {
		$this->git_cd_settings_options = get_option( 'git_cd_settings_option_name' ); ?>

		<div class="wrap">
			<h2>Git CD Settings</h2>
			<p>Set settings for Git CD</p>
			<?php //settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'git_cd_settings_option_group' );
					do_settings_sections( 'git-cd-settings-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function git_cd_settings_page_init() {
		register_setting(
			'git_cd_settings_option_group', // option_group
			'git_cd_settings_option_name', // option_name
			array( $this, 'git_cd_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'git_cd_settings_setting_section', // id
			'Settings', // title
			array( $this, 'git_cd_settings_section_info' ), // callback
			'git-cd-settings-admin' // page
		);

		add_settings_field(
			'zip_url_0', // id
			'Zip URL', // title
			array( $this, 'zip_url_0_callback' ), // callback
			'git-cd-settings-admin', // page
			'git_cd_settings_setting_section' // section
		);
	}

	public function git_cd_settings_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['zip_url_0'] ) ) {
			$sanitary_values['zip_url_0'] = sanitize_text_field( $input['zip_url_0'] );
		}

		return $sanitary_values;
	}

	public function git_cd_settings_section_info() {
		
	}

	public function zip_url_0_callback() {
		printf(
			'<input class="regular-text" type="url" name="git_cd_settings_option_name[zip_url_0]" id="zip_url_0" value="%s">',
			isset( $this->git_cd_settings_options['zip_url_0'] ) ? esc_attr( $this->git_cd_settings_options['zip_url_0']) : ''
		);
	}

}
if ( is_admin() )
	$git_cd_settings = new GitCDSettings();

/* 
 * Retrieve this value with:
 * $git_cd_settings_options = get_option( 'git_cd_settings_option_name' ); // Array of All Options
 * $zip_url_0 = $git_cd_settings_options['zip_url_0']; // Zip URL
 */
