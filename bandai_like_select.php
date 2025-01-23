<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>番台メニュー：口コミを管理</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background-color: #808080;
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

        main p {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .table-container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #808080;
            color: white;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .jumbotron table {
            width: 100%;
            border-collapse: collapse;
        }

        .jumbotron th,
        .jumbotron td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
        }

        .menu a {
            text-decoration: none;
            background-color: #808080;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: bold;
            width: 100%;
            max-width: 300px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .menu a:hover {
            background-color: #696969;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .button-edit,
        .button-delete {
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .button-edit {
            background-color: #32CD32;
            /* 緑 */
            color: white;
        }

        .button-edit:hover {
            background-color: #2e9e2e;
        }

        .button-delete {
            background-color: #FF6347;
            /* 赤 */
            color: white;
        }

        .button-delete:hover {
            background-color: #d9534f;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .status-on {
            background-color: #32CD32;
            /* ON */
            color: white;
        }

        .status-off {
            background-color: #FF6347;
            /* OFF */
            color: white;
        }

        .search-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .search-input {
            width: 80%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .export-button {
            padding: 8px 16px;
            background-color: #808080;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.8rem;
            color: #666;
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
        <h2>番台メニュー：口コミを管理</h2>
    </header>

    <main>
        <div class="table-container">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="検索...">
                <button class="export-button">エクスポート</button>
            </div>
            <h3>口コミ一覧</h3>

            <?php
            // 1. DB接続
            require_once('funcs.php');
            $pdo = db_conn();

            //2. データ登録SQL作成
            $stmt = $pdo->prepare('SELECT * FROM like_master');
            $status = $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // 結果を配列で取得

            $img_update = 'img/update.jpg';
            $img_delete = 'img/delete.jpg';
            ?>

            <?php
            // データを画面に表示
            echo "<table class='data-table'>";
            echo "<tr><th>お気に入りID</th><th>源泉ID</th><th>会員ID</th><th>コメント</th><th>評価</th><th>新規登録日時</th><th>更新日時</th><th>削除日時</th><th>更新</th><th>削除</th></tr>";

            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . h($row['like_id']) . "</td>";
                echo "<td>" . h($row['place_id']) . "</td>";
                echo "<td>" . h($row['user_id']) . "</td>";
                echo "<td>" . h($row['like_comment']) . "</td>";
                echo "<td>" . h($row['rating']) . "</td>";
                echo "<td>" . h($row['created']) . "</td>";
                echo "<td>" . h($row['updated']) . "</td>";
                echo "<td>" . h($row['deleted']) . "</td>";

                // 更新と削除のリンクを一列に正しく配置
                echo "<td><a href='bandai_like_detail.php?like_id=" . $row['like_id'] . "'>";
                echo "<img src='" . $img_update . "' alt='update' width='30' height='30'></a></td>";
                echo "<td><a href='bandai_like_delete.php?like_id=" . $row['like_id'] . "' onclick='return confirm(\"削除してよろしいですか？\");'>";
                echo "<img src='" . $img_delete . "' alt='delete' width='30' height='30'></a></td>";
                echo "</tr>";
            }
            echo "</table>";
            ?>
        </div>
        <div class="menu">
            <a href="bandai.html">番台メニューに戻る</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 源泉温泉検索</p>
    </footer>
</body>

</html>