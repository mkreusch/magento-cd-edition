<?php
/** @noinspection LongInheritanceChainInspection */
/**
 * Direct debit secured payment method
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
class HeidelpayCD_Edition_Model_Payment_HcdDirectDebitSecured
    extends HeidelpayCD_Edition_Model_Payment_AbstractSecuredPaymentMethods
{

    /**
     * HeidelpayCD_Edition_Model_Payment_Hcdpp constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->_code = 'hcdddsec';
        $this->_canReversal = true;
        $this->_formBlockType = 'hcd/form_directDebitSecured';
        $this->_infoBlockType = 'hcd/info_directDebit';
        $this->_reportsShippingToHeidelpay = true;
        $this->_showAdditionalPaymentInformation = true;
        $this->_canBasketApi = true;
    }

    /**
     * Validate customer input on checkout
     *
     * @return $this
     * @throws \Mage_Core_Exception
     */
    public function validate()
    {
        $this->_postPayload = Mage::app()->getRequest()->getPost('payment');

        if (isset($this->_postPayload['method']) && $this->_postPayload['method'] === $this->getCode()) {
            parent::validate();

            if (empty($this->_postPayload[$this->getCode() . '_holder'])) {
                Mage::throwException($this->_getHelper()->__('Please specify a account holder'));
            }

            if (empty($this->_postPayload[$this->getCode() . '_iban'])) {
                Mage::throwException($this->_getHelper()->__('Please specify a iban or account'));
            }

            $this->_validatedParameters['ACCOUNT.HOLDER'] = $this->_postPayload[$this->getCode() . '_holder'];

            if (preg_match('#^[\d]#', $this->_postPayload[$this->getCode() . '_iban'])) {
                $this->_validatedParameters['ACCOUNT.NUMBER'] = $this->_postPayload[$this->getCode() . '_iban'];
            } else {
                $this->_validatedParameters['ACCOUNT.IBAN'] = $this->_postPayload[$this->getCode() . '_iban'];
            }

            parent::validate();
        }

        return $this;
    }

    /**
     * Payment information for invoice mail
     *
     * @param $paymentData array  transaction response
     *
     * @return string return payment information text
     */
    public function showPaymentInfo($paymentData)
    {
        $loadSnippet = $this->_getHelper()->__('Direct Debit Info Text');

        $repl = array(
            '{AMOUNT}' => $paymentData['CLEARING_AMOUNT'],
            '{CURRENCY}' => $paymentData['CLEARING_CURRENCY'],
            '{Iban}' => $paymentData['ACCOUNT_IBAN'],
            '{Ident}' => $paymentData['ACCOUNT_IDENTIFICATION'],
            '{CreditorId}' => $paymentData['IDENTIFICATION_CREDITOR_ID'],
        );

        return strtr($loadSnippet, $repl);
    }

    /**
     * @inheritdoc
     */
    public function chargeBackTransaction($order, $message = '')
    {
        /** @noinspection SuspiciousAssignmentsInspection */
        $message = Mage::helper('hcd')->__('debit failed');
        return parent::chargeBackTransaction($order, $message);
    }
}
