/** 
 * Code goes in theme functions.php
 * Works with WooCommerce Bookings plugin
 * Creates a WooCommerce Order and a Booking to match
 * Data gotten from submitting a POST form
 * This is for a single item, for multiple cart items, move "create_wc_booking" into the get->items() loop and apply $order_item_id
 */

add_action('init', 'ta_WC_booking');
function ta_WC_booking() {
    
    if (isset($_POST["wc_booking"])) {
    
        $product_id = $_POST["product_id"];
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];
        $persons = $_POST["persons"];
        $cost = $_POST["cost"]; 

        $address = array(
            'first_name' => 'Tc',
            'last_name'  => 'Blaize',
            'company'    => 'Overflow',
            'email'      => 'jt.obiefule@hotmail.com',
            'phone'      => '777-777-777-777',
            'address_1'  => '35 Main Street',
            'address_2'  => '', 
            'city'       => 'Net York',
            'state'      => 'NY',
            'postcode'   => '2323',
            'country'    => 'US'
        );
        $order   = wc_create_order();
        $order->set_address( $address, 'billing' );
        $product = wc_get_product($product_id);
        $price = $cost;
        $order->add_product( $product, 1 );
        $order_id = $order->get_id();
        $order_item = $order->get_items();
        $order_item_id = 0;
        foreach ($order->get_items() as $item_id => $item) {
            $order_item_id = $item_id;
        }
        $order->set_total( $price );
        $user_ID = get_current_user_id();
        update_post_meta($order->id, '_customer_user', get_current_user_id() );
        $order->update_status( 'pending' );
      
        $new_booking_data = array(
            'start_date'  => strtotime($start_date),
            'end_date'    => strtotime($end_date),
            'order_item_id'    =>  $order_item_id
        );
        $new_booking_data['persons'] = $persons;

        create_wc_booking( 
            $product_id,
            $new_booking_data,
            'unpaid',
            false
        ); 

      }
    }
