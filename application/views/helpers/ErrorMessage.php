<?php
/**
 * Récupère le dernier message d'erreur dans le flashmessenger
 * 
 * @package application
 * @subpackage viewhelpers
 */
class Zend_View_Helper_ErrorMessage
{
    /**
     * Récupère le dernier message dans le flashMessenger 
     * au namespace indiqué
     * 
     * @param string $errorMessage
     * @return string
     */
    public function errorMessage($errorMessage)
    {
        $messages = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger')->setNamespace($errorMessage)->getMessages();
        return isset($messages[0]) ? $messages[0] : '';
    }
}