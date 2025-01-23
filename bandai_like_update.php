<?php
//1. POSTデータ取得
$like_id = $_POST['like_id'];
$place_id = $_POST['place_id'];
$user_id = $_POST['user_id'];
$like_comment = $_POST['like_comment'];
$rating = $_POST['rating'];


// 2. DB接続
try {
    require_once('funcs.php');
    $pdo = db_conn();

    //3．データ登録SQL作成
    $stmt = $pdo->prepare(
        'UPDATE
            like_master
        SET
            place_id = :place_id,
            user_id = :user_id,
            like_comment = :like_comment,
            rating = :rating,
            updated = sysdate()
        WHERE
            like_id = :like_id'
    );

    $stmt->bindValue(':like_id', $like_id, PDO::PARAM_INT);
    $stmt->bindValue(':place_id', $place_id, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':like_comment', $like_comment, PDO::PARAM_STR);
    $stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
    // $stmt->bindValue(':created', $rating, PDO::PARAM_INT);
    // $stmt->bindValue(':updated', $rating, PDO::PARAM_INT);
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
        header('Location: bandai_like_select.php');
        exit();
    }

    // 成功メッセージを返す
    // echo json_encode(['status' => 'success', 'message' => '温泉情報が保存されました。']);

} catch (Exception $e) {
    // エラーメッセージを返す
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
