<?php

//0. SESSION開始！！
session_start();

//1.関数群の読み込み
include("funcs.php"); 

//LOGINチェック → funcs.phpへ関数化しましょう！
sschk();

//２．データ登録SQL作成
$pdo=db_conn();
$sql = "SELECT * FROM gs_an_table";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
    sql_error($stmt);
  }

  //全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>アンケート結果</title>
    <?=$_SESSION["name"]?>さん、こんにちは！
</head>
<body id="main">
    <!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">アンケート登録</a>
      <a class="navbar-brand" href="logout.php">ログアウト</a>
      </div>
    </div>
  </nav>
</header>
    <h1>アンケート結果一覧</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>id</th>
            <th>名前</th>
            <th>メールアドレス</th>
            <th>エコバッグを使っている</th>
            <th>マイボトルを使っている</th>
            <th>自転車や徒歩で移動している</th>
            <th>発電バイクで運動したい</th>
            <th>評価</th> <!-- 新たに評価（★）を追加 -->
        </tr>
            <?php foreach ($values as $row): ?>
                <?php
                // 「はい」と答えた数をカウント
                $star_count = $row['eco_bag'] + $row['my_bottle'] + $row['walking_bike'] + $row['power_bike'];
                $stars = str_repeat('★', $star_count); // ★の数を決定
                ?>
                <tr>
                    <td><?= h($row['id'], ) ?></td>
                    <td><?= h($row['name'], ) ?></td>
                    <td><?= h($row['email'],  ) ?></td>
                    <td><?= h($row['eco_bag'] ? 'はい' : 'いいえ' )?></td>
                    <td><?= h($row['my_bottle'] ? 'はい' : 'いいえ') ?></td>
                    <td><?= h($row['walking_bike'] ? 'はい' : 'いいえ') ?></td>
                    <td><?= h($row['power_bike'] ? 'はい' : 'いいえ' )?></td>
                    <td><?= $stars ?></td> <!-- 評価として★を表示 -->
                    <?php if($_SESSION["kanri_flg"]=="1"){ ?>
                    <td><a class="btn" href="detail.php?id=<?= h($row['id']) ?>">更新</a></td>
                    <td><a class="btn" href="delete.php?id=<?= h($row['id']) ?>">削除</a></td>
                    <?php } ?>
                </tr>
            <?php endforeach; ?>
       
            
    </table>
</body
