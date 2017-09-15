<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2017
 */

return array (
	'customer/lists/type' => array (
		'customer/group/default' => array( 'domain' => 'customer/group', 'code' => 'default', 'label' => 'Standard', 'status' => 1 ),
		'order/download' => array( 'domain' => 'order', 'code' => 'download', 'label' => 'Download', 'status' => 1 ),
		'product/favorite' => array( 'domain' => 'product', 'code' => 'favorite', 'label' => 'Favorite', 'status' => 1 ),
		'product/watch' => array( 'domain' => 'product', 'code' => 'watch', 'label' => 'Watch list', 'status' => 1 ),
		'text/default' => array( 'domain' => 'text', 'code' => 'default', 'label' => 'Standard', 'status' => 1 ),
	),

	'customer/lists' => array (
		array( 'parentid' => 'customer/unitCustomer3', 'typeid' => 'text/default', 'domain' => 'text', 'refid' => 'text/customer/information', 'start' => '2010-01-01 00:00:00', 'end' => '2100-01-01 00:00:00', 'config' => [], 'pos' => 1, 'status' => 1 ),
		array( 'parentid' => 'customer/unitCustomer3', 'typeid' => 'text/default', 'domain' => 'text', 'refid' => 'text/customer/notify', 'start' => '2010-01-01 00:00:00', 'end' => '2100-01-01 00:00:00', 'config' => [], 'pos' => 2, 'status' => 1 ),
		array( 'parentid' => 'customer/unitCustomer3', 'typeid' => 'text/default', 'domain' => 'text', 'refid' => 'text/customer/newsletter', 'start' => '2010-01-01 00:00:00', 'end' => '2100-01-01 00:00:00', 'config' => [], 'pos' => 3, 'status' => 1 ),
		array( 'parentid' => 'customer/unitCustomer1', 'typeid' => 'text/default', 'domain' => 'text', 'refid' => 'text/customer/information', 'start' => '2010-01-01 00:00:00', 'end' => '2100-01-01 00:00:00', 'config' => [], 'pos' => 1, 'status' => 1 ),
	),
);