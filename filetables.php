<?php

/**
* File tables
*
* @author Petar Benke <petar@benke.co.uk>
* @version 1.0
*
*/

class FileTables{

	private $file;
	private $type;
    private $allowedTypes = array('json');
    private $table = array();

	public function __construct($file, $type = 'json'){

        if(strlen($file)) $this->file = $file;

        if(file_exists($this->file)){
            $this->type = in_array($type, $this->allowedTypes) ? $type : 'json';
            $fh = fopen($this->file, "r");
            if($this->type == 'json') $this->table = json_decode(file_get_contents($this->file), true);
            fclose($fh);
        } else{
            return false;
        }

	}

    private function saveChanges(){

        if(strlen($this->file)){
            $fh = fopen($this->file, "w");
            fwrite($fh, json_encode($this->table));
            fclose($fh);
            return true;
        } else{
            return false;
        }

    }

    public function getAll(){

        return $this->table;

    }

    public function getById($id = 0){

        return isset($this->table[$id]) ? $this->table[$id] : array();

    }

    public function updateById($id = 0, $values = array()){

        //does both insert (by id) and update by id
        if(!isset($this->table[$id])) $this->table[$id] = array();
        foreach($values as $key => $value) $this->table[$id][$key] = $value;
        return $this->saveChanges();

    }

    public function insert($values = array()){

        //just pushes new record into the table, if possible
        if(count($this->table)){
            $lastId = max(array_keys($this->table));
            if( (string)(int) $lastId === (string) $lastId ) $id = $lastId + 1;
            else return false;//not integer ids
        } else{
            $id = 1;
        }
        return $this->updateById($id, $values);

    }

    public function insertById($id = 0, $values = array()){

        //alias ;-)
        return $this->updateById($id, $values);

    }

    public function deleteById($id = 0){

        if(isset($this->table[$id])){
            unset($this->table[$id]);
            return $this->saveChanges();
        } else{
            return false;
        }

    }

}
