<?php

use Slim\Http\Request;
use Slim\Http\Response;

// マイページのコントローラ
$app->get('/mypage', function (Request $request, Response $response) {

    $data = [];

    // Render index view
    return $this->view->render($response, 'mypage/index.twig', $data);

});

// マイページの更新コントローラ POSTです
//更新が終了するとマイページへ戻ります。
$app->post('/mypage/check', function (Request $request, Response $response) {

    $data = [];


    //mypageへリダイレクト
    return $response->withRedirect('/mypage');

});



