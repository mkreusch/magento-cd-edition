<?php
/**
 * Yapital payment method
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
 *
 * @deprecated This payment method is not longer available
 */
// @codingStandardsIgnoreLine magento marketplace namespace warning
class HeidelpayCD_Edition_Model_Payment_Hcdyt extends HeidelpayCD_Edition_Model_Payment_Abstract
{
    protected $_code = 'hcdyt';
    protected $_canRefund = false;
    protected $_canRefundInvoicePartial = false;
}
