<?php
// DB接続情報
try {
    require_once('funcs.php');
    $pdo = db_conn();

//1. POSTデータ取得
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $point = $_POST['point'] ?? null;
    $admin = $_POST['admin'];


    //     if (!$user_id || !$email || !$admin) {
    //     throw new Exception("必須項目が不足しています。");
    // }

//３．データ登録SQL作成
    $stmt = $pdo->prepare(
        'UPDATE
            user_master
        SET
            user_name = :user_name,
            email = :email,
            password = :password,
            point = :point,
            admin = :admin,
            updated = sysdate()
        WHERE
            user_id = :user_id'
    );

$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':user_name', $user_name ?: null, PDO::PARAM_STR);
$stmt->bindValue(':email', $email ?: null, PDO::PARAM_STR);
$stmt->bindValue(':password', $password ?: null, PDO::PARAM_STR);
$stmt->bindValue(':point', $point ?: null, PDO::PARAM_INT);
$stmt->bindValue(':admin', $admin, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

    var_dump($stmt->queryString);  // SQL クエリの内容を確認
    var_dump($params);  // 変数の内容を確認

//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    header('Location: bandai_user_select.php');
    exit();
}

// 成功メッセージを返す
// echo json_encode(['status' => 'success', 'message' => '温泉情報が保存されました。']);

} catch (Exception $e) {
    // エラーメッセージを返す
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>