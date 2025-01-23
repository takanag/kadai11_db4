<?php

//1. bandai_like_select.phpから送られてくる対象のIDを取得
$like_id = $_GET['like_id'];

//2. DB接続
require_once('funcs.php');
$pdo = db_conn();

//3.データ登録SQL作成
// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt = $pdo->prepare('SELECT * FROM like_master WHERE like_id = :like_id;');
$stmt->bindValue(':like_id', (int)$like_id, PDO::PARAM_INT);
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
  <title>口コミ詳細</title>
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
    <h2>口コミ詳細</h2>
  </header>

  <main>
    <div class="form-container">
      <form method="POST" action="bandai_like_update.php">
        <fieldset>
          <legend>口コミ</legend>
          <input type="hidden" name="like_id" value="<?= $result['like_id'] ?>">
          <label>源泉ID：<input type="text" name="place_id" value="<?= $result['place_id'] ?>"></label>
          <label>会員ID：<input type="number" name="user_id" value="<?= $result['user_id'] ?>"></label>
          <label>コメント：<input type="text" name="like_comment" value="<?= $result['like_comment'] ?>"></label>
          <label>評価：<input type="number" name="rating" value="<?= $result['rating'] ?>"></label>
          <label>新規登録日時：<input type="text" name="created" value="<?= $result['created'] ?>"></label>
          <label>更新日時：<input type="text" name="updated" value="<?= $result['updated'] ?>"></label>
          <label>削除日時：<input type="text" name="deleted" value="<?= $result['deleted'] ?>"></label>
        </fieldset>
        <input type="submit" value="更新">
      </form>
      <a class="back-link" href="bandai_like_select.php">口コミ一覧に戻る</a>
    </div>
  </main>

  <footer>
    <p>&copy; 2024 源泉温泉検索</p>
  </footer>
</body>

</html>