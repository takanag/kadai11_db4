<?php
// DB接続情報
try {
    require_once('funcs.php');
    $pdo = db_conn();

// URLからlike_idを取得
    $like_id = $_GET['like_id'] ?? null;

// like_idが指定されていない場合エラー
    if (!$like_id) {
        exit('Error: like_id is missing.');
    }

// データ削除SQL作成
    $stmt = $pdo->prepare('DELETE FROM like_master WHERE like_id = :like_id');
    $stmt->bindValue(':like_id', (int)$like_id, PDO::PARAM_INT);
    $status = $stmt->execute(); //実行

//４．データ削除処理後
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
?>