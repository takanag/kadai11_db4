<?php

//最初にSESSIONを開始！！ココ大事！！
session_start();

//POST値を受け取る
$email = $_POST['email'];
$password = $_POST['password'];

//1.  DB接続します
require_once('funcs.php');
$pdo = db_conn();

//2. データ登録SQL作成
// user_masterに、emailとpasswordがあるか確認する。
// $stmt = $pdo->prepare('SELECT * FROM gs_user_table WHERE lid = :lid AND lpw = :lpw');
$stmt = $pdo->prepare('SELECT * FROM user_master WHERE email = :email;');
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
// $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if ($status === false) {
    sql_error($stmt);
}
//ここから下はtrueの場合のコマンド（ifを書く必要なし）

//4. 抽出データ数を取得
$val = $stmt->fetch(); //データを一行取ってくる

if(password_verify($password, $val['password'])){ //* PasswordがHash化の場合はこっちのIFを使う
// if ($val['email'] != '' && password_verify($password, $val['password'])) {
    //Login成功時 該当レコードがあればSESSIONに値を代入
    $_SESSION['check_ssid'] = session_id();
    $_SESSION['admin'] = (int)$val['admin'];
    $_SESSION['user_name'] = $val['user_name'];
    $_SESSION['user_id'] = (int)$val['user_id'];


    
    // $_SESSION['admin'] = $val['admin']; //管理者なら1、それ以外は0が入る
    // header('Location: top_menu.php');

    if ($_SESSION['admin'] === 1) {
        redirect ('top_admin_menu.php');
    } elseif ($_SESSION['admin'] === 0) {
        redirect ('top_menu.php');
    }


} else {
    //Login失敗時(Logout経由)
    header('Location: index.html');
}

exit();
?>
