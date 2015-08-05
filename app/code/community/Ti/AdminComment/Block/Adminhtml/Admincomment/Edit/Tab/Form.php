<?php

/**
 * Ti Admin Comment Module
 *
 * @category    Ti
 * @package     Ti_AdminComment
 * @copyright   Copyright (c) 2014 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */

class Ti_AdminComment_Block_Adminhtml_Admincomment_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('admincomment_form', array('legend'=>Mage::helper('admincomment')->__('Message information')));

        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('admincomment')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));

        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('admincomment')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('admincomment')->__('Enabled'),
                ),

                array(
                    'value'     => 2,
                    'label'     => Mage::helper('admincomment')->__('Disabled'),
                ),
            ),
        ));

        $orderStatuses = Mage::getSingleton('sales/order_config')->getStatuses();
        $fieldset->addField('order_status', 'select', array(
            'label'     => Mage::helper('admincomment')->__('Status'),
            'name'      => 'order_status',
            'values'    => $orderStatuses
        ));

        $fieldset->addField('content', 'editor', array(
            'name'      => 'content',
            'label'     => Mage::helper('admincomment')->__('Message'),
            'title'     => Mage::helper('admincomment')->__('Message'),
            'style'     => 'width:700px; height:100px;',
            'required'  => true,
        ));

        if (Mage::getSingleton('adminhtml/session')->getPrepopulateData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getPrepopulateData());
            Mage::getSingleton('adminhtml/session')->setPrepopulateData(null);
        } elseif (Mage::registry('admincomment_data')) {
            $form->setValues(Mage::registry('admincomment_data')->getData());
        }

        return parent::_prepareForm();
    }
}
