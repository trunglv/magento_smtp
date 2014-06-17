<?php
class Lotusbreath_Smtp_Adminhtml_SmtpController extends Mage_Adminhtml_Controller_Action {

    public function test2Action(){
        $data = $this->getRequest()->getPost('groups');
        print_r($data['smtp']['fields']);


        $email = Mage::getModel("core/email");
        $email->setSubject("Test connection email");
        $email->setBody("You have successfully configured your SMTP connection.");
        $email->setFrom(Mage::getStoreConfig('smtp/params/smtp_username', Mage::app()->getStore()));
        $email->setToEmail('luuvantrung@gmail.com');
        $email->send();
        echo 3;
        exit;
    }

    public function testAction(){
        $data = $this->getRequest()->getPost('groups');

        $smtpConfig = array(
            'host' => $data['smtp']['fields']['outgoing']['value'],
            'auth' => 'login',
            'username' => $data['smtp']['fields']['username']['value'],
            'password' => $data['smtp']['fields']['password']['value'],
            'ssl' => $data['smtp']['fields']['outgoing_ssl']['value'],
            'port' => $data['smtp']['fields']['outgoing_port']['value'],
        );


        $emailTemplateVariables = array();
        $emailTemplateId = 'lotusbreath_smtp_testing_template';
        $storeId = Mage::app()->getStore()->getId();
        if ((int)$emailTemplateId)
            $emailTemplate  = Mage::getModel('core/email_template')->load($emailTemplateId);
        else
            $emailTemplate  = Mage::getModel('core/email_template')->loadDefault($emailTemplateId);

        $emailTemplate->setSmtpConfig($smtpConfig);
        $emailTemplate->setIsTesting();

        $senderMail = Mage::getStoreConfig('trans_email/ident_general/email');
        $emailTemplate->setSenderEmail($senderMail);
        $emailTemplate->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name', $storeId));
        $emailTemplate->setType('html');

        if(!$emailTemplate->getTemplateSubject())
            $emailTemplate->setTemplateSubject(self::__('Lotusbreath SMTP Test Mail'));
        $sendTo = '';
        if (!empty($data['testing']['fields']['test_email']['value'])){
            $sendTo = $data['testing']['fields']['test_email']['value'];
        }else{
            $sendTo = Mage::getStoreConfig('trans_email/ident_general/email');
        }
        $message = '';
        try{
            $isOk = $emailTemplate->send('luuvantrung@gmail.com', null , $emailTemplateVariables);
            if ($isOk){
                $message = 'Send mail successfully';
            }else{
                $message = 'Send mail failure';
            }

        }catch (Exception $ex){
            //echo $ex->getMessage();
            $message = $ex->getMessage();
        }
        echo $message;



    }
}