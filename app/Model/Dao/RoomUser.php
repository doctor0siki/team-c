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
}
