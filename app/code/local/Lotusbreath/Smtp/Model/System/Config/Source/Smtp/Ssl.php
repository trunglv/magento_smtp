<?php
class Lotusbreath_Smtp_Model_System_Config_Source_Smtp_Ssl {
    function toOptionArray(){
        return array(
            null => 'None',
            'tls' => 'TLS',
            'ssl' => 'SSL'
        );
    }
}