<?php

/**
 * Ti Admin Comment Module
 *
 * @category    Ti
 * @package     Ti_AdminComment
 * @copyright   Copyright (c) 2014 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */


class Ti_AdminComment_Block_Adminhtml_Admincomment_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('admincomment_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('admincomment')->__('Message'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('admincomment')->__('Message'),
            'title'     => Mage::helper('admincomment')->__('Message'),
            'content'   => $this->getLayout()->createBlock('admincomment/adminhtml_admincomment_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
