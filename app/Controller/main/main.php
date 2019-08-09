<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Model\Dao\ParentAttribute;

$app->get('/main/', function(Request $request, Response $response){
  $data = $request->getQueryParams();

  $parent_attribute = new ParentAttribute($this->db);

  $param = array();
  $data["parent_attributes"] = $parent_attribute->select($param, "", "", "", true);
  // var_dump($data);
  return $this->view->render($response, '/main/main.twig', $data);
});
