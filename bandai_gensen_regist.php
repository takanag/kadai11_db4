<?php
// 1. POSTデータ取得
$place_id = $_POST['place_id'] ?? null;
$place_name = $_POST['place_name'] ?? null;
$review_summary = $_POST['review_summary'] ?? null;
$facility_type = $_POST['facility_type'] ?? null;
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
$other_info = $_POST['other_info'] ?? null;

// 必須項目のチェック
if (!$place_id || !$place_name) {
    throw new Exception("場所IDまたは名前が不足しています。");
}

// 2. DB接続
require_once('funcs.php');
$pdo = db_conn();

// 3. データ登録SQL作成
$stmt = $pdo->prepare(
    'INSERT INTO gensen_master (
        place_id, place_name, review_summary, facility_type, address, tel, 
        business_hours, regular_holiday, gensen_temp, spring_quality, effect, 
        amenities, facilities, access, other_info, created, updated
    ) VALUES (
        :place_id, :place_name, :review_summary, :facility_type, :address, :tel, 
        :business_hours, :regular_holiday, :gensen_temp, :spring_quality, :effect, 
        :amenities, :facilities, :access, :other_info, sysdate(), sysdate()
    )'
);

$stmt->bindParam(':place_id', $place_id, PDO::PARAM_STR);
$stmt->bindParam(':place_name', $place_name, PDO::PARAM_STR);
$stmt->bindParam(':review_summary', $review_summary, PDO::PARAM_STR);
$stmt->bindParam(':facility_type', $facility_type, PDO::PARAM_STR);
$stmt->bindParam(':address', $address, PDO::PARAM_STR);
$stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
$stmt->bindParam(':business_hours', $business_hours, PDO::PARAM_STR);
$stmt->bindParam(':regular_holiday', $regular_holiday, PDO::PARAM_STR);
$stmt->bindParam(':gensen_temp', $gensen_temp, PDO::PARAM_STR);
$stmt->bindParam(':spring_quality', $spring_quality, PDO::PARAM_STR);
$stmt->bindParam(':effect', $effect, PDO::PARAM_STR);
$stmt->bindParam(':amenities', $amenities, PDO::PARAM_STR);
$stmt->bindParam(':facilities', $facilities, PDO::PARAM_STR);
$stmt->bindParam(':access', $access, PDO::PARAM_STR);
$stmt->bindParam(':other_info', $other_info, PDO::PARAM_STR);

try {
    $stmt->execute(); // 実行
    echo json_encode(["success" => true, "message" => "温泉情報が保存されました。"]);
} catch (PDOException $e) {
    echo json_encode(["error" => "SQLエラー: " . $e->getMessage()]);
    error_log("SQLエラー: " . $e->getMessage());
    exit;
}
