<?php
/**
 * Plugin mémorisant la dernière page vue
 * 
 * @package zfbook
 * @subpackage controller
 */
class Application_Plugin_Session extends Zend_Controller_Plugin_Abstract
{
    /**
     * Session récupérée du registre
     *
     * @var Zend_Session_Namespace
     */
    private $_session;
     private $uri;
    /**
     * En-têtes du navigateur
     * 
     * @var string
     */
    private $_clientHeaders;


    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->_session       = Zend_Registry::get('session');
       $this->_clientHeaders = $_SERVER['HTTP_USER_AGENT'];
        if (array_key_exists('HTTP_ACCEPT', $_SERVER)) {
            $this->_clientHeaders .= $_SERVER['HTTP_ACCEPT'];
        }
        $this->_clientHeaders = md5($this->_clientHeaders);
        
          $uri=new Zend_Session_Namespace('URI');
        //  $this->uri=$uri;
      //  $this->uri=$this->getRequest()->getRequestUri();
        
    }

    /**
     * Hook à l'entrée dans la boucle de dispatching
     * Vérifie si il n'y a pas eu tentative de vol de la session
     * en comparant les en-têtes du navigateur
     *
     * @param $request Zend_Controller_Request_Abstract
     */
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        if(Zend_Auth::getInstance()->hasIdentity()) {
            if ($this->_session->clientBrowser != $this->_clientHeaders) {
                Zend_Session::destroy();
                $this->_response->setHttpResponseCode(403);
                $this->_response->clearBody();
                $this->_response->sendResponse();
                exit;
            }
        }
    }

    /**
     * Hook à la sortie de la boucle de dispatching.
     * 
     * Mémorise l'Uri actuelle en vue de la réutiliser pour redirection
     * sur la page précédente.
     * 
     * @return void
     */
    public function dispatchLoopShutdown()
    {
        $this->_session->requestUri = $this->getRequest()->getRequestUri();
      //  $url = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
        // $this->_session->requestUri = $url;
       // Zend_Registry::set('urii', $this->uri->request);
        $this->_session->clientBrowser = $this->_clientHeaders;
    }
}