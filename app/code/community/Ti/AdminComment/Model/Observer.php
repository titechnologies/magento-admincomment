<?php

/**
 * Ti Admin Comment Module
 *
 * @category    Ti
 * @package     Ti_AdminComment
 * @copyright   Copyright (c) 2014 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */

class Ti_AdminComment_Model_Observer
{
    const MODULE_NAME = 'Ti_AdminComment';

    public function addUpdateOrderCommentsBlock($observer = null)
    {
        if (!$observer) {
            return;
        }

        if ('order_history' == $observer->getEvent()->getBlock()->getNameInLayout()) {
            if (!Mage::getStoreConfig('advanced/modules_disable_output/' . self::MODULE_NAME)) {
                $transport = $observer->getEvent()->getTransport();

                $block = Mage::app()->getLayout()
                                    ->createBlock('admincomment/adminhtml_order_messages');
                $block->setPassingTransport($transport['html']);
                $block->setTemplate('admincomment/order/messages.phtml')
                      ->toHtml();


            }
        }

        return $this;
    }
}
