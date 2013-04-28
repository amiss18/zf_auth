<?php

/*
 * envoi d'email avec authentification smtp par zend_mail
 * usage(dans un controller):$this->_helper->email('email','nom','sujet','message')
 * 
 */

/**
 * Description of UserSession
 *
 * @author armel
 */
class Application_Controller_Action_Helper_Email extends Zend_Controller_Action_Helper_Abstract {

    //put your code here
    /* @param:email du destinataire,
     *       nom du destinataire,
     *       sujet,
     *       $body
     * @return : true or false            
     *       
     * 
     * 
     */
    public function direct($emailDest, $nomDest, $sujet, $body) {
        
        $config = array('ssl' => 'tls', 'port' => 587, 'auth' => 'login',
            'username' => EMAIL_EXP,
            'password' => PASSWORD_EXP);
        $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);

        $mail = new Zend_Mail();
        $mail->setBodyHtml($body, 'utf-8');
        $mail->setFrom('chardanmiss@gmail.com', 'Dupond Lion');
        $mail->addTo($emailDest, $nomDest);
        $mail->setSubject($sujet);
        //$r = $mail->send($transport);
        return $mail->send($transport);;
    }

    public function email($name) {
        echo "mon nom est : $name";
    }

}

?>
