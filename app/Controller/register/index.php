<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Model\Dao\User;
use Model\Dao\ParentAttribute;
use Model\Dao\ChildAttribute;
use Model\Dao\UserAttribute;

// 会員登録ページコントローラ
$app->get('/register/', function (Request $request, Response $response) {


    //GETされた内容を取得します。
    $data = $request->getQueryParams();
    $parent_attribute = new ParentAttribute($this->db);
    $child_attribute = new ChildAttribute($this->db);

    $param = array();
    $data["parent_attribute"] = $parent_attribute->select(array("register_display" => 1),"","","",true);
    $data["child_attribute"] = $child_attribute->select($param,"","","",true);

    // Render index view
    return $this->view->render($response, 'register/register.twig', $data);

});

// 会員登録処理コントローラ
$app->post('/register/', function (Request $request, Response $response) {

    //POSTされた内容を取得します
    $data = $request->getParsedBody();


    //ユーザーDAOをインスタンス化
    $user = new User($this->db);
    $userAttribute = new UserAttribute($this->db);
    $parent_attribute = new ParentAttribute($this->db);
    $child_attribute = new ChildAttribute($this->db);

    //入力されたメールアドレスの会員が登録済みかどうかをチェックします
    if ($user->select(array("email" => $data["email"]), "", "", 1, false)) {

        //入力項目がマッチしない場合エラーを出す
        $data["error"] = "このメールアドレスは既に会員登録済みです";

        // 入力フォームを再度表示します

        $param = array();
        $data["parent_attribute"] = $parent_attribute->select(array("register_display" => 1),"","","",true);
        $data["child_attribute"] = $child_attribute->select($param,"","","",true);

        return $this->view->render($response, 'register/register.twig', $data);

    }

    //DB登録に必要ない情報は削除します
    unset($data["password_re"]);

    $userData = $data;
    $attributeDataRaw = $data;
    $attributeData;
    array_splice($userData, 3);
    array_splice($attributeDataRaw, 0, 3);

    //DBに登録をする。戻り値は自動発番されたIDが返ってきます
    $id = $user->insert($userData);

    foreach($attributeDataRaw as $key => $value1) {
      foreach($value1 as $value2) {
        $attributeData["user_id"] = $id;
        $attributeData["child_attribute_id"] = $value2;
        // attributeのダブリ判断
        // $attributeDuplicateFlag = $parent_attribute->select(array($attributeData, "", "", 1, false);
        // if(!$attributeDuplicateFlag) { }
        $userAttribute->insert($attributeData);
      }
    }

    //今登録された情報を発番されたIDで引き、会員情報を取得します（会員登録後の自動ログイン処理のため）
    $result = $user->select(array("id" => $id), "", "", 1, false);

    //セッションにユーザー情報を登録（ログイン処理）
    $this->session->set('user_info', $result);

    // 登録完了ページを表示します。
    return $this->view->render($response, 'register/register_done.twig', $data);

});
