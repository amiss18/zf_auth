<?php

class UserController extends Zend_Controller_Action {

    public function indexAction() {
        $form = new Application_Form_User();
        $this->view->form = $form;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            if ($form->isValid($data)) {
                $user = $form->getValue('email');
                $pass = $form->getValue('password');
                $name = $form->getValue('nom');
                // $salt=$this->alea();
                //$date='now()';
                $salt = "12345";
                $actif = 0;
                $role = 'vendeur';
                $auth = Zend_Auth::getInstance()->getIdentity();
                if (!is_null($auth) && $auth->role === "admin") {
                    $role = $form->getValue('role');
                    $actif = 1;
                }
                $date = date("Y-m-d H:i:s");
                $model = new Application_Model_User();
                $server = 'http://' . $_SERVER['SERVER_NAME'] . '/user/confirmation/user/' . md5($user);
                $url = "<a href='$server'>$server</a>";

                if (!$model->verifLogin($user)):
                    $model->addUser($user, $pass, $salt, $role, $date, $actif, $name);
                    Zend_Debug::dump($form->getValues(), 'champ');


                    $sujet = 'Votre inscription sur ppp';
                    $body = "<p>Société de Service en Ingénierie Informatique, puerilys accompagne ses clients dans le cadre de l'évolution et du développement de leurs systèmes d'informations. Fort du savoir faire et de l'expertise de ses 70 consultants en délégation de personnel (régie), partenaire de Microsoft, PRENIUM réalise avec succès les grands projets qui lui sont confiés par ses clients</p>";
                    $body.="<p>veuillez cliquez çi-dessous pour activer votre compte  </p>";
                    $body.="<p>$url  </p>";

                    $r = null;
                    if (!is_null($auth) && $auth->role != "admin") {
                        $r = $this->_helper->email($user, $name, $sujet, $body);

                        if ($r)
                            $r = "message envoyé avec succès";
                        else
                            $r = "Echec d'envoi";
                    }
                    $this->view->my = $r;

                //$this->_helper->redirector('userlist');
                // Zend_Debug::dump($form->getValues());
                //  $this->_helper->redirector(array('controller'=>'membre','action'=>'index'));
                else:
                    echo "<strong style='color:red'>pseudo existant</strong>";
                endif;
            } else {
                $form->populate($data);
            }
        }
    }

    public function confirmationAction() {
        $login = $this->_getParam('user');
        // $login=$_GET['email'];
        //  Zend_Debug::dump($login);
        $user = new Application_Model_User();
        if ($user->activeUser($login))
            $this->render('confirmation');
        else
            $this->render('active');
    }

    public function testeAction() {
        $user = new Application_Model_User();
        $login = 'chardanmiss@yahoo.fr';
        echo "hello";
        $this->view->md = $user->activeUser($login);
        // Zend_Debug::dump($user->activeUser($login));
    }

    public function userlistAction() {
        $user = new Application_Model_User();
        $this->view->users = $user->fetchAll();
       //$user->getUsers();
    }

    public function updateAction() {
        $form = new Application_Form_LoginFormEdit();
        $this->view->form = $form;

        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost();
            if ($form->isValid($data)) {
                // $user = $form->getValue('email');
                $id = $form->getValue('id');
                $pass = $form->getValue('password');
                $name = $form->getValue('nom');
                //$date='now()';
                $salt = "12345";
                $role = "vendeur";
                $actif = 1;
                $auth = Zend_Auth::getInstance()->getIdentity();
                if ($auth->role == 'admin') {
                    $role = $form->getValue('role');
                }

                $model = new Application_Model_User();
                $model->updateUser($id, $pass, $salt, $role, $name);
                $this->_helper->redirector('userlist');
                Zend_Debug::dump($data);
            } else {
                $form->populate($data);
            }
        } else {
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                $model = new Application_Model_User();
                // Zend_Debug::dump($model->getId($id));
                $form->populate($model->getId($id));
            }
        }
    }

    /*cette action est appelée par ajax et
     * supprime un ou plusieurs users après
     * avoir été selectionnés
     */
    function deleteAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->view->title = "Supprimer un utilisateur";
        $id = $this->_getParam('id', 0);
        if(!empty($_POST['user_ids'])){
         Zend_Debug::dump($_POST);
         $t=  '('. implode(',',  $_POST['user_ids']).')';
         echo 'p=', $t;
         $user = new Application_Model_User();
       //   $user->delUser($t);
        }
       /* if ($id > 0) {
            
           
//                $where = 'id = ' . $id;
         //   $user->delUser($id);
          //  $this->_helper->redirector('userlist');
        }*/
    }

//end supprimer

    /* recupère le mot de passe oublié d'un user 
     * puis envoi du nouveau password par laik
     */

    public function checkpasswordAction() {
        $this->render('checkpassword');
        $url = 'http://' . $_SERVER['SERVER_NAME'];
        if ($this->getRequest()->isPost()) {
            $login = $this->getRequest()->getPost('email');
            $user = new Application_Model_User();
            if ($user->verifLogin($login)) {
                $salt = '12345';
                $newpass = $this->generatePassword(); //recupération du nouveau password généré

                $user->checkPassword($newpass, $salt, $login);
                //  if($this->sendPassword($login, $url, $newpass)){
                $sujet = "Nouveau mot de passe<";
                $body = "<p>votre nouveau mot de passe est :</p>";
                $body.="<p>$newpass</p>";
                $nom = $user->findName($login)['nom'];
                if ($this->_helper->email($login, $nom, $sujet, $body)) {
                    // $this->render('check');
                    echo "email envoyé";
                    $this->_helper->redirector->gotoSimple('check', 'user');
                    // echo "votre mot de passe a été envoyé à votre adresse mail";
                }/* else{
                  echo "<br/>Echec d'envoi du mot de passe";
                  } */
            }
            else
                echo "Adresse mail inconnue";
        }/* else{
          //$this->_helper->redirector->gotoUrl($url);
          $this->render('checkpassword');
          } */
    }

    public function checkAction() {
        $this->render('check');
    }

    /**
     *
     * @param type $length
     * @param type $strength
     * @return string 
     * 
     * Génère un mot de passe aléatoire dans le but
     * de l'envoyer à un user qui a oublié son mot de passe
     */
    function generatePassword($length = 9, $strength = 0) {
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($strength & 2) {
            $vowels .= "AEUY";
        }
        if ($strength & 4) {
            $consonants .= '23456789';
        }
        if ($strength & 8) {
            $consonants .= '@#$%';
        }

        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }

}

//end class

