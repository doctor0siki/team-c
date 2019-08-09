<?php
namespace Model\Dao;

class RoomUser extends Dao
{
  public function get_room_user(){
    $sql = "select room_id, count(user_id) as room_member from room_user group by room_id";
       $statement = $this->db->prepare($sql);
       $statement->execute();
       return $statement->fetchAll();
  }
}
