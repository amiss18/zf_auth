<?php

class Application_Form_ValidateText extends Zend_Validate_Abstract
{

    
  const INVALID      	= 'textInvalid';
    const NOT_NAME    	= 'notName';
    const STRING_EMPTY	= 'textStringEmpty';
    const STRING_LENGTH = 'textStringLength';
    const NAME_TAKEN    = 'textNameTaken';

	protected static $_filter = null;
	protected $_allowEmpty;

    protected $_messageTemplates = array(
        self::INVALID      	=> 'Caractères invalides',
        self::NOT_NAME 		=> 'Ce champ contient des caractères non valides',
        self::STRING_EMPTY 	=> 'Ce champ ne peut être vide',
        self::STRING_LENGTH => '4 et 64 caractères requis',
        self::NAME_TAKEN    => 'Username is already taken'
    );

	public function isValid($value)
    {
		// Make sure a value was entered
        if(($value == null)||($value == ''))
        {
            $this->_error(self::STRING_EMPTY);
            return false;
        }

		// The value must be a string
        if (!is_string($value)) {
            $this->_error(self::INVALID);
            return false;
        }

		// Set the internal value to the input
        $this->_setValue($value);

                        $pattern = '/[a-zA-Z0-9]/';
		// Validate that the input is alphanumeric
//        $al = new Zend_Validate_Alnum();
                $al = new Zend_Validate_Regex($pattern);

        if(!$al->isValid($value))
        {
            $this->_error(self::INVALID);
            return false;
        }

		// Validate that the string length meets requirements
        $sl = new Zend_Validate_StringLength(array('min' => 4,'max' => 64));
        if(!$sl->isValid($value))
        {
            $this->_error(self::STRING_LENGTH);
            return false;
        }

		// Make sure the username doesn't already exist
     /*   if(Ashurex_Model_Mapper_User::isRegisteredUser($value))
        {
            $this->_error(self::NAME_TAKEN);
            return false;
        }
      * 
      */

        return true;
    }  
    
    
    
   
    
}//end

