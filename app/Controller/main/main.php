<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Model\Dao\ParentAttribute;
use Model\Dao\RoomUser;
use Model\Dao\Room;

$app->get('/main/', function(Request $request, Response $response){
  $data = $request->getQueryParams();

  $parent_attribute = new ParentAttribute($this->db);
  $room_user = new RoomUser($this->db);
  $data["user_infos"] = $this->session["user_info"];

  $param = array();
  $data["parent_attributes"] = $parent_attribute->select($param, "", "", "", true);
  $data["room_users"] = $room_user->get_room_user();
  return $this->view->render($response, '/main/main.twig', $data);
});
