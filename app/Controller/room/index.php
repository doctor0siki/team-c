<?php

use Model\Dao\ParentAttribute;
use Model\Dao\RoomUser;
use Slim\Http\Request;
use Slim\Http\Response;

// 部屋選択ページコントローラ
$app->get('/room/select', function (Request $request, Response $response) {

    //GETされた内容を取得します。
    $data = $request->getQueryParams();

    // Render index view
    return $this->view->render($response, 'room/select.twig', $data);

});

//部屋入室コントローラ
$app->get('/room/{id}', function (Request $request, Response $response, array $args) {

    if($this->session["user_info"] == null) {
      return $response->withRedirect('/login/');
    }

    //POSTされた内容を取得します
    $data = $request->getParsedBody();

    //URLパラメータの内容を
    $params["id"] = $args["id"];

    //親属性を取得します
    $parent_attr = new ParentAttribute($this->db);

    //親属性を取得します
    $room_user = new RoomUser($this->db);

    //いまこのルームに居るユーザーを取得する。
    $data["users"] = $room_user->getRoomUser($params["id"]);

    //ルーム情報を取得します。
    $data["room_data"] = $parent_attr->select($params);

    // Render index view
    return $this->view->render($response, 'room/index.twig', $data);

});
