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

$WooImporter = new WooImporter;
