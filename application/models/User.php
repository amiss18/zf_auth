<?php

class Application_Model_User extends Zend_Db_Table_Abstract
{

     protected  $_name='user';
     
    

       
     public function getUsers(){
        // $sql=  $this->select()->from('user')
          //       ->where("id in (1,3,5,6)");
       //  $where[] = $db->quoteInto('id in ', $first_id);
        // $sql= $this->delete('id in' . '(12,14)');
                  
        // echo $sql->__toString();
         //$query=  $this->fetchAll($sql);
         Zend_Debug::dump($sql);
         return $sql;
     }

     /***         
      * ajout d'un utilisateur simple(vendeur), où le champ actif
      * est par défaut à 0
      */
          public function addUser($user,$pass,$salt,$role,$date,$actif,$name){
        $data=array(
            'email'=>$user,
            'password'=>SHA1($pass.$salt),
            'salt'=>$salt,
            'role'=>$role,
            'date_created'=>$date,
            'actif'=>$actif,
            'nom'=>$name,
            'clef' => md5($user),
        );
        try{
            //if(!$this->verifLogin($user))
            $this->insert($data);
          //  else echo "<strong style='color:red'>pseudo existant</strong>";
          //  return FALSE;
        }  catch (Zend_Db_Exception $e){
            printf("erreur insertion bd %s:", $e->getMessage());
        }
       // return TRUE;
    }
    /* donne le nom de l'utilisateur dont le
     * login est renseigné en paramètre
     */
      public function findName($login) {
           
        //$select=  $this->select()->from('user', 'email')->where('email =?', $login);
          $where = $this->getAdapter()->quoteInto('email= ?', $login);
        $select=  $this->select()->from('user', array('nom','email'))->where($where);
        
        $query=  $this->fetchAll($select);
        return $query->toArray();
       }
    
 
        /**
         *
         * @param type $login
         * @return boolean 
         * verifie le login d'un utilisateur se trouve ds la bd
         * renvoie true si login est djà existant et false sinon
         */
       public function verifLogin($login) {
           
        //$select=  $this->select()->from('user', 'email')->where('email =?', $login);
          $where = $this->getAdapter()->quoteInto('email= ?', $login);
        $select=  $this->select()->from('user', 'email')->where($where);
        
        $query=  $this->fetchAll($select);
        $c=count($query->toArray());
        if($c !=0)
            return TRUE;
        return FALSE;

      
       }
       /** active le compte d'un utilisateur sinon 
        * le compte a déjà été activé
        *
        * 
        * @param type $login
        * @return boolean 
        */
         public function activeUser($login){
                 // $db->quoteInto("(password = SHA1(CONCAT(salt, ?)))", $password)));
          //   $where=$this->getAdapter()->quoteInto("email = md5(email )", $login);
             $where = $this->getAdapter()->quoteInto('clef = ?', $login);
           $select=  $this->select()->from('user', array('id','actif','nom','email' ))
                  // ->where('email =?',  $this->getAdapter()->quoteInto($login));
                    ->where($where);
           // echo '<br>',$select;
           $query=$this->fetchRow($select)->toArray();
           if($query && $query['actif']==0){
             $this->confirmeUser( $query['id']);
              return TRUE;
           }
           return FALSE;
       // Zend_Debug::dump($query);
        //   return $query;
       }
       
       
       /**
        *
        * 
        * @param type $actif
        * @param type $login 
        * mise à jour du champ actif à 1 dont le login est renseigné
        */
       
       public function confirmeUser($id){
           $data=array(
               'actif'=>'1',
           );
           
           try{
               $this->update($data, 'id='.(Int)$id);
          // $this->update($data, 'email='.$this->getAdapter()->quote($login));
           //echo "<br/>compt est actif 1";
        }  catch (Zend_Db_Exception $e){
            printf("Echec conf %s:", $e->getMessage());
        }
           
       }




       public function updateUser($id,$newpass,$salt,$role,$name){

            $data=array(
            'password'=>SHA1($newpass.$salt),
            'salt'=>$salt,
            'role'=>$role,
            'nom'=>$name,
        );
           
        $where='id='.(int)$id;
        try{
             $this->update($data, $where); //maj autorisé car pass dans bd
              echo "Edification effectuée avec succès";
      
        }  catch (Zend_Db_Exception $e){
            printf("erreur f'édition %s:", $e->getMessage());
        }

    }
    
    public function getEmail($email){
        return $this->fetchRow('email='.$this->getAdapter()->quote($email))->toArray();
    }
    
   
    
      public function getId($id){
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Impossible de trouver l'enregistrement $id");
        }
        return $row->toArray();
    }
    }
    
     public function delUser($id)
    {
         try{
         // $sql= $this->delete('id in' . '(12,14)');
         //$where[] = $db->quoteInto('first_id = ?', $first_id);
      $sql= $this->delete('id in' . $id);
       // $this->delete('id =' . (int)$id);
         }catch(Zend_Db_Exception $e){
             echo "Erreur sql:",$e->getMessage();
         }
    }
    
       public function checkPassword($newpass,$salt,$login){

            $data=array(
            'password'=>SHA1($newpass.$salt),
           // 'salt'=>$salt,
        );
           
        try{
            $this->update($data, 'email='.$this->getAdapter()->quote($login));
              echo "Votre mot de passe vient d'être envoyé à votre adresse mail<br/>";
      
        }  catch (Zend_Db_Exception $e){
            printf("erreur de récuperation du mot de passe %s:", $e->getMessage());
            
        }

    }

    
   
    
    
}//end

