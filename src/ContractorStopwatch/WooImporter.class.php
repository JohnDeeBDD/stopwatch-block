<?php

namespace ContractorStopwatch;

class WooImporter {
    
}

/*
$order->set_date_created($creation_tsz);

$order->set_address( $address, 'billing' );
$order->set_address( $address, 'shipping' );
$order->set_currency('GBP');

## ------------- ADD FEE PROCESS ---------------- ##

// Get the customer country code
$country_code = $order->get_shipping_country();

// Set the array for tax calculations
$calculate_tax_for = array(
'country' => $country_code,
'state' => '',
'postcode' => '',
'city' => ''
);

// Get a new instance of the WC_Order_Item_Fee Object
$item_fee = new WC_Order_Item_Fee();

$item_fee->set_name( "Fee" ); // Generic fee name
$item_fee->set_amount( $imported_total_fee ); // Fee amount
$item_fee->set_tax_class( '' ); // default for ''
$item_fee->set_tax_status( 'taxable' ); // or 'none'
$item_fee->set_total( $imported_total_fee ); // Fee amount

// Calculating Fee taxes
$item_fee->calculate_taxes( $calculate_tax_for );

// Add Fee item to the order
$order->add_item( $item_fee );

## ----------------------------------------------- ##

$order->calculate_totals();

$order->update_status('on-hold');

$order->save();
*/