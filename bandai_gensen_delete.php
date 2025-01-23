<?php
// DB接続情報
try {
    require_once('funcs.php');
    $pdo = db_conn();

// URLからplace_idを取得
    $place_id = $_GET['place_id'] ?? null;

// place_idが指定されていない場合エラー
    if (!$place_id) {
        exit('Error: place_id is missing.');
    }

// データ削除SQL作成
    $stmt = $pdo->prepare('DELETE FROM gensen_master WHERE place_id = :place_id');
    $stmt->bindValue(':place_id', $place_id, PDO::PARAM_STR);
    $status = $stmt->execute(); //実行

//４．データ削除処理後
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    header('Location: bandai_gensen_select.php');
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