<!--  ロジック
================================================================================================  -->
<?php
require_once('common/db_connect.php');
require_once('common/sanitize.php');

// セッションの開始
session_start();

if (isset($_SESSION['id'])) {
    // ログイン状態のとき
    $id = $_SESSION['id'];
} else {
    // ログインしていないとき、ログインページへリダイレクト
    header('Location: login.php');
    exit;
}

// フォームから値が入力された場合、パスワードの判定を行う
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // フォームの入力値を代入
    $pass = $_POST['pass'];

    // ログインユーザーのパスワードを取得
    $sql = 'SELECT password FROM users WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($pass, $result['password'])) {
        // パスワードが一致する場合、ユーザー登録と対象ユーザーに紐づくログを削除
        $sql = 'DELETE users, weight_logs FROM users LEFT JOIN weight_logs ON users.id = user_id WHERE users.id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // 画面遷移フラグを設定して、完了画面へリダイレクト
        $_SESSION['flag'] = true;
        header('Location: delete_complete.php');
        exit;
    } else {
        // 入力されたパスワードが一致しない場合
        $error = '※パスワードが違います';
    }
}
?>


<!--  ビュー
================================================================================================  -->
<!-- header 読み込み -->
<?php require_once('common/header.php') ?>

<h1>ユーザー登録削除</h1>
<p>ユーザー登録を削除するには、パスワードを入力して「削除」ボタンを押してください</p>
<p>※ユーザー登録を削除すると、すべてのトレーニングログが削除され元に戻せません</p>
<form method="post">
    <div>
        <label for="pass">パスワード</label>
        <input type="password" name="pass" id="pass" required>
        <p><?= isset($error) ? escape($error) : '' ?></p>
    </div>
    <div>
        <button type="button"><a href="my_page.php">戻る</a></button>
        <button type="button">削除</button>
    </div>
</form>
</main>
</body>

</html>