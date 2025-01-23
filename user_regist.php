<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main_style.css">
    <title>新規ユーザー登録</title>
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

        main {
            padding: 40px 20px;
            text-align: center;
        }

        main h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto;
        }

        dl {
            margin: 0;
        }

        dt {
            text-align: left;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        dd {
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 90%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .required {
            color: red;
            font-weight: bold;
            margin-left: 5px;
        }

        .register-button {
            width: 100%;
            background-color: #008000;
            color: white;
            padding: 12px 0;
            font-size: 1rem;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            margin-top: 10px;
        }

        .register-button:hover {
            background-color: #006400;
        }

        .info-links {
            margin-top: 20px;
            text-align: left;
        }

        .info-links p {
            margin: 10px 0;
            font-size: 0.9rem;
        }

        .info-links a {
            color: #008000;
            text-decoration: none;
        }

        .info-links a:hover {
            text-decoration: underline;
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

<body>
    <header>
        <h2>新規ユーザー登録</h2>
    </header>

    <main>
        <h3>ユーザー登録フォーム</h3>
        <p>必要な情報を入力してください。</p>
        <form method="POST" action="user_insert.php">
            <div class="jumbotron">
                <dl>
                    <dt>ニックネーム<span class="required">必須</span></dt>
                    <dd><input type="text" name="user_name" placeholder="ニックネームを入力" required></dd>

                    <dt>メールアドレス<span class="required">必須</span></dt>
                    <dd><input type="text" name="email" placeholder="メールアドレスを入力" required></dd>

                    <dt>パスワード<span class="required">必須</span></dt>
                    <dd><input type="password" name="password" placeholder="パスワードを入力" required></dd>
                </dl>
                <button class="login-button" type="submit">登録する</button>
        </form>
        </div>


        <div class="menu">
            <p><a href="index.html">ログインページに戻る</a></p>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 源泉かけ流し温泉検索「源泉しか勝たん」</p>
    </footer>
</body>

</html>