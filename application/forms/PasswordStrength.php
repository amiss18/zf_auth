<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PasswordStrength
 *
 * @author armel
 */
class Application_Form_PasswordStrength extends Zend_Validate_Abstract{
    //put your code here
    const LENGTH = 'length';
    const UPPER  = 'upper';
    const LOWER  = 'lower';
    const DIGIT  = 'digit';
    const STRING_EMPTY	= 'textStringEmpty';

    protected $_messageTemplates = array(
        self::LENGTH =>
            "'%value%' doit avoir une longueur d'au moins 4 caractères",
        self::UPPER  =>
            "'%value%' doit contenir au moins une lettre majuscule",
        self::LOWER  =>
            "'%value%' doit contenir au moins une lettre minuscule",
        self::DIGIT  =>
            "'%value%' doit contenir au moins un chiffre",
         self::STRING_EMPTY => 'Ce champ ne peut être vide'
    );

    public function isValid($value)
    {
        $this->_setValue($value);

        $isValid = true;

        if (strlen($value) < 4) {
            $this->_error(self::LENGTH);
            $isValid = false;
        }

        /*
        if (!preg_match('/[A-Z]/', $value)) {
            $this->_error(self::UPPER);
            $isValid = false;
        }

        if (!preg_match('/[a-z]/', $value)) {
            $this->_error(self::LOWER);
            $isValid = false;
        }

        if (!preg_match('/\d/', $value)) {
            $this->_error(self::DIGIT);
            $isValid = false;
        }
        */
       // Make sure a value was entered
        if(($value == null)||($value == ''))
        {
            $this->_error(self::STRING_EMPTY);
           $isValid = false;
        }


        return $isValid;
    }
}//

?>
