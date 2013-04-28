<?php

/*
 * cette aide de vue permet d'afficher le formulaire si le user n'est pas authentifié
 * sinon elle affiche l'identité du user s'il s'est authentifié
 * 
 */


class Zend_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract 
{
    public function loggedInAs ()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $username = $auth->getIdentity()->nom;
           // $logoutUrl = $this->view->url(array('module'=>'default','controller'=>'auth',
           //  'action'=>'logout'), null, true);
            $logoutUrl = $this->view->link('index', 'logout');
            return 'Vous êtes <b>' . $username . '</b></br>'.  ' <a href="'.$logoutUrl.'">Déconnexion</a>';
            //return 'Vous êtes ' . ''.  '. <a href="'.$logoutUrl.'">Déconnexion</a>';
        } 

        $request = Zend_Controller_Front::getInstance()->getRequest();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        if($controller == 'index' && $action == 'login') {
          
            return '';
        }
       // $loginUrl = $this->view->url(array('controller'=>'auth', 'action'=>'index'));
         $loginUrl = $this->view->link('index','login');
   
     
        return '<a href="'.$loginUrl.'">Connexion</a>';
    }
}


