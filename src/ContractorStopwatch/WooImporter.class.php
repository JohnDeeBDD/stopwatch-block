<?php

namespace ContractorStopwatch;

use phpDocumentor\Reflection\Types\Integer;

class WooImporter{

    public $data = array();
    public $rate;

    public function listenForNewOrder(){
        if(isset($_GET['create-woo-stopwatch-order'])){
            add_action('init', array($this, "authAndRouteSubmission"));
        }
    }

    public function authAndRouteSubmission(){
        $postID = $_GET['create-woo-stopwatch-order'];

        if(current_user_can( 'edit_post', $postID )){
            $data = get_post_meta($postID, "stopwatchData", true);
            $this->data = json_decode( $data);
            $this->rate = get_post_meta($postID, "rate", TRUE);
            $orderID = $this->createOrder();
        }else{
            die('something is wrong!');
        }
        wp_safe_redirect( "/wp-admin/post.php?post=$orderID&action=edit");
        exit;
    }

    public function createOrder(){

        global $woocommerce;

        $data = $this->data;
        $rate = $this->rate;
        $order = wc_create_order();

        //var_dump($orderID);die();
        for ($i = 0; $i < count($data); $i++) {
            $item_fee = new \WC_Order_Item_Fee();
            $item_fee->set_name(($this->computeLineItem($data[$i], $data[($i+1)], $rate))); // Generic fee name
            $item_fee->set_total(($this->computeLineFee($data[$i], $data[($i+1)], $rate)));
            $order->add_item($item_fee);
            $order->calculate_totals();
            $order->update_status('on-hold');
            $order->save();
            $i++;
        }
        return ($order->get_order_number());
    }

    public function computeLineFee($start, $end, $rate){
        $start = round($start /  1000);
        $end = round ($end / 1000);
        $time = (($end - $start) / 3600);
        return ($time * $rate);
    }

    public function computeLineItem($start, $end, $rate){
        $start = round($start /  1000);
        $end = round ($end / 1000);
        $start = gmdate("Y-m-d\TH:i:s\Z", $start);
        $end = gmdate("Y-m-d\TH:i:s\Z", $end);
        $output = "$start - $end @ $$rate/hr";
        return $output;
    }

}