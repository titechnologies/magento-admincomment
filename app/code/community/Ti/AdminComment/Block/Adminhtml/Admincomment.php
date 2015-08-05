<?php

/**
 * Ti Admin Comment Module
 *
 * @category    Ti
 * @package     Ti_AdminComment
 * @copyright   Copyright (c) 2014 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */

class Ti_AdminComment_Block_Adminhtml_Admincomment extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $configValue = Mage::getStoreConfig('admincomment/admincomment_group/admincomment_enable');
        if($configValue == 1) {
            $this->_controller = 'adminhtml_admincomment';
            $this->_blockGroup = 'admincomment';
            $this->_headerText = Mage::helper('admincomment')->__('Pre-Defined Messages');
            $this->_addButtonLabel = Mage::helper('admincomment')->__('Create New Message');
            parent::__construct();
        }else {
            return parent::__construct();
        }
    }
}
