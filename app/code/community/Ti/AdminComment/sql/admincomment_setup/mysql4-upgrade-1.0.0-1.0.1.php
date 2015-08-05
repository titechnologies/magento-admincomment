<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('admincomment/messages')};
CREATE TABLE {$this->getTable('admincomment/messages')} (
  `message_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `order_status` varchar(32) NOT NULL default'',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");


$installer->getConnection()
          ->addConstraint(
            'FK_ORDER_STATUS',
            $this->getTable('admincomment/messages'),
            'order_status',
            $this->getTable('sales/order_status_state'),
            'status'
          );

$installer->endSetup();
