<?php

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
$app->post('/room/{id}', function (Request $request, Response $response, array $args) {

    //POSTされた内容を取得します
    $data = $request->getParsedBody();

    $room_id = $args["id"];

    // Render index view
    return $this->view->render($response, 'room/index.twig', $data);


});
