<?php
/**
 * Booking mode configuration model
 *
 * @license Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 * @copyright Copyright © 2016-present heidelpay GmbH. All rights reserved.
 *
 * @link  http://dev.heidelpay.com/magento
 *
 * @author  Jens Richter
 *
 * @package  Heidelpay
 * @subpackage Magento
 * @category Magento
 */
// @codingStandardsIgnoreLine
class HeidelpayCD_Edition_Model_System_Config_Source_Bookingmode
{
    /**
     * returns the available booking modes for backend configuration
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value'=>'DB', 'label'=>Mage::helper('hcd')->__('Direct Booking')),
            array('value'=>'PA', 'label'=>Mage::helper('hcd')->__('Preauthorisation'))
        );
    }
}
