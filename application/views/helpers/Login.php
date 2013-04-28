<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Zend_View_Helper_Link
 *
 * @author armel
 */
class Zend_View_Helper_Login extends Zend_View_Helper_Abstract 
{
    
     public function login(){
         
         
         
                 $form = new Application_Form_LoginForm (array(
        'action' => $this->view->BaseUrl('login.html'),
        'method' => 'post'
        ));
       
        //si il n'est pas identifier on affiche le formulaire login
        $auth = Zend_Auth::getInstance();        
        if (!$auth->hasIdentity ()) {       
            return $form;
        }
       
    }
         
         
         
        
         
     

}
?>
