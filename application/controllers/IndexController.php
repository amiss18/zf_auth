<?php

class IndexController extends Zend_Controller_Action
{

    /**
     * Instance de Zend_Auth
     * 
     * @var Zend_Auth
     */
    private $_auth;
  //  private $_form;
    private $uri;


    /**
     * Appelé à la construction : instancie Zend Auth
     */
    public function init()
    {
      //  echo $this->view->jQuery()->enable();
       $this->_auth = Zend_Auth::getInstance();
      // $this->_form=new Application_Form_LoginForm();
        //$gotoUrl = $this->view->serverUrl() . $this->view->baseUrl();
      
        
    }
    
    public function indexAction()
    {
    /*
     if ($this->_auth->hasIdentity()) {
            $this->view->login = $this->_auth->getIdentity()->firstname;
            $this->render('welcome');
        } else {
            $this->render('login');
        }
     */
    $sujet='Votre candidature a été retenue';
    $body="<p>Société de Service en Ingénierie Informatique, puerilys accompagne ses clients dans le cadre de l'évolution et du développement de leurs systèmes d'informations. Fort du savoir faire et de l'expertise de ses 70 consultants en délégation de personnel (régie), partenaire de Microsoft, PRENIUM réalise avec succès les grands projets qui lui sont confiés par ses clients</p>";
    $body.="<p>Etudes & Développement : Prenium oriente son activité autour des nouvelles technologies telles que .NET (ASP.NET, C#, C++), SHAREPOINT…

Notre stratégie a été de conserver une technologie plus rare mais maîtrisée par notre entreprise : l’AS400. Ce langage de développement est aujourd’hui considéré comme une niche très porteuse du fait de son caractère spécifiqu</p>";
  
    
  /*  
    $r=$this->_helper->email(EMAIL_DEST,'Monsieur Toto',$sujet,$body);
    if($r)
         $r="message envoyé avec succès";
      else 
        $r="Echec d'envoi";
    
        $this->view->my = $r;
    */    
    $this->view->my = "page index:::::::::";
     // $fullBaseUrl = $this->view->serverUrl() . $this->view->baseUrl();
    //Zend_Debug::dump($fullBaseUrl);
     
     //Zend_Debug::dump($resp);
    }
    
   
    
    public function loginAction(){
    // $flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $form = new Application_Form_LoginForm();
      // echo "url3=", Tool_MyTool::safelyGetReferrerUrl('/'),'<br>';
         $this->view->form=$form;
        //Zend_Layout::getMvcInstance()->assign('loginForm', $form);
          //  $this->_helper->layout()->loginForm = $form;
        $this->view->placeholder('loginForm')->set($form);
        $request = $this->getRequest();
          echo "request uri=",$request->getParam('uri');
         
        $data=array();
        if ($request->isPost()) {
            $data = $request->getPost();
            if ($form->isValid($data)) {
             
                $salt = '12345';
                // création de l'authentificateur
                $db = Zend_Db_Table_Abstract::getDefaultAdapter();
                $dbAdapter = new Zend_Auth_Adapter_DbTable($db, 'user', 'email', 'password', "SHA1(CONCAT(?,$salt)) AND actif='1'");


                $login = $form->getValue('email');
                $password = $form->getValue('password');

                $dbAdapter->setCredential($password)
                        ->setIdentity($login);
                   
                // authentification          
                $result = $this->_auth->authenticate($dbAdapter);
                //    echo "<br/>affiche toi<br/>";
                // écriture de l'objet complet en session, sauf le champ password,
                // si l'identification est OK
                if ($result->isValid()) {
                    echo " succès connecté";
                   Zend_Debug::dump($request->getParam('uri'));
                    $this->_auth->getStorage()->write($dbAdapter->getResultRowObject(null, 'password'));
                    //Zend_Registry::set('session', $session = new Zend_Session_Namespace('sitepuerilys'));
                    // regénération de l'id de session (évite les fixations de session)
                    Zend_Session::regenerateId();
                     //echo "<br>url = $gotoUrl<br>";
                  //   Application_Tool_MyTool::safelyGetReferrerUrl();
                   // $this->_helper->redirector->gotoUrl($_POST['uri']);
                    // $this->_redirect($gotoUrl.$_SERVER['REQUEST_URI'], array('prependBase' => false));
                    // $this->_redirect('/index/login');
                     // $this->_response->setRedirect('/index/login');
                   $this->_helper->redirector('index');
                  //Tool_MyTool::safelyGetReferrerUrl('/');
                  //  $this->_helper->redirectorToOrigin();
                    // $this->_redirect('/');
                } else {
                    //$this->_helper->redirectorToOrigin('login ou mot de passe incorrect');
                    // $this->view->bad='login ou mot de passe incorrect';
     //               $form->setDescription("***login et/ou mot de passe invalide");
                    $message ="Echec cx:***login et/ou mot de passe incorrect";
                   // $this->_helper->FlashMessenger($message);
                  //  $flashMessenger->addMessage($message);
                    $this->_helper->flashMessenger->addMessage(array('error'=>$message));
                    $this->_helper->redirector('login');
//                    echo "login et/ou mot de passe invalide";
                }
            }
         else {
             $message ="Echec validation:login et/ou mot de passe invalide";
                   // $this->_helper->FlashMessenger($message);
                //    $flashMessenger->addMessage($message);
                //  $this->_helper->flashMessenger->addMessage(array('invalid'=>$message));
           $form->populate($data);
            
        }
        }//post
    }//
   
    /* // $this->_redirect($gotoUrl);
             // $this->_helper->redirector('index/index');
            // $this->_response->setRedirect('/index/index');
            
          //  $this->_helper->redirector->gotoUrl('/index/index');
      
      
     */
 
    
 /**
     * Déconnexion de l'utilisateur
     * La session est totalement détruite afin de détruire aussi les acls
     */
    public function logoutAction()
    {
     //   Zend_Auth::getInstance()->clearIdentity();
        Zend_Session::destroy();
        $this->_redirect('/');
    }
    
}//end

