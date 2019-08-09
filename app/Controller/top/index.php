<?php

use Slim\Http\Request;
use Slim\Http\Response;

// TOPページのコントローラ
$app->get('/', function (Request $request, Response $response) {

    $data = [];

    if($this->session["user_info"] != null) {
      return $response->withRedirect('/main/');
    }
    // Render index view
    return $this->view->render($response, 'top/index.twig', $data);
});
