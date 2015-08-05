<?php

/**
 * Ti Admin Comment Module
 *
 * @category    Ti
 * @package     Ti_AdminComment
 * @copyright   Copyright (c) 2014 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */

class Ti_AdminComment_Adminhtml_AdmincommentController extends Mage_Adminhtml_Controller_action
{

    protected function _initAction()
    {
        $this->loadLayout()
                ->_setActiveMenu('sales/admincomment')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Manage Pre-Defined Messages'), Mage::helper('adminhtml')->__('Manage Pre-Defined Message'));

        return $this;
    }

    public function indexAction()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            $this->_forward('grid');
            return;
        }

        $this->_title($this->__('Pre-Defined Messages'))->_title($this->__('Manage Messages'));
        $this->_initAction()
                ->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->createBlock('admincomment/adminhtml_admincomment_grid')->toHtml());
    }

    public function editAction()
    {
        $this->_title($this->__('Pre-Defined Messages'))->_title($this->__('Manage Message'));
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('admincomment/messages')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('admincomment_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('sales/admincomment');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Manage Pre-Defined Message'), Mage::helper('adminhtml')->__('Manage Pre-Defined Message'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Pre-Defined Message'), Mage::helper('adminhtml')->__('Pre-Defined Message'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('admincomment/adminhtml_admincomment_edit'))
                    ->_addLeft($this->getLayout()->createBlock('admincomment/adminhtml_admincomment_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('admincomment')->__('Message does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function getMessagesAction()
    {
        $layout = $this->getLayout();
        $update = $layout->getUpdate();
        $update->load('admincomment_messages_dropdown');
        $layout->generateXml();
        $layout->generateBlocks();
        $output = $layout->getOutput();

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('dropdown' => $output)));
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('admincomment/messages');
            $model->setData($data)
                    ->setId($this->getRequest()->getParam('id'));

            try {
                if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                    $model->setCreatedTime(now())
                            ->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                }

                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('admincomment')->__('Message was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('admincomment')->__('Unable to find Message to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('admincomment/messages');

                $model->setId($this->getRequest()->getParam('id'))
                        ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Message was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $prepopulateIds = $this->getRequest()->getParam('admincomment');
        if (!is_array($prepopulateIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Message(s)'));
        } else {
            try {
                foreach ($prepopulateIds as $prepopulateId) {
                    $prepopulate = Mage::getModel('admincomment/messages')->load($prepopulateId);
                    $prepopulate->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__(
                                'Total of %d record(s) were successfully deleted', count($prepopulateIds)
                        )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction()
    {
        $prepopulateIds = $this->getRequest()->getParam('admincomment');
        if (!is_array($prepopulateIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Message(s)'));
        } else {
            try {
                foreach ($prepopulateIds as $prepopulateId) {
                    $prepopulate = Mage::getSingleton('admincomment/messages')
                            ->load($prepopulateId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) were successfully updated', count($prepopulateIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName = 'predefined_messages.csv';
        $content = $this->getLayout()->createBlock('admincomment/adminhtml_admincomment_grid')
                ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName = 'predefined_messages.xml';
        $content = $this->getLayout()->createBlock('admincomment/adminhtml_admincomment_grid')
                ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK', '');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename=' . $fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }

}
