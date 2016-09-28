<?php
/*
Plugin Name: AIT SysInfo
Description: Generates useful system information report about your WordPress website for AIT team
Version: 1.0.1
Author: AitThemes.Club
Author URI: https://www.ait-themes.club
Text Domain: ait-sysinfo
*/

define('AIT_SYSINFO_VERSION', '1.0.1');

require_once dirname(__FILE__) . '/AitSysInfoReporter.php';
require_once dirname(__FILE__) . '/AitSysInfo.php';


AitSysInfo::getInstance()->run();
