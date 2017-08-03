<?php
//application/models/UserModel.class.php
class UserModel extends Model{
    /**
     * @return array
     */
    public function getUsers(){
		$sql="select * from {$this->table}";
		$user=$this->db->getAll($sql);
		return $user;
	}
}