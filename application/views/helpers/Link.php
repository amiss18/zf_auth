<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Zend_View_Helper_Link
 *
 * @author armel
 */
class Zend_View_Helper_Link extends Zend_View_Helper_Url
{
    //put your code here

    public function link($controllerName = null,
                         $actionName = null,
                         $moduleName = null,
                         $params = '' , $name = 'default', $reset = true
            )
    {

        $fc=Zend_Controller_Front::getInstance();
        if($controllerName == null){
            $controllerName = $fc->getRequest()->getParam('controller');
        }
        if($actionName == null){
            $actionName = $fc->getRequest()->getParam('action');
        }
        if(is_array($params)){
            $params = '?' . http_build_query($params);
             //$params = http_build_query($params);
        }
        return parent::url(array(
            'controller'=>$controllerName,
            'action'=>$actionName,
            'module'=>$moduleName), $name, $reset . $params

        );

    }
}
?>
