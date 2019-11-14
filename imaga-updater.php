<?php
/**
 * Plugin Update Checker Library 4.7
 * http://w-shadow.com/
 *
 * Copyright 2019 Janis Elsts
 * Released under the MIT license. See license.txt for details.
 */

require dirname(__FILE__) . '/Puc/v4p7/Factory.php';
require dirname(__FILE__) . '/Puc/v4/Factory.php';
require dirname(__FILE__) . '/Puc/v4p7/Autoloader.php';
new Puc_v4p7_Autoloader();

foreach (
  array(
    'Plugin_UpdateChecker'    => 'Puc_v4p7_Plugin_UpdateChecker',
    'Vcs_PluginUpdateChecker' => 'Puc_v4p7_Vcs_PluginUpdateChecker',
    'GitHubApi'               => 'Puc_v4p7_Vcs_GitHubApi',
  )
  as $pucGeneralClass => $pucVersionedClass
) {
  Puc_v4_Factory::addVersion($pucGeneralClass, $pucVersionedClass, '4.7');
  Puc_v4p7_Factory::addVersion($pucGeneralClass, $pucVersionedClass, '4.7');
}
