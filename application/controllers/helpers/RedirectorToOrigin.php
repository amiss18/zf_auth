<?php
/**
 * Aide d'action permettant la redirection vers la page précédente
 * 
 * @package zfbook
 * @subpackage controller
 */
class Application_Controller_Action_Helper_RedirectorToOrigin extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * Pattern Strategy
     * 
     * @param string $message
     * @return void
     */
    
    public function direct($message = null)
     // public function direct()
    {
        // Insertion du message dans le flash messenger
        if (!is_null($message)) {
            Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger')->addMessage($message);
        }

        
        // Redirection
        if (!isset(Zend_Registry::get('session')->requestUri)) {
            $gotoUrl = $this->getFrontController()->getBaseUrl();
          //  $gotoUrl = $this->view->serverUrl() . $this->view->baseUrl();
            
        } else {
            $gotoUrl = Zend_Registry::get('session')->requestUri;
        }
   //      Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector')>gotoUrl($gotoUrl);
      //Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector')->getResponse()->setRedirect($gotoUrl);
    
   Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector')->setCode(303)->gotoUrl($gotoUrl, array("prependBase" => false));
    }

    /**
     * Attribue un namespace au flashmessenger
     *
     * @param string $namespace
     * @return Zfbook_Controller_ActionHelpers_RedirectorToOrigin
     */
    
    public function setFlashMessengerNamespace($namespace)
    {
        Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger')->setNamespace($namespace);
        return $this;
    }
}