<?php

class Application_Form_LoginFormEdit extends Application_Form_MyForm
{

   public function init()
    {
        $this->setName("update");
        $this->setMethod('post');
       // $this->setAction('update');
       $this->addElement('hidden','id',array(
           'filters'=>array('Int'),
       )
               );
         $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(3, 50)),
            ),
            'required'   => true,
            'label'      => 'Nouveau mot de passe:',
        ));
             
         $role = $this->createElement('select','role');
        $role->setLabel('Rôle:')
            ->addMultiOptions(array(
                    'admin' => 'Admin',
                    'moderateur' => 'Modérateur' ,
                    'vendeur' => 'Vendeur' 
                        ));
        
       $auth=  Zend_Auth::getInstance()->getIdentity();
        if($auth->role=='admin')
           $this->addElement($role);

        
          $this->addElement('text', 'nom', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', false, array(2, 50)),
            ),
            'required'   => true,
            'label'      => 'Nom:',
        ));
        
       
        

        $this->addElement('submit', 'login', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Edition profile',
        )); 
        
    }


}//end

