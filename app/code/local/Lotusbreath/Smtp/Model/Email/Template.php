<?php
class Lotusbreath_Smtp_Model_Email_Template extends Mage_Core_Model_Email_Template {

    protected $_smtp_config = null;
    protected $_is_testing = false;
    const XML_PATH_SMTP_HOST      = 'lotusbreath_smtp/smtp/outgoing';
    const XML_PATH_SMTP_PORT    = 'lotusbreath_smtp/smtp/outgoing_port';
    const XML_PATH_SMTP_USERNAME    = 'lotusbreath_smtp/smtp/username';
    const XML_PATH_SMTP_PASSWORD    = 'lotusbreath_smtp/smtp/password';
    const XML_PATH_SMTP_SSL    = 'lotusbreath_smtp/smtp/outgoing_ssl';
    const XML_PATH_SMTP_ENABLED    = 'lotusbreath_smtp/smtp/enabled';


    public function setSmtpConfig($config){
        $this->_smtp_config = $config;
    }

    public function setIsTesting($bvalue = true){
        $this->_is_testing = $bvalue;
    }

    public function getSmtpConfig(){
        if ($this->_smtp_config == null){
            $this->_smtp_config = array(
                'host' => Mage::getStoreConfig(self::XML_PATH_SMTP_HOST),
                'auth' => 'login',
                'username' => Mage::getStoreConfig(self::XML_PATH_SMTP_USERNAME),
                'password' => Mage::getStoreConfig(self::XML_PATH_SMTP_PASSWORD),
                'ssl' => Mage::getStoreConfig(self::XML_PATH_SMTP_SSL),
                'port' => Mage::getStoreConfig(self::XML_PATH_SMTP_PORT),

            );
        }
        return $this->_smtp_config;
    }

    public function getMail()
    {
        if(Mage::getStoreConfig(self::XML_PATH_SMTP_SSL) || $this->_is_testing){
            if (is_null($this->_mail)) {
                $config = $this->getSmtpConfig();
                $mail =  Mage::getSingleton('lotusbreath_smtp/smtp_mail');
                $mail->setConfig($config);
                $this->_mail = $mail;
            }
            return $this->_mail;
        }else{
            return parent::getMail();
        }

    }
}