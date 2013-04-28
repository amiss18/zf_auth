<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
    
    
  /*
   * appel des constantes définies dans application.ini
   */   
    protected function _initConstants()
    {
        $options = $this->getOption('constants');

        if (is_array($options)) {
            foreach($options as $key => $value) {
                if(!defined($key)) {
                    define($key, $value);
                }
            }
        }
    }
    
    
public function _initSession(){
    $configSession = new Zend_Config_Ini(APPLICATION_PATH .'/configs/session.ini','production');

// ************************* SESSION ***********************************
// Configuration de la session (impérativement avant son démarrage)
Zend_Session::setOptions($configSession->toArray());
Zend_Session::setOptions(array('save_path' => APPLICATION_PATH . $configSession->save_path));

// Partage (et création ou restauration) de l'objet de session dans le registre
// Ce premier appel à new Zend_Session_Namespace démarre la session PHP
Zend_Registry::set('session', $session = new Zend_Session_Namespace('app'));

//$url = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
 if(!Zend_Auth::getInstance()->hasIdentity()) {
Zend_Registry::set('uri' , new Zend_Session_Namespace('URI'));
 }
   
    }
    
/* enregistrement helpers d'action dans le gestionnaire (getHelper)
 * 
 */  
protected function _initHelperPath()
{
    Zend_Controller_Action_HelperBroker::addPath(
            APPLICATION_PATH . '/controllers/helpers',
            'Application_Controller_Action_Helper_');
}




  

public function _initMonLayout(){
     Zend_Controller_Front::getInstance()->registerPlugin(new Application_Plugin_Theme());
     Zend_Controller_Front::getInstance()->registerPlugin(new Application_Plugin_Session());
        
}




}//End

