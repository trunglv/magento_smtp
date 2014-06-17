<?php
class Lotusbreath_Smtp_Model_Smtp_Mail extends Zend_Mail {

    const XML_PATH_SENDING_SET_RETURN_PATH      = 'system/smtp/set_return_path';
    const XML_PATH_SENDING_RETURN_PATH_EMAIL    = 'system/smtp/return_path_email';


    protected $config = null;

    public function setConfig($parameters){
        $this->config = $parameters;
        if(empty($this->config['ssl'])){
            unset($this->config['ssl']);
        }
    }

    public function send($transport = null)
    {
        $transport = new Zend_Mail_Transport_Smtp($this->config['host'], $this->config);
        $setReturnPath = Mage::getStoreConfig(self::XML_PATH_SENDING_SET_RETURN_PATH);
        switch ($setReturnPath) {
            case 1:
                $returnPathEmail = $this->getSenderEmail();
                break;
            case 2:
                $returnPathEmail = Mage::getStoreConfig(self::XML_PATH_SENDING_RETURN_PATH_EMAIL);
                break;
            default:
                $returnPathEmail = null;
                break;
        }

        if ($returnPathEmail !== null) {
            $this->setReturnPath($returnPathEmail);
        }
        if ($this->_date === null) {
            $this->setDate();
        }

        if(null === $this->_from && null !== self::getDefaultFrom()) {
            $this->setFromToDefaultFrom();
        }

        if(null === $this->_replyTo && null !== self::getDefaultReplyTo()) {
            $this->setReplyToFromDefault();
        }

        $transport->send($this);

        return $this;
    }
}