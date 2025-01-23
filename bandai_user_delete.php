<?php
// DB接続情報
try {
    require_once('funcs.php');
    $pdo = db_conn();

// URLからuser_idを取得
    $user_id = $_GET['user_id'] ?? null;

// user_idが指定されていない場合エラー
    if (!$user_id) {
        exit('Error: user_id is missing.');
    }

// データ削除SQL作成
    $stmt = $pdo->prepare('DELETE FROM user_master WHERE user_id = :user_id');
    $stmt->bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);
    $status = $stmt->execute(); //実行

//４．データ削除処理後
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