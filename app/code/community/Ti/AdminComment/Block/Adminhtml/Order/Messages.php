<?php

/**
 * Ti Admin Comment Module
 *
 * @category    Ti
 * @package     Ti_AdminComment
 * @copyright   Copyright (c) 2014 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */

class Ti_AdminComment_Block_Adminhtml_Order_Messages extends Mage_Adminhtml_Block_Template
{
    private $_passedTransportHtml;

    /**
     * Get admin defined messages
     *
     * @return <select>
     */
    public function getMessages()
    {
        $select = $this->getLayout()->createBlock('adminhtml/html_select')
            ->setData(array(
                'id' => 'admincomment_messages_dropdown',
                'class' => 'select'
            ))
            ->setName('admincomment_messages_dropdown')
            ->setOptions(Mage::getResourceModel('admincomment/messages_collection')->toOptionArray());

        return $select->getHtml();
    }

    public function setPassingTransport($transport)
    {
        $this->_passedTransportHtml = $transport;
    }

    public function getPassedTransport()
    {
        return $this->_passedTransportHtml;
    }
}
