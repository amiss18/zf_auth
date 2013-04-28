<?php
//Twitter_Bootstrap_Form_Vertical// 
class Application_Form_LoginForm extends Application_Form_MyForm
{

    
     public function init()
    {
        $this->setName("login");
        $this->setMethod('post');
        $this->setAttrib('class', 'form-horizontal');
         $this->setAttrib('class', 'badge');
     
      
       $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');
        $this->addElement($id);

        $uri=new Zend_Form_Element_Hidden('uri');
        $uri->setValue($_SERVER['REQUEST_URI']);
        $this->addElement($uri);
        
        $login=new Zend_Form_Element_Text('email');
        $login->setAttrib('placeholder', 'Login(email) *')
              
             // ->setAttrib('required', 'true')
              ->setRequired()
              
            /*  ->addValidator('regex', false, array('/^[a-zA-Z0-9]/'))
              ->addValidator('stringLength', false, array(4, 50))
              ->addValidator('NotEmpty')
              ->addFilter('StringToLower');*/
              ->addValidator(new Application_Form_ValidateText());
        
       
                
        $this->addElement($login);

         $password=new Zend_Form_Element_Password('password');
         //$password->setAttribs(array('required'=>'true', 'placeholder'=>'mot de passe *'))
        
               $password->setRequired()
                       
                ->addValidator(new Application_Form_PasswordStrength());
         
         
         $this->addElement($password);
         
                 // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
      
     /*   $this->addElement('submit', 'log', array(
    'decorators'=>array(
    'ViewHelper',
    'Label',
    array('HtmlTag', array('tag' => 'div')),
    ),
   // 'attribs' => array('class' => 'btn btn-primary')
));*/
        
       
        
        
       $this->addElement('submit', 'login', array(
            'class'   => 'btn ',
            'label'    => 'Valider',
        ));
        
        
      /*
        
       $this->addElement('submit', 'login', array(
            'required' => false,
           'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
            'ignore'   => true,
            'label'    => 'Valider',
           // 'class'    => 'btn btn-primary',
            //'prepend' => '<i class="icon-user icon-white"></i>'
        ));*/
       
       
       
    }


    
    
    
   

}//end


/*->addValidator('stringLength', false, array(4, 40))
              ->addValidator('NotEmpty');*/