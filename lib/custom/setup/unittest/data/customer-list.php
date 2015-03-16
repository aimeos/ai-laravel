<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */

return array (
	'customer/list/type' => array (
		'text/default' => array( 'domain' => 'text', 'code' => 'default', 'label' => 'Default', 'status' => 1 ),
	),

	'customer/list' => array (
		array( 'parentid' => 'customer/unitCustomer3@aimeos.org', 'typeid' => 'text/default', 'domain' => 'text', 'refid' => 'text/customer/information', 'start' => '2010-01-01 00:00:00', 'end' => '2100-01-01 00:00:00', 'config' => array(), 'pos' => 0, 'status' => 1 ),
		array( 'parentid' => 'customer/unitCustomer3@aimeos.org', 'typeid' => 'text/default', 'domain' => 'text', 'refid' => 'text/customer/notify', 'start' => '2010-01-01 00:00:00', 'end' => '2100-01-01 00:00:00', 'config' => array(), 'pos' => 1, 'status' => 1 ),
		array( 'parentid' => 'customer/unitCustomer3@aimeos.org', 'typeid' => 'text/default', 'domain' => 'text', 'refid' => 'text/customer/newsletter', 'start' => '2010-01-01 00:00:00', 'end' => '2100-01-01 00:00:00', 'config' => array(), 'pos' => 2, 'status' => 1 ),
		array( 'parentid' => 'customer/unitCustomer1@aimeos.org', 'typeid' => 'text/default', 'domain' => 'text', 'refid' => 'text/customer/information', 'start' => '2010-01-01 00:00:00', 'end' => '2100-01-01 00:00:00', 'config' => array(), 'pos' => 3, 'status' => 1 ),
	),
);