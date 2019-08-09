<?php

namespace Model\Dao;

class RoomUser extends Dao
{
    public function getRoomUser(int $room_id)
    {

        $sql = "select id,name from room_user left join user on room_user.user_id =  user.id  ";

        // SQLをプリペア
        $statement = $this->db->prepare($sql);

        //SQLを実行
        $statement->execute();

        //結果レコードをFetchし、返送
        return $statement->fetchAll();

    }

    public function get_room_user()
    {
        $sql = "select room_id, count(user_id) as room_member from room_user group by room_id";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
}
