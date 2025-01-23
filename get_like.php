 <?php
    header("Content-Type: application/json; charset=UTF-8");

    // DB接続情報
    require_once('funcs.php');
    $pdo = db_conn();

    // 2. データ登録SQL作成
    try {
        // SQLクエリを実行して各テーブルから必要なデータを取得
        $query = "
    SELECT 
        CAST(l.like_id AS UNSIGNED) AS like_id,
        CAST(l.user_id AS UNSIGNED) AS user_id,
        l.place_id, like_comment, l.rating,
        g.place_name, g.review_summary, g.gensen_temp, g.effect,
        u.user_name, u.point
    FROM like_master l
    LEFT JOIN gensen_master g ON l.place_id = g.place_id
    LEFT JOIN user_master u ON l.user_id = u.user_id
    ";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 結果が空の場合の対応
        if (!$results) {
            echo json_encode([]);
            exit;
        }

        // 'place_id'ごとの'rating'の平均と件数を計算
        $placeRatingStats = [];
        foreach ($results as $row) {
            $placeId = $row['place_id'];
            if (!isset($placeRatingStats[$placeId])) {
                $placeRatingStats[$placeId] = ['total_rating' => 0, 'rating_count' => 0];
            }
            $placeRatingStats[$placeId]['total_rating'] += $row['rating'];
            $placeRatingStats[$placeId]['rating_count']++;
        }

        // 平均を計算
        foreach ($placeRatingStats as $placeId => &$stats) {
            $stats['average_rating'] = $stats['rating_count'] > 0
                ? round($stats['total_rating'] / $stats['rating_count'], 1)
                : 0;
        }

        // 型を保証するためのキャスト処理
        $formattedResults = array_map(function ($row) use ($placeRatingStats) {
            $placeId = $row['place_id'];
            $averageRating = $placeRatingStats[$placeId]['average_rating'] ?? 0;
            $ratingCount = $placeRatingStats[$placeId]['rating_count'] ?? 0;

            return [
                'like_id' => (int) $row['like_id'],
                'place_id' => $row['place_id'],
                'user_id' => (int) $row['user_id'],
                'like_comment' => $row['like_comment'],
                'rating' => $row['rating'],
                'place_name' => $row['place_name'],
                'review_summary' => $row['review_summary'],
                'gensen_temp' => $row['gensen_temp'],
                'effect' => $row['effect'],
                'user_name' => $row['user_name'],
                'point' => $row['point'],
                // 追加情報
                'average_rating' => $averageRating,
                'rating_count' => $ratingCount,
            ];
        }, $results);

        echo json_encode($formattedResults);
    } catch (PDOException $e) {
        error_log("SQLエラー: " . $e->getMessage());
        echo json_encode(["error" => "データの取得に失敗しました: " . $e->getMessage()]);
        exit;
    }



    // $stmt = $pdo->prepare('SELECT * FROM like_master');
    // $status = $stmt->execute();
    // $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // 結果を配列で取得

    // echo json_encode($results);
    // } catch (PDOException $e) {
    // echo json_encode(["error" => $e->getMessage()]);
    ?>