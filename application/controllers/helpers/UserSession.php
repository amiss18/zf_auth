<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserSession
 *
 * @author root
 */
class Application_Controller_Action_Helper_UserSession extends Zend_Controller_Action_Helper_Abstract{
    //put your code here
    
    public function direct($name){
        echo "hello word! je suis une helper daction, $name";
        
    }
    
    public function email($name){
        echo "mon nom est : $name";
    }
    
}

?>
