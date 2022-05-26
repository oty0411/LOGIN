<!--  ロジック
================================================================================================  -->
<?php
require_once('common/sanitize.php');

// セッションの開始
session_start();

if (isset($_SESSION['id'])) {
    // ログイン状態のとき
    $name = $_SESSION['name'];
} else {
    // ログアウト状態のとき、ログインページへリダイレクトする
    header('Location: login.php');
    exit;
}
?>


<!--  ビュー
================================================================================================  -->
<!-- head 読み込み -->
<?php require_once('common/header.php') ?>

<body>
    <main>
        <h1>マイページ</h1>
        <h2>ユーザー名 : <?= $name ?></h2>
        <p>こちらのページからパスワードの変更とユーザー登録の削除が行えます。</p>
        <ul>
            <li><a href="index.php">トレーニングログ一覧</a></li>
            <li><a href="change_password.php">パスワード変更</a></li>
            <li><a href="delete.php">ユーザー登録削除</a></li>
        </ul>
    </main>
</body>

</html>