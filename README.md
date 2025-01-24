# ①課題番号-プロダクト名
11 源泉温泉検索「源泉しか勝たん」プレリリース版

## ②課題内容（どんな作品か）
温泉のなかでも源泉は別格！ でも源泉の温泉がどこにあるのか、検索するのは至難の業。そこでみんながお気に入りの源泉情報を共有する口コミサイト。同じ源泉フリークとして、自分のお気に入りの源泉も共有しよう！

## ③DEMO
https://takanag.sakura.ne.jp/kadai11_db4/index.html

## ④作ったアプリケーション用のIDまたはPasswordがある場合
ID: test1@email.com（管理者）　Password: test1 
ID: test2@email.com（ユーザー）　Password: test2 

## ⑤工夫した点・こだわった点
今回のアップデートは、
・ログインしたユーザー情報をセッションとして持ったまま源泉の口コミを登録できるようにしました。これにより、口コミにユーザー名が表示されるようになりました。
・Difyを使って、源泉情報をPHPに登録するワークフローを作成し、生成されたSQLクエリをPHP上で実行するだけで登録できるようにしました。
https://devt28s8f16.slack.com/archives/C07P3HFH1B3/p1737563398552999
・源泉情報の登録にあたり、生成AIのハルシネーションを防止するため、gensparkによるファクトチェックを行った上で登録しています。
　https://www.genspark.ai/agents?id=7f5c6400-d39c-4cbe-a027-72a30036f36a
・13件の源泉情報を新規に登録しました。
・StyleのCSSファイル化（一部ページは未完了）
の5点です。

## ⑥難しかった点・次回トライしたいこと(又は機能)
口コミ情報から源泉のランキング（満足度順、源泉の温度順）を作成したい。

## ⑦質問・疑問・感想、シェアしたいこと等なんでも

- [参考記事]
