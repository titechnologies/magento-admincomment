<?php

/**
 * Ti Admin Comment Module
 *
 * @category    Ti
 * @package     Ti_AdminComment
 * @copyright   Copyright (c) 2014 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */

class Ti_AdminComment_Model_Mysql4_Messages_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('admincomment/messages');
    }

    public function toOptionArray()
    {
        $orderStatusesMessages = array(
            array('value' => '', 'label' => Mage::helper('adminhtml')->__('-- Please select --'))
        );

        $messagesCollection = $this->addFieldToFilter('status', 1);
        $orderStatuses = Mage::getSingleton('sales/order_config')->getStatuses();

        foreach ($orderStatuses as $statusCode => $statusLabel) {
            $messages = array();
            $statusMessages = $messagesCollection->getItemsByColumnValue('order_status', $statusCode);

            if (sizeof($statusMessages)) {
                foreach ($statusMessages as $message) {
                    $messages[] = array(
                        'label' => $message->getTitle(),
                        'value' => $message->getContent()
                    );
                }

                $orderStatusesMessages[] = array(
                    'label' => $statusLabel,
                    'value' => $messages
                );
            }
        }

        return $orderStatusesMessages;
    }
}
