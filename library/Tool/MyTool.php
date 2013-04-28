<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Tool_MyTool{
 
    
        public static function doesUrlMatchServerHttpHost($url)
    {       
        $scheme = Zend_Controller_Front::getInstance()->getRequest()->getScheme();
        $httpHost = Zend_Controller_Front::getInstance()->getRequest()->getHttpHost();
        $needleUrl = $scheme.'://'.$httpHost.'/';
        if (strpos($url, $needleUrl) !== 0)
        {
            return false;
        }
        return true;
    }

    public static function safelyGetReferrerUrl($default)
    {
        if ( isset($_SERVER['HTTP_REFERER']) == false){
            return $default;
        }
        if (self::doesUrlMatchServerHttpHost($_SERVER['HTTP_REFERER']) == false){
            return $default;
        }
        return $_SERVER['HTTP_REFERER'];
    }
}//
    

?>
