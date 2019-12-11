<?php

namespace ContractorStopwatch;

use phpDocumentor\Reflection\Types\Integer;

class WooImporter{

    public $data = array();
    public $rate;

    public function createOrder(){

        global $woocommerce;
        $output = "";
        $data = $this->data;
        $rate = $this->rate;
        $order = wc_create_order();
        for ($i = 0; $i < count($data); $i++) {
            $item_fee = new \WC_Order_Item_Fee();
            $item_fee->set_name(($this->computeLineItem($data[$i], $data[($i+1)], $rate))); // Generic fee name
            $item_fee->set_total(699); // Fee amount
            $order->add_item($item_fee);
            $order->calculate_totals();
            $order->update_status('on-hold');
            $order->save();
            $i++;
        }
        return $output;
    }

    public function computeLineItem($start, $end, $rate){
        $start = gmdate("Y-m-d\TH:i:s\Z", $start);
        $end = gmdate("Y-m-d\TH:i:s\Z", $end);
        $output = "$start - $end @ $$rate/hr";
        return $output;
    }

}