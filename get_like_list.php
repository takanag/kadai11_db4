<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>口コミ一覧</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background-color: #008000;
            color: white;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 0.8rem;
        }

        main {
            padding: 5px;
            text-align: center;
        }

        main p {
            font-size: 0.8rem;
            margin-bottom: 5px;
        }

        .table-container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 5px;
            padding: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 5px;
        }

        h2 {
            font-size: 0.8rem;
            margin-bottom: 5px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #008000;
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
            background-color: #008000;
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
            background-color: #008000;
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

            .table-container {
                max-width: 400px;
                margin: 0 auto;
                background-color: white;
                border-radius: 1px;
                padding: 1px;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
                margin-bottom: 1px;
            }
        }
    </style>
</head>

<body>
    <main>
        <div class="table-container">
            <!-- <p>コメント一覧</p> -->

            <?php
            require_once('funcs.php');
            $pdo = db_conn();

            // `place_id` を取得
            $place_id = $_GET['place_id'] ?? null;

            if (!$place_id) {
                echo "<p>有効なplace_idが指定されていません。</p>";
                exit;
            }

            // 指定された `place_id` のデータを取得
            $stmt = $pdo->prepare('SELECT * FROM like_master WHERE place_id = :place_id');
            $stmt->bindValue(':place_id', $place_id, PDO::PARAM_STR);
            $status = $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$results) {
                echo "<p>口コミが見つかりません。</p>";
            } else {
                echo "<table class='data-table'>";
                echo "<tr><th>ニックネーム</th><th>コメント</th><th>評価</th></tr>";

                foreach ($results as $row) {
                    $ratingStars = str_repeat('★', (int)$row['rating']) . str_repeat('☆', 5 - (int)$row['rating']);
                    echo "<tr>";
                    echo "<td>" . h($row['user_name']) . "</td>";
                    echo "<td>" . h($row['like_comment']) . "</td>";
                    echo "<td>" . $ratingStars . "</td>";
                    // echo "<td>" . h($row['rating']) . "</td>";
                    // echo "<td>" . h($row['created']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            ?>
        </div>
    </main>
</body>

</html>