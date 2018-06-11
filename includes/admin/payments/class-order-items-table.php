<?php
/**
 * Order Items Table Class
 *
 * @package     EDD
 * @subpackage  Admin/Discounts
 * @copyright   Copyright (c) 2018, Pippin Williamson
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

// Load WP_List_Table if not loaded
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * EDD_Order_Item_Table Class
 *
 * Renders the Order Items table on the Order Items page
 *
 * @since 3.0
 */
class EDD_Order_Item_Table extends WP_List_Table {

	/**
	 * Number of results to show per page
	 *
	 * @var string
	 * @since 3.0
	 */
	public $per_page = 30;

	/**
	 * Discount counts, keyed by status
	 *
	 * @var array
	 * @since 3.0
	 */
	public $counts = array(
		'active'   => 0,
		'inactive' => 0,
		'expired'  => 0,
		'total'    => 0
	);

	/**
	 * Get things started
	 *
	 * @since 3.0
	 * @see WP_List_Table::__construct()
	 */
	public function __construct() {
		parent::__construct( array(
			'singular' => __( 'Order Item',  'easy-digital-downloads' ),
			'plural'   => __( 'Order Items', 'easy-digital-downloads' ),
			'ajax'     => false,
		) );

		$this->process_bulk_action();
		$this->get_counts();
	}

	/**
	 * Show the search field
	 *
	 * @access public
	 * @since 3.0
	 *
	 * @param string $text Label for the search box
	 * @param string $input_id ID of the search box
	 */
	public function search_box( $text, $input_id ) {

		// Bail if no customers and no search
		if ( empty( $_REQUEST['s'] ) && ! $this->has_items() ) {
			return;
		}

		$input_id = $input_id . '-search-input';

		if ( ! empty( $_REQUEST['orderby'] ) ) {
			echo '<input type="hidden" name="orderby" value="' . esc_attr( $_REQUEST['orderby'] ) . '" />';
		}

		if ( ! empty( $_REQUEST['order'] ) ) {
			echo '<input type="hidden" name="order" value="' . esc_attr( $_REQUEST['order'] ) . '" />';
		}

		?>

        <p class="search-box">
            <label class="screen-reader-text" for="<?php echo esc_attr( $input_id ) ?>"><?php echo esc_html( $text ); ?>:</label>
            <input type="search" id="<?php echo esc_attr( $input_id ); ?>" name="s" value="<?php _admin_search_query(); ?>"/>
			<?php submit_button( esc_html( $text ), 'button', false, false, array( 'ID' => 'search-submit' ) ); ?>
        </p>

		<?php
	}

	/**
	 * Get the base URL for the order_item list table
	 *
	 * @since 3.0
	 *
	 * @return string
	 */
	public function get_base_url() {

		// Remove some query arguments
		$base = remove_query_arg( edd_admin_removable_query_args(), admin_url( 'edit.php' ) );

		$id = isset( $_GET['id'] )
			? absint( $_GET['id'] )
			: 0;

		// Add base query args
		return add_query_arg( array(
			'post_type' => 'download',
			'page'      => 'edd-payment-history',
			'view'      => 'view-order-details',
			'id'        => $id
		), $base );
	}

	/**
	 * Retrieve the view types
	 *
	 * @access public
	 * @since 3.0
	 *
	 * @return array $views All the views available
	 */
	public function get_views() {
		return array();
	}

	/**
	 * Retrieve the table columns
	 *
	 * @access public
	 * @since 3.0
	 *
	 * @return array $columns Array of all the list table columns
	 */
	public function get_columns() {
		return array(
			'cb'       => '<input type="checkbox" />',
			'name'     => __( 'Product',  'easy-digital-downloads' ),
			'status'   => __( 'Status',   'easy-digital-downloads' ),
			'quantity' => __( 'Quantity', 'easy-digital-downloads' ),
			'amount'   => __( 'Amount',   'easy-digital-downloads' )
		);
	}

	/**
	 * Retrieve the sortable columns
	 *
	 * @access public
	 * @since 3.0
	 *
	 * @return array Array of all the sortable columns
	 */
	public function get_sortable_columns() {
		return array(
			'name'     => array( 'product_name',  false ),
			'status'   => array( 'status',        false ),
			'quantity' => array( 'quantity',      false ),
			'amount'   => array( 'amount',        false )
		);
	}

	/**
	 * Gets the name of the primary column.
	 *
	 * @since 2.5
	 * @access protected
	 *
	 * @return string Name of the primary column.
	 */
	protected function get_primary_column_name() {
		return 'name';
	}

	/**
	 * This function renders most of the columns in the list table.
	 *
	 * @access public
	 * @since 3.0
	 *
	 * @param EDD_Order_Item $order_item Discount object.
	 * @param string $column_name The name of the column
	 *
	 * @return string Column Name
	 */
	public function column_default( $order_item, $column_name ) {
		return property_exists( $order_item, $column_name )
			? $order_item->{$column_name}
			: '';
	}

	/**
	 * This function renders the amount column.
	 *
	 * @access public
	 * @since 3.0
	 *
	 * @param EDD_Order_Item $order_item Data for the order_item code.
	 * @return string Formatted amount.
	 */
	public function column_amount( $order_item ) {
		$currency = edd_get_order( $order_item->order_id )->currency;

		return edd_currency_symbol( $currency ) . edd_format_amount( $order_item->amount );
	}

	/**
	 * Render the Name Column
	 *
	 * @access public
	 * @since 3.0
	 *
	 * @param EDD_Order_Item $order_item Discount object.
	 * @return string Data shown in the Name column
	 */
	public function column_name( $order_item ) {
		$base         = $this->get_base_url();
		$status       = strtolower( $order_item->status );
		$row_actions  = array();

		// Edit
		$row_actions['edit'] = '<a href="' . add_query_arg( array(
			'edd-action' => 'edit_order_item',
			'order_item' => $order_item->id,
		), $base ) . '">' . __( 'Edit', 'easy-digital-downloads' ) . '</a>';

		// Active, so add "deactivate" action
		if ( empty( $status ) ) {
			$row_actions['complete'] = '<a href="' . esc_url( wp_nonce_url( add_query_arg( array(
				'edd-action' => 'complete_order_item',
				'order_item' => $order_item->id,
			), $base ), 'edd_order_item_nonce' ) ) . '">' . __( 'Complete', 'easy-digital-downloads' ) . '</a>';

		} elseif ( 'publish' === $status ) {

			if ( edd_get_download_files( $order_item->id, $order_item->price_id ) ) {
				$row_actions['copy'] = '<span class="edd-copy-download-link-wrapper"><a href="" class="edd-copy-download-link" data-download-id="' . esc_attr( $order_item->id ) . '" data-price-id="' . esc_attr( $order_item->id ) . '">' . __( 'Link', 'easy-digital-downloads' ) . '</a>';
			}

			$row_actions['refund'] = '<a href="' . esc_url( wp_nonce_url( add_query_arg( array(
				'edd-action' => 'refund_order_item',
				'order_item' => $order_item->id,
			), $base ), 'edd_order_item_nonce' ) ) . '">' . __( 'Refund', 'easy-digital-downloads' ) . '</a>';

		// Inactive, so add "activate" action
		} elseif ( 'refunded' === $status ) {
			$row_actions['activate'] = '<a href="' . esc_url( wp_nonce_url( add_query_arg( array(
				'edd-action' => 'publish_order_item',
				'order_item' => $order_item->id,
			), $base ), 'edd_order_item_nonce' ) ) . '">' . __( 'Put Back', 'easy-digital-downloads' ) . '</a>';
		}

		// Delete
		$row_actions['remove'] = '<a href="' . esc_url( wp_nonce_url( add_query_arg( array(
			'edd-action' => 'remove_order_item',
			'order_item' => $order_item->id,
		), $base ), 'edd_order_item_nonce' ) ) . '">' . __( 'Remove', 'easy-digital-downloads' ) . '</a>';

		// Filter all order_item row actions
		$row_actions = apply_filters( 'edd_order_item_row_actions', $row_actions, $order_item );

		// Wrap order_item title in strong anchor
		$order_item_title = '<strong><a class="row-title" href="' . add_query_arg( array(
			'edd-action' => 'edit_order_item',
			'order_item' => $order_item->id,
		), $base ) . '">' . stripslashes( $order_item->product_name ) . '</a></strong>';

		// Return order_item title & row actions
		return $order_item_title . $this->row_actions( $row_actions );
	}

	/**
	 * Render the checkbox column
	 *
	 * @access public
	 * @since 3.0
	 *
	 * @param EDD_Order_Item $order_item Discount object.
	 *
	 * @return string Displays a checkbox
	 */
	public function column_cb( $order_item ) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/ 'order_item',
			/*$2%s*/ $order_item->id
		);
	}

	/**
	 * Render the status column
	 *
	 * @access public
	 * @since 3.0
	 *
	 * @param EDD_Order_Item $order_item Discount object.
	 *
	 * @return string Displays the order_item status
	 */
	public function column_status( $order_item ) {
		return ! empty( $order_item->status )
			? ucwords( $order_item->status )
			: '&mdash;';
	}

	/**
	 * Message to be displayed when there are no items
	 *
	 * @since 3.0
	 * @access public
	 */
	public function no_items() {
		_e( 'No order items found.', 'easy-digital-downloads' );
	}

	/**
	 * Retrieve the bulk actions
	 *
	 * @access public
	 * @since 3.0
	 * @return array $actions Array of the bulk actions
	 */
	public function get_bulk_actions() {
		return array(
			'refund' => __( 'Refund', 'easy-digital-downloads' ),
			'remove' => __( 'Remove', 'easy-digital-downloads' )
		);
	}

	/**
	 * Process the bulk actions
	 *
	 * @access public
	 * @since 3.0
	 */
	public function process_bulk_action() {
		if ( empty( $_REQUEST['_wpnonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'bulk-order_items' ) ) {
			return;
		}

		$ids = isset( $_GET['order_item'] )
			? $_GET['order_item']
			: false;

		if ( ! is_array( $ids ) ) {
			$ids = array( $ids );
		}

		foreach ( $ids as $id ) {
			switch ( $this->current_action() ) {
				case 'remove' :
					edd_delete_order_item( $id );
					break;
				case 'refund' :
					edd_update_order_item( $id, array(
						'status' => 'refunded'
					) );
					break;
				case 'complete' :
					edd_update_order_item( $id, array(
						'status' => 'publish'
					) );
					break;
			}
		}
	}

	/**
	 * Retrieve the order_item code counts
	 *
	 * @access public
	 * @since 3.0
	 */
	public function get_counts() {
		$this->counts = edd_get_order_item_counts( $_GET['id'] );
	}

	/**
	 * Retrieve all the data for all the order_item codes
	 *
	 * @access public
	 * @since 3.0
	 * @return array $order_items_data Array of all the data for the order_item codes
	 */
	public function order_items_data() {

		// Query args
		$orderby = isset( $_GET['orderby'] ) ? sanitize_key( $_GET['orderby']  ) : 'id';
		$order   = isset( $_GET['order']   ) ? sanitize_key( $_GET['order']    ) : 'DESC';
		$status  = isset( $_GET['status']  ) ? sanitize_key( $_GET['status']   ) : '';
		$search  = isset( $_GET['s']       ) ? sanitize_text_field( $_GET['s'] ) : null;
		$paged   = isset( $_GET['paged']   ) ? absint( $_GET['paged']          ) : 1;
		$id      = isset( $_GET['id']      ) ? absint( $_GET['id']             ) : 0;

		// Get order_items
		return edd_get_order_items( array(
			'order_id' => $id,
			'number'   => $this->per_page,
			'paged'    => $paged,
			'orderby'  => $orderby,
			'order'    => $order,
			'status'   => $status,
			'search'   => $search
		) );
	}

	/**
	 * Setup the final data for the table
	 *
	 * @access public
	 * @since 3.0
	 * @uses EDD_Order_Item_Table::get_columns()
	 * @uses EDD_Order_Item_Table::get_sortable_columns()
	 * @uses EDD_Order_Item_Table::order_items_data()
	 * @uses WP_List_Table::get_pagenum()
	 * @uses WP_List_Table::set_pagination_args()
	 */
	public function prepare_items() {
		$this->_column_headers = array(
			$this->get_columns(),
			array(),
			$this->get_sortable_columns()
		);

		$this->items = $this->order_items_data();

		$status = isset( $_GET['status'] )
			? sanitize_key( $_GET['status'] )
			: 'total';

		// Setup pagination
		$this->set_pagination_args( array(
			'total_items' => $this->counts[ $status ],
			'per_page'    => $this->per_page,
			'total_pages' => ceil( $this->counts[ $status ] / $this->per_page )
		) );
	}
}