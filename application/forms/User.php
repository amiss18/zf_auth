<?php

class Application_Form_User extends Application_Form_MyForm
{

    public function init()
    {
        $this->setName("login");
        $this->setMethod('post');
     
       /*    $this->addElement('hidden','id',array(
           'filters'=>array('Int'),
       )
               );
         */  
       $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');
        $this->addElement($id);

           
        $this->addElement('text', 'email', array(
            'id'=>'pseudo_check',
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => true,
            'label'      => 'Identifiant *:(votre email)',
           
        ));

        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => true,
            'label'      => 'Mot de passe:',
        ));
        $role = $this->createElement('select','role');
        $role->setLabel('Rôle:')
            ->addMultiOptions(array(
                    'admin' => 'Admin',
                    'moderateur' => 'Modérateur' ,
                    'vendeur' => 'Vendeur' 
                        ));
        
       $auth=  Zend_Auth::getInstance()->getIdentity();
       if(Zend_Auth::getInstance()->hasIdentity())
        if($auth->role=='admin')
           $this->addElement($role);

         $this->addElement('text', 'nom', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => true,
            'label'      => 'Nom:',
        ));

        $this->addElement('submit', 'login', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Valider',
        ));
    }



}

