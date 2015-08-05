<?php

/**
 * Ti Admin Comment Module
 *
 * @category    Ti
 * @package     Ti_AdminComment
 * @copyright   Copyright (c) 2014 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */

class Ti_AdminComment_Model_Status extends Varien_Object
{
    const STATUS_ENABLED    = 1;
    const STATUS_DISABLED   = 2;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('admincomment')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('admincomment')->__('Disabled')
        );
    }
}
