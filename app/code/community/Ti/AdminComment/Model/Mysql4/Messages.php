<?php

/**
 * Ti Admin Comment Module
 *
 * @category    Ti
 * @package     Ti_AdminComment
 * @copyright   Copyright (c) 2014 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */

class Ti_AdminComment_Model_Mysql4_Messages extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        // Note that the message_id refers to the key field in your database table.
        $this->_init('admincomment/messages', 'message_id');
    }
}
