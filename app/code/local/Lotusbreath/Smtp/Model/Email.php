<?php
class Lotusbreath_Smtp_Model_Email extends Mage_Core_Model_Email {

    const XML_PATH_SMTP_HOST      = 'lotusbreath_smtp/smtp/outgoing';
    const XML_PATH_SMTP_PORT    = 'lotusbreath_smtp/smtp/outgoing_port';
    const XML_PATH_SMTP_USERNAME    = 'lotusbreath_smtp/smtp/username';
    const XML_PATH_SMTP_PASSWORD    = 'lotusbreath_smtp/smtp/password';
    const XML_PATH_SMTP_SSL    = 'lotusbreath_smtp/smtp/outgoing_ssl';
    const XML_PATH_SMTP_ENABLED    = 'lotusbreath_smtp/smtp/enabled';


    public function send()
    {

        if (Mage::getStoreConfig(self::XML_PATH_SMTP_ENABLED)) {
            return parent::send();
        }
        $config = array(
            'host' => Mage::getStoreConfig(self::XML_PATH_SMTP_HOST),
            'auth' => 'login',
            'username' => Mage::getStoreConfig(self::XML_PATH_SMTP_USERNAME),
            'password' => Mage::getStoreConfig(self::XML_PATH_SMTP_PASSWORD),
            'ssl' => Mage::getStoreConfig(self::XML_PATH_SMTP_SSL),
            'port' => Mage::getStoreConfig(self::XML_PATH_SMTP_PORT),

        );
        if(empty($config['ssl'])){
            unset($config['ssl']);
        }
        $transport = new Zend_Mail_Transport_Smtp($config['host'], $config);

        $mail = new Zend_Mail();

        if (strtolower($this->getType()) == 'html') {
            $mail->setBodyHtml($this->getBody());
        }
        else {
            $mail->setBodyText($this->getBody());
        }
        $mail->setFrom($this->getFromEmail(), $this->getFromName())
            ->addTo($this->getToEmail(), $this->getToName())
            ->setSubject($this->getSubject());
        $mail->send($transport);
        return $this;
    }
}