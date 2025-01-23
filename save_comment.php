<?php
header("Content-Type: application/json");

// DB接続、セッション開始関数の読み込み
session_start();
require_once('funcs.php');
$pdo = loginCheck();
$pdo = db_conn();

try {
    // POSTデータの取得
    $place_id = $_POST['place_id'] ?? null;
    $rating = $_POST['rating'] ?? null;
    $like_comment = $_POST['like_comment'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;
    $user_name = $_SESSION['user_name'] ?? null;

    // 必須項目のチェック
    if (!$place_id || !$rating) {
        throw new Exception("場所IDまたはコメントが不足しています。");
    }

    // SQLクエリの作成
    $sql = "INSERT INTO like_master (
        place_id, rating, like_comment, user_id, user_name, created, updated
    ) VALUES (
        :place_id, :rating, :like_comment, :user_id, :user_name, sysdate(), sysdate()
    )";

    // SQLステートメントを準備
    $stmt = $pdo->prepare($sql);

    // パラメータをバインド
    $stmt->bindParam(':place_id', $place_id);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':like_comment', $like_comment);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':user_name', $user_name);

    // クエリを実行
    $stmt->execute();

    // 成功メッセージを返す
    echo json_encode(['status' => 'success', 'message' => '温泉情報が保存されました。']);
} catch (Exception $e) {
    // エラーメッセージを返す
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
