<?php
// DB接続情報
try {
    require_once('funcs.php');
    $pdo = db_conn();

//1. POSTデータ取得
    $place_id = $_POST['place_id'] ?? null;
    $place_name = $_POST['place_name'] ?? null;
    $review_summary = $_POST['review_summary'];
    $facility_type = $_POST['facility_type'];
    $address = $_POST['address'] ?? null;
    $tel = $_POST['tel'] ?? null;
    $business_hours = $_POST['business_hours'] ?? null;
    $regular_holiday = $_POST['regular_holiday'] ?? null;
    $gensen_temp = $_POST['gensen_temp'] ?? null;
    $spring_quality = $_POST['spring_quality'] ?? null;
    $effect = $_POST['effect'] ?? null;
    $amenities = $_POST['amenities'] ?? null;
    $facilities = $_POST['facilities'] ?? null;
    $access = $_POST['access'] ?? null;
    $other_info = $_POST['other_info']?? null;

    //     if (!$place_id || !$place_name) {
    //     throw new Exception("必須項目が不足しています。");
    // }

//３．データ登録SQL作成
    $stmt = $pdo->prepare(
        'UPDATE
            gensen_master
        SET
            place_name = :place_name,
            review_summary = :review_summary,
            facility_type = :facility_type,
            address = :address,
            tel = :tel,
            business_hours = :business_hours,
            regular_holiday = :regular_holiday,
            gensen_temp = :gensen_temp,
            spring_quality = :spring_quality,
            effect = :effect,
            amenities = :amenities,
            facilities = :facilities,
            access = :access,
            other_info = :other_info,
            -- updated = sysdate()
        WHERE
            place_id = :place_id'
    );

$stmt->bindValue(':place_id', $place_id, PDO::PARAM_STR);
$stmt->bindValue(':place_name', $place_name, PDO::PARAM_STR);
$stmt->bindValue(':review_summary', $review_summary ?: null, PDO::PARAM_STR);
$stmt->bindValue(':facility_type', $facility_type ?: null, PDO::PARAM_STR);
$stmt->bindValue(':address', $address ?: null, PDO::PARAM_STR);
$stmt->bindValue(':tel', $tel ?: null, PDO::PARAM_STR);
$stmt->bindValue(':business_hours', $business_hours ?: null, PDO::PARAM_STR);
$stmt->bindValue(':regular_holiday', $regular_holiday ?: null, PDO::PARAM_STR);
$stmt->bindValue(':gensen_temp', $gensen_temp ?: null, PDO::PARAM_INT);
$stmt->bindValue(':spring_quality', $spring_quality ?: null, PDO::PARAM_STR);
$stmt->bindValue(':effect', $effect ?: null, PDO::PARAM_STR);
$stmt->bindValue(':amenities', $amenities ?: null, PDO::PARAM_STR);
$stmt->bindValue(':facilities', $facilities ?: null, PDO::PARAM_STR);
$stmt->bindValue(':access', $access ?: null, PDO::PARAM_STR);
$stmt->bindValue(':other_info', $other_info ?: null, PDO::PARAM_STR);
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