<?php

//1. bandai_gensen_select.phpから送られてくる対象のIDを取得
$place_id = $_GET['place_id'];

//2. DB接続
require_once('funcs.php');
$pdo = db_conn();

//3.データ登録SQL作成
// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt = $pdo->prepare('SELECT * FROM gensen_master WHERE place_id = :place_id;');
$stmt->bindValue(':place_id', $place_id, PDO::PARAM_STR);
$status = $stmt->execute();

// [定番] データ表示
$result = '';
if ($status === false) {
  $error = $stmt->errorInfo();
  exit('SQLError:' . print_r($error, true));
} else {
  $result = $stmt->fetch();
}

//中身を出力
// var_dump($result);

?>

<!-- HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
(入力項目は「登録/更新」はほぼ同じになるから)
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み" -->

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>源泉登録情報詳細</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
      color: #333;
    }

    header {
      background-color: #6c6c6c;
      color: white;
      padding: 20px 10px;
      text-align: center;
    }

    header h1 {
      margin: 0;
      font-size: 1.8rem;
    }

    main {
      padding: 20px;
      text-align: center;
    }

    .form-container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }

    .form-container fieldset {
      border: none;
      padding: 0;
    }

    .form-container label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }

    .form-container input[type="text"],
    .form-container input[type="hidden"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    .form-container input[type="submit"] {
      background-color: #ff6347;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .form-container input[type="submit"]:hover {
      background-color: #ff4500;
    }

    footer {
      margin-top: 20px;
      text-align: center;
      font-size: 0.8rem;
      color: #666;
    }

    .back-link {
      text-decoration: none;
      color: white;
      background-color: #6c6c6c;
      padding: 10px 20px;
      border-radius: 5px;
      display: inline-block;
      margin-top: 10px;
      transition: background-color 0.3s ease;
    }

    .back-link:hover {
      background-color: #aeadad;
    }

    @media (max-width: 600px) {
      header h1 {
        font-size: 1.5rem;
      }

      main p {
        font-size: 0.9rem;
      }

      .menu a {
        font-size: 0.9rem;
        padding: 8px 16px;
      }
    }
  </style>
</head>

<body>
  <header>
    <h2>源泉登録情報詳細</h2>
  </header>

  <main>
    <div class="form-container">
      <form method="POST" action="bandai_gensen_update.php">
        <fieldset>
          <legend>源泉登録情報</legend>
          <input type="hidden" name="place_id" value="<?= $result['place_id'] ?>">
          <label>名前：<input type="text" place_name="place_name" value="<?= $result['place_name'] ?>"></label>
          <label>レビュー要約：<input type="text" name="review_summary" value="<?= $result['review_summary'] ?>"></label>
          <label>施設タイプ：<input type="text" name="facility_type" value="<?= $result['facility_type'] ?>"></label>
          <label>住所：<input type="text" name="address" value="<?= $result['address'] ?>"></label>
          <label>電話番号：<input type="text" name="tel" value="<?= $result['tel'] ?>"></label>
          <label>営業時間：<input type="text" name="business_hours" value="<?= $result['business_hours'] ?>"></label>
          <label>定休日：<input type="text" name="regular_holiday" value="<?= $result['regular_holiday'] ?>"></label>
          <label>泉質：<input type="text" name="spring_quality" value="<?= $result['spring_quality'] ?>"></label>
          <label>効能：<input type="text" name="effect" value="<?= $result['effect'] ?>"></label>
          <label>アメニティ：<input type="text" name="amenities" value="<?= $result['amenities'] ?>"></label>
          <label>施設：<input type="text" name="facilities" value="<?= $result['facilities'] ?>"></label>
          <label>アクセス：<input type="text" name="access" value="<?= $result['access'] ?>"></label>
          <label>その他の情報：<input type="text" name="other_info" value="<?= $result['other_info'] ?>"></label>
        </fieldset>
        <input type="submit" value="更新">
      </form>
      <a class="back-link" href="bandai_gensen_select.php">源泉データ一覧に戻る</a>
    </div>
  </main>

  <footer>
    <p>&copy; 2024 源泉温泉検索</p>
  </footer>
</body>

</html>