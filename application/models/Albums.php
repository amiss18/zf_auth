<?php

class Application_Model_Albums extends Zend_Db_Table
{
    protected $_name = 'albums';
     protected $_fetchMode = Zend_Db::FETCH_OBJ;
     
    public function _construct(){
         //$this->getAdapter()->setFetchMode($this->_fetchMode);
        
}
    public function lister(){
       // $this->getAdapter()->setFetchMode($this->_fetchMode);
         $this->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
            $sql="SELECT * FROM albums ";
          $query= $this->getAdapter()->fetchAll($sql);
         // Zend_Debug::dump($query);
          // Zend_Debug::dump($this->fetchAll()->toArray());
         $select=$this->select()->from('albums',array('title'=>new Zend_Db_Expr('`titre`'),'artiste','id'));
          //  $select=$this->select();
          echo $select->__toString();
            try{
          //  $select=$this->select();
        //  echo $select->__toString();
        return $query;
	//return $this->fetchAll($select);
            }  catch (Zend_Db_Exception $e){
            printf($e->getMessage());
            }
	}


	 public function obtenirAlbum($id)
    {
             $db=$this->getAdapter();
        $id = (int)$id;
        $select=  $this->select()->where($db->quoteIdentifier("id").'=?',$id);
      //  $row = $this->fetchRow($db->quoteIdentifier("id").'=?', $id);
          $row = $this->fetchRow($select);
        if (!$row) {
            throw new Exception("Impossible de trouver l'enregistrement $id");
        }
        return $row->toArray();
    }

    public function ajouterAlbum($artiste, $titre)
    {
        $data = array(
            'artiste' => $artiste,
            'titre' => $titre,
        );
        $this->insert($data);
    }

    public function modifierAlbum($id, $artiste, $titre)
    {
        $data = array(
            'id'=>new Zend_Db_Expr('`id`+10'),
            'artiste' => $artiste,
            'titre' => $titre,
        );
       $d= $this->update($data, 'id = '. (int)$id);
        //echo $d;
    }

    public function supprimerAlbum($id)
    {
        $this->delete('id =' . (int)$id);
    }

}

