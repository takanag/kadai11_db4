<?php
// DB接続、セッション開始関数の読み込み
session_start();
require_once('funcs.php');
$pdo = db_conn();
loginCheck();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="main_style.css">
  <title>みんなの源泉かけ流し温泉マップ</title>
  <!-- <style>
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
        color: #333;
      }

      header {
        background-color: white;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #ccc;
        text-align: center;
      }

      header h1 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: bold;
      }

      .header-menu a {
        text-decoration: none;
        color: #333;
        font-size: 1rem;
      }

      main {
        padding: 40px 20px;
        text-align: center;
      }

      #map {
        height: 80vh;
        width: 100%;
        margin-bottom: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        justify-content: center;

      }

      .menu {
        text-align: center;
        margin-top: 20px;
      }

      .menu a {
        text-decoration: none;
        background-color: #008000;
        color: white;
        padding: 12px 20px;
        border-radius: 30px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }

      .menu a:hover {
        background-color: #006400;
      }

      footer {
        margin-top: 30px;
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
    </style> -->
</head>
<header>
  <h2>みんなの源泉かけ流し温泉マップ</h2>
</header>

<body>
  <div id="map"></div>
  <div class="menu">
    <a href="input.html">お気に入りの温泉を登録する</a>
    <a href="top_admin_menu.php">トップページに戻る</a>
  </div>

  <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBhYWr5aDp6--BOwqByO8cH2QJzYjuUWQ&callback=initMap&libraries=places"
    defer></script>
  <script>
    let map;
    let currentInfoWindow; // 現在開いているInfoWindowを追跡

    async function fetchPosts() {
      try {
        const response = await fetch("get_like.php");
        if (!response.ok) throw new Error("データの取得に失敗しました");
        const data = await response.json();
        return data;
      } catch (error) {
        console.error("エラー:", error);
        return [];
      }
    }

    async function getPlaceLocation(placeId) {
      return new Promise((resolve, reject) => {
        const service = new google.maps.places.PlacesService(map);
        service.getDetails({
          placeId: placeId
        }, (place, status) => {
          if (status === google.maps.places.PlacesServiceStatus.OK && place.geometry) {
            resolve(place.geometry.location);
          } else {
            reject(`場所の取得に失敗しました (status: ${status})`);
          }
        });
      });
    }

    async function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: {
          lat: 35.6895,
          lng: 139.6917
        },
        zoom: 11,
      });

      const posts = await fetchPosts();

      for (const post of posts) {
        if (!post.place_id) continue;

        try {
          const location = await getPlaceLocation(post.place_id);

          const marker = new google.maps.Marker({
            position: location,
            map: map,
            title: post.place_name || "不明な場所",
          });

          const infoWindow = new google.maps.InfoWindow({
            content: `
            <h3>源泉名：${post.place_name || "不明な名前"}</h3>
            <p>平均評価: ${post.average_rating || "評価なし"}</p>
            <p>コメント数: ${post.rating_count || "コメントなし"}</p>
            <p>源泉温度: ${post.gensen_temp || "不明"}</p>
            <p>効能: ${post.effect || "不明"}</p>
            <p>紹介文: ${post.review_summary || "不明"}</p>
            <a href="#" class="comment-link" data-place-id="${post.place_id}">コメント一覧を見る</a>
            <a href="#" class="save-comment" data-place-id="${post.place_id}">コメントを登録する</a>
          `,
            maxWidth: 1200
          });

          // マーカーをクリックしたときにコメント一覧を表示
          marker.addListener("click", () => {
            if (currentInfoWindow) currentInfoWindow.close(); // 開いているInfoWindowを閉じる
            infoWindow.open(map, marker);
            currentInfoWindow = infoWindow; // 現在のInfoWindowを更新
          });

          document.addEventListener("click", async (event) => {
            if (event.target.classList.contains("comment-link")) {
              event.preventDefault();
              const placeId = event.target.getAttribute("data-place-id");

              if (currentInfoWindow) currentInfoWindow.close(); // 開いているInfoWindowを閉じる

              const commentInfoWindow = new google.maps.InfoWindow({
                content: "<p>読み込み中...</p>",
                position: location,
                maxWidth: 1200
              });

              commentInfoWindow.open(map);
              currentInfoWindow = commentInfoWindow; // 現在のInfoWindowを更新

              try {
                const response = await fetch(`get_like_list.php?place_id=${placeId}`);
                const data = await response.text();
                commentInfoWindow.setContent(`
                <div style="max-height: 500px; maxWidth: 1200px; overflow-y: auto;">
                  ${data}
                </div>
              `);
              } catch (error) {
                commentInfoWindow.setContent("<p>コメント一覧の取得に失敗しました。</p>");
              }
            }
          });

          // コメントを登録するボタンをクリックしたときにコメントを登録
          marker.addListener("click", () => {
            if (currentInfoWindow) currentInfoWindow.close(); // 開いているInfoWindowを閉じる
            infoWindow.open(map, marker);
            currentInfoWindow = infoWindow; // 現在のInfoWindowを更新
          });

          document.addEventListener("click", async (event) => {
            if (event.target.classList.contains("save-comment")) {
              event.preventDefault();
              const placeId = event.target.getAttribute("data-place-id");

              if (currentInfoWindow) currentInfoWindow.close();

              const commentInfoWindow = new google.maps.InfoWindow({
                content: `
      <div>
        <h3>コメントを投稿する</h3>
        <form id="comment-form">
          <label for="rating">評価 (1〜5):</label><br>
          <select id="rating" name="rating" required>
            <option value="1">★☆☆☆☆</option>
            <option value="2">★★☆☆☆</option>
            <option value="3">★★★☆☆</option>
            <option value="4">★★★★☆</option>
            <option value="5">★★★★★</option>
          </select><br><br>
          <label for="like_comment">コメント:</label><br>
          <textarea id="like_comment" name="like_comment" rows="3" required></textarea><br><br>
          <button type="submit">送信</button>
        </form>
      </div>
      `,
                position: map.getCenter(),
                maxWidth: 1200
              });

              commentInfoWindow.open(map);
              currentInfoWindow = commentInfoWindow;

              // フォーム登録済みかどうかを確認
              google.maps.event.addListenerOnce(commentInfoWindow, 'domready', () => {
                const form = document.getElementById("comment-form");
                if (form) {
                  form.addEventListener("submit", async (e) => {
                    e.preventDefault();
                    const rating = document.getElementById("rating").value;
                    const like_comment = document.getElementById("like_comment").value;

                    try {
                      const response = await fetch("save_comment_flag.php", {
                        method: "POST",
                        headers: {
                          "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                          place_id: placeId,
                          rating: parseFloat(rating),
                          like_comment: like_comment.trim(),
                        }),
                      });

                      const result = await response.json();
                      if (result.success) {
                        alert("コメントが登録されました");
                        commentInfoWindow.close();
                      } else {
                        alert(result.error || "登録に失敗しました");
                      }
                    } catch (error) {
                      alert("エラーが発生しました");
                      console.error("エラー:", error);
                    }
                  });
                } else {
                  console.error("フォームが見つかりませんでした");
                }
              });
            }
          });


        } catch (error) {
          console.error(`場所ID ${post.place_id} のマーカー追加に失敗しました:`, error);
        }
      }
    }
  </script>

</body>

</html>