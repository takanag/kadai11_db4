<?php
//1. POSTデータ取得
$like_id = $_POST['like_id'];
$place_id = $_POST['place_id'];
// $user_id = $_POST['user_id'];
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$like_comment = $_POST['like_comment'];
$rating = $_POST['rating'];
$created = $_POST['created'];
$updated = $_POST['updated'];


//2. DB接続
session_start();
require_once 'funcs.php';
loginCheck();
$pdo = db_conn();

//3．データ登録SQL作成
$stmt = $pdo->prepare('INSERT INTO like_master(like_id, place_id, user_id, user_name, like_comment, rating, created, updated)VALUES(:like_id, :place_id, :user_id, :user_name, :like_comment, :rating, sysdate(),sysdate());');
$stmt->bindValue(':like_id', $like_id, PDO::PARAM_INT);
$stmt->bindValue(':place_id', $email, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
$stmt->bindValue(':like_comment', $like_comment, PDO::PARAM_STR);
$stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
$stmt->bindValue(':created', $rating, PDO::PARAM_INT);
$stmt->bindValue(':updated', $rating, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//4．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect('input.html');
}
