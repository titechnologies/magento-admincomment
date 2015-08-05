<?php

/**
 * Ti Admin Comment Module
 *
 * @category    Ti
 * @package     Ti_AdminComment
 * @copyright   Copyright (c) 2014 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */

class Ti_AdminComment_Block_Adminhtml_Admincomment_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $configValue = Mage::getStoreConfig('admincomment/admincomment_group/admincomment_enable');
        if($configValue == 1) {
            parent::__construct();

            $this->_objectId = 'id';
            $this->_blockGroup = 'admincomment';
            $this->_controller = 'adminhtml_admincomment';

            $this->_updateButton('save', 'label', Mage::helper('admincomment')->__('Save Message'));
            $this->_updateButton('delete', 'label', Mage::helper('admincomment')->__('Delete Message'));

            $this->_addButton('saveandcontinue', array(
                'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
                'onclick'   => 'saveAndContinueEdit()',
                'class'     => 'save',
            ), -100);

            $this->_formScripts[] = "
                function saveAndContinueEdit(){
                    editForm.submit($('edit_form').action+'back/edit/');
                }
            ";
        }
        else {
            return parent::__construct();
        }
    }

    public function getHeaderText()
    {
            if( Mage::registry('admincomment_data') && Mage::registry('admincomment_data')->getId() ) {
                return Mage::helper('admincomment')->__("Edit Message '%s'", $this->htmlEscape(Mage::registry('admincomment_data')->getTitle()));
            } else {
                return Mage::helper('admincomment')->__('Create New Message');
            }

    }
}
