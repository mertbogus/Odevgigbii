<?php

class Users extends CI_Model {

    public $tableName = 'Users';

    public function get($where = array()){
        return $this->db->where($where)->get($this->tableName)->result();
    }

    public function insert($data){
        return $this->db->insert($this->tableName,$data);
    }

    public function delete($where = array()){
        return $this->db->where($where)->delete($this->tableName);
    }

}