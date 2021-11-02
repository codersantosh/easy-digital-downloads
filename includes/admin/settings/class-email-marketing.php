<?php
/**
 * Email Marketing
 *
 * Manages automatic installation/activation for email marketing extensions.
 *
 * @package     EDD
 * @subpackage  EmailMarketing
 * @copyright   Copyright (c) 2021, Easy Digital Downloads
 * @license     https://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.11.x
 */
namespace EDD\Admin\Settings;

class EmailMarketing extends Extension {

	/**
	 * The pass level required to automatically download this extension.
	 */
	const PASS_LEVEL = \EDD\Admin\Pass_Manager::PERSONAL_PASS_ID;

	public function __construct() {
		add_filter( 'edd_settings_sections_marketing', array( $this, 'add_section' ) );
		add_action( 'edd_settings_tab_top_marketing_email_marketing', array( $this, 'field' ) );

		parent::__construct();
	}

	/**
	 * Gets the configuration for Recurring.
	 *
	 * @return array
	 */
	protected function get_configuration( $item_id = false ) {
		$extensions = array(
			648002 => array(
				'item_id'    => 648002,
				'name'       => __( 'ConvertKit', 'easy-digital-downloads' ),
				'pro_plugin' => 'edd-convertkit/edd-convertkit.php',
				'tab'        => 'marketing',
				'section'    => 'convertkit',
			),
			22583  => array(
				'item_id'    => 22583,
				'name'       => __( 'ActiveCampaign', 'easy-digital-downloads' ),
				'pro_plugin' => 'edd-activecampaign/edd-activecampaign.php',
				'tab'        => 'marketing',
				'section'    => 'activecampaign',
			),
			3318   => array(
				'item_id'    => 3318,
				'name'       => __( 'Mad Mimi', 'easy-digital-downloads' ),
				'pro_plugin' => 'edd-madmimi/edd-madmimi.php',
				'tab'        => 'marketing',
				'section'    => 'mad-mimi',
			),
		);

		return $item_id ? $extensions[ $item_id ] : $extensions;
	}

	/**
	 * Adds an email marketing section to the Marketing tab.
	 *
	 * @param array $sections
	 * @return array
	 */
	public function add_section( $sections ) {
		if ( $this->is_activated() ) {
			return $sections;
		}

		$sections['email_marketing'] = __( 'Email Marketing', 'easy-digital-downloads' );

		return $sections;
	}

	/**
	 * Adds the email marketing extensions as cards.
	 *
	 * @return void
	 */
	public function field() {
		$config = $this->get_configuration();
		?>
		<div class="edd-extension-manager__card-group">
			<?php
			foreach ( $config as $item_id => $extension ) {
				$this->do_single_extension_card( $item_id );
			}
			?>
		</div>
		<style>p.submit{display:none;}</style>
		<?php
	}

	/**
	 * Whether any email marketing extension is active.
	 *
	 * @since 2.11.x
	 *
	 * @return bool True if any email marketing extension is active.
	 */
	protected function is_activated() {
		$config = $this->get_configuration();
		foreach ( $config as $extension ) {
			if ( is_plugin_active( $extension['pro_plugin'] ) ) {
				return true;
			}
		}

		return false;
	}
}

new EmailMarketing();
