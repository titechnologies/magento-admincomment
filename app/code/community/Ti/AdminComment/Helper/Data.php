<?php

/**
 * Ti Admin Comment Module
 *
 * @category    Ti
 * @package     Ti_AdminComment
 * @copyright   Copyright (c) 2014 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */

class Ti_AdminComment_Helper_Data extends Mage_Adminhtml_Helper_Data
{
    public function getPrePopulateMessagesUrl()
    {
        return $this->getUrl('admincomment/adminhtml_admincomment/getMessages');
    }
}
