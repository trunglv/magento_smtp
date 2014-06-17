<?php
class Lotusbreath_Smtp_Block_System_Config_Form_Smtpbutton extends Mage_Adminhtml_Block_System_Config_Form_Field{

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        $url = Mage::helper("adminhtml")->getUrl('smtp/adminhtml_smtp/test'); //

        $html = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setType('button')
            ->setClass('scalable')
            ->setLabel('Send test mail')
            ->setOnClick("sendTestMail('$url')")
            ->toHtml();

        return $html;
    }
}