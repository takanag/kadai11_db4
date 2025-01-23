<?php

// DB接続情報
require_once('funcs.php');
$pdo = db_conn();

// $host = 'mysql3104.db.sakura.ne.jp';
// $dbname = 'takanag_db_gensen';
// $username = 'takanag_db_gensen';
// $password = '9628Taka';

// $host = 'localhost';
// $dbname = 'db_gensen';
// $username = 'root';
// $password = '';

// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
// } catch (PDOException $e) {
//     exit('DBConnectError: ' . $e->getMessage());
// }

//２．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM gensen_master');
$status = $stmt->execute();

//3. 表形式のデータ作成
$view = '';
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('ErrorQuery: ' . $error[2]);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<tr>';
        // $view .= '<td>' . htmlspecialchars($result['place_id'], ENT_QUOTES, 'UTF-8') . '</td>';
        $view .= '<td>' . htmlspecialchars($result['name'], ENT_QUOTES, 'UTF-8') . '</td>';
        $view .= '<td>' . htmlspecialchars($result['review_summary'], ENT_QUOTES, 'UTF-8') . '</td>';
        $view .= '<td>' . htmlspecialchars($result['facility_type'], ENT_QUOTES, 'UTF-8') . '</td>';
        $view .= '<td>' . htmlspecialchars($result['address'], ENT_QUOTES, 'UTF-8') . '</td>';
        $view .= '<td>' . htmlspecialchars($result['tel'], ENT_QUOTES, 'UTF-8') . '</td>';
        $view .= '<td>' . htmlspecialchars($result['business_hours'], ENT_QUOTES, 'UTF-8') . '</td>';
        $view .= '<td>' . htmlspecialchars($result['regular_holiday'], ENT_QUOTES, 'UTF-8') . '</td>';
        $view .= '<td>' . htmlspecialchars($result['gensen_temp'], ENT_QUOTES, 'UTF-8') . '</td>';
        $view .= '<td>' . htmlspecialchars($result['spring_quality'], ENT_QUOTES, 'UTF-8') . '</td>';
        $view .= '<td>' . htmlspecialchars($result['effect'], ENT_QUOTES, 'UTF-8') . '</td>';
        $view .= '<td>' . htmlspecialchars($result['amenities'], ENT_QUOTES, 'UTF-8') . '</td>';
        $view .= '<td>' . htmlspecialchars($result['facilities'], ENT_QUOTES, 'UTF-8') . '</td>';
        $view .= '<td>' . htmlspecialchars($result['access'], ENT_QUOTES, 'UTF-8') . '</td>';
        $view .= '<td>' . htmlspecialchars($result['other_info'], ENT_QUOTES, 'UTF-8') . '</td>';
        $view .= '</tr>';
    }
}
echo $view;