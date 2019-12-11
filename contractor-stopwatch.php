<?php
/**
 * Plugin Name:       Contractor Stopwatch
 * Plugin URI:        https://generalchicken.net/clock
 * Description:
 * Version:           1.1
 * Author:            John Dee
 * Author URI:
 * Text Domain:
 */

namespace ContractorStopwatch;

//die("main plugin page!");

require_once (plugin_dir_path(__FILE__). 'src/ContractorStopwatch/autoloader.php');


$Shortcode = new Shortcode;
$Shortcode->enableShortcodeFeature();

$Api = new Api;
$Api->enableApiRoutes();

if(isset($_GET['test'])){
    $WooImporter = new WooImporter;
    $data = array(1576022314522,1576022319135,1576022319948,1576022322200,1576022324762,1576022326559);
    $rate = 11;
    $WooImporter->data = $data;
    $WooImporter->rate = $rate;
    add_action('init', array($WooImporter, 'createOrder'));
}