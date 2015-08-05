<?php

/**
 * Ti Admin Comment Module
 *
 * @category    Ti
 * @package     Ti_AdminComment
 * @copyright   Copyright (c) 2014 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */

class Ti_AdminComment_Block_Adminhtml_Admincomment_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
            parent::__construct();
            $this->setId('admincommentGrid');
            $this->setDefaultSort('message_id');
            $this->setDefaultDir('ASC');
            $this->setUseAjax(true);
            $this->setSaveParametersInSession(true);

    }

    protected function _prepareCollection()
    {
            $collection = Mage::getModel('admincomment/messages')->getCollection();
            $this->setCollection($collection);
            return parent::_prepareCollection();

    }

    protected function _prepareColumns()
    {

           $this->addColumn('message_id', array(
                'header'    => Mage::helper('admincomment')->__('ID'),
                'align'     =>'right',
                'width'     => '50px',
                'index'     => 'message_id',
            ));

            $this->addColumn('title', array(
                'header'    => Mage::helper('admincomment')->__('Title'),
                'align'     =>'left',
                'width'     => '150px',
                'index'     => 'title',
            ));

            $this->addColumn('content', array(
                'header'    => Mage::helper('admincomment')->__('Message'),
                'index'     => 'content',
                'renderer'  => 'admincomment/adminhtml_admincomment_grid_renderer_content'
            ));

            $this->addColumn('order_status', array(
                'header'    => Mage::helper('admincomment')->__('Order Status'),
                'width'     => '150px',
                'index'     => 'order_status',
                'type'      => 'options',
                'options'   => Mage::getSingleton('sales/order_config')->getStatuses()
            ));

            $this->addColumn('status', array(
                'header'    => Mage::helper('admincomment')->__('Status'),
                'align'     => 'left',
                'width'     => '80px',
                'index'     => 'status',
                'type'      => 'options',
                'options'   => array(
                    1 => 'Enabled',
                    2 => 'Disabled',
                ),
            ));

              $this->addColumn('action',
                  array(
                      'header'    =>  Mage::helper('admincomment')->__('Action'),
                      'width'     => '100',
                      'type'      => 'action',
                      'getter'    => 'getId',
                      'actions'   => array(
                          array(
                              'caption'   => Mage::helper('admincomment')->__('Edit'),
                              'url'       => array('base'=> '*/*/edit'),
                              'field'     => 'id'
                          )
                      ),
                      'filter'    => false,
                      'sortable'  => false,
                      'index'     => 'stores',
                      'is_system' => true,
              ));

            $this->addExportType('*/*/exportCsv', Mage::helper('admincomment')->__('CSV'));
            $this->addExportType('*/*/exportXml', Mage::helper('admincomment')->__('XML'));

            return parent::_prepareColumns();

    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('message_id');
        $this->getMassactionBlock()->setFormFieldName('admincomment');
        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('admincomment')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('admincomment')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('admincomment/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('admincomment')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('admincomment')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
