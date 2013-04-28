<?php


//class Application_Controller_Plugin_Theme extends Zend_Controller_Plugin_Abstract {
class Application_Plugin_Theme extends Zend_Controller_Plugin_Abstract {

    
private $_auth;

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
    //   $form= Zend_Registry::getInstance();
      //  Zend_Layout::getMvcInstance()->assign('whatever', 'foooo');
        //  $form = new Application_Form_LoginForm();
      //Zend_Layout::getMvcInstance()->assign('loginForm', $form);
           
    }
    
        public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
            //Zend_Registry::get('uri')->uri=$this->getRequest()->getRequestUri();
       //$form = new Application_Form_LoginForm();
       // $form=Zend_Registry::get('form');
      // $f=Zend_Registry::set('form', $form);
        
      $this->_auth = Zend_Auth::getInstance();
   //  Zend_Layout::getMvcInstance()->assign('loginForm', Zend_Registry::get('form'));
          
             /*  $request->setModuleName('default');
       
            $request->setControllerName("index");
                $request->setActionName("login");
            */
      
     
      // Zend_Layout::getMvcInstance()->assign('loginForm', $form);
       // $request = $this->getRequest();
       
            
         
          
        }
        
         public function dispatchLoopShutdown(){
           
            
           
         }
        
        
        public function postDispatch(Zend_Controller_Request_Abstract $request) {
                  
       
            
        }

}

//end