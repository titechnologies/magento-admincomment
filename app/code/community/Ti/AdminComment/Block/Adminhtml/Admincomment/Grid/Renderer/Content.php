<?php

/**
 * Ti Admin Comment Module
 *
 * @category    Ti
 * @package     Ti_AdminComment
 * @copyright   Copyright (c) 2014 Ti Technologies (http://www.titechnologies.in)
 * @link        http://www.titechnologies.in
 */

class Ti_AdminComment_Block_Adminhtml_Admincomment_Grid_Renderer_Content extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $content = $row->getContent();

        if (strlen($content) > 200) {
            $content = substr($content, 0, 200) . ' ... ';
        }

        return $content;
    }
}
