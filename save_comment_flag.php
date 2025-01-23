<?php
header("Content-Type: application/json");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// DB接続、セッション開始関数の読み込み
session_start();
require_once('funcs.php');
$pdo = db_conn();
loginCheck();

// 新しいコメントの登録処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // JSONデータの取得とデコード
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if ($data === null) {
        error_log("JSONデコードエラー: " . json_last_error_msg());
        echo json_encode(["error" => "無効なJSONデータです"]);
        exit;
    }

    $place_id = $data['place_id'] ?? null;
    $rating = $data['rating'] ?? null;
    $like_comment = $data['like_comment'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;
    $user_name = $_SESSION['user_name'] ?? null;
    
    if ($place_id && is_numeric($rating) && $like_comment) {
        $insertQuery = "INSERT INTO like_master (place_id, user_id, user_name, rating, like_comment, created, updated) VALUES (:place_id, :user_id, :user_name, :rating, :like_comment, sysdate(), sysdate())";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->bindParam(':place_id', $place_id, PDO::PARAM_STR);
        $insertStmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $insertStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $insertStmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $insertStmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $insertStmt->bindParam(':like_comment', $like_comment, PDO::PARAM_STR);

        try {
            $insertStmt->execute();
            echo json_encode(["success" => true, "message" => "コメントが登録されました"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "SQLエラー: " . $e->getMessage()]);
            error_log("SQLエラー: " . $e->getMessage());
            exit;
        }
    } else {
        echo json_encode(["error" => "不正な入力値です"]);
    }
}

