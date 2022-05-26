<!--  ロジック
================================================================================================  -->
<?php
require_once('common/db_connect.php');
require_once('common/sanitize.php');

// セッションの開始
session_start();

// ログイン状態のとき、インデックスページへリダイレクトする
if (isset($_SESSION['id'])) {
	header('Location: index.php');
	exit;
}

// フォームから値が入力された場合
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// フォームの入力値を代入
	$name = $_POST['name'];
	$pass = $_POST['pass'];

	// ユーザー名に合致するレコードを取得
	$sql = 'SELECT * FROM users WHERE name = :name';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':name', $name, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);

	if (!empty($result)) {
		// レコード取得に成功（ユーザー登録あり）した場合、パスワードチェックを行う
		if (password_verify($pass, $result['password'])) {
			// セッションIDを新しく生成（セッションハイジャック対策）
			session_regenerate_id(true);

			// パスワードが一致する場合、ログイン処理を行う
			$_SESSION['id'] = $result['id'];
			$_SESSION['name'] = $result['name'];

			// インデックスページへリダイレクト
			header('Location: index.php');
			exit;
		} else {
			// パスワードが一致しない場合
			$error = '※ユーザー名、またはパスワードが違います。ユーザー登録をされていない方は先にユーザー登録をしてください。';
		}
	} else {
		// レコード取得に失敗（ユーザー登録なし）した場合
		$error = '※ユーザー名、またはパスワードが違います。ユーザー登録をされていない方は先に新規登録をしてください。';
	}
}
?>


<!--  ビュー
================================================================================================  -->
<!-- header 読み込み -->
<?php require_once('common/header.php') ?>

	<main><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<h1>ログイン</h1>
		<div>
			<p>ユーザー名とパスワードを入力してください</p>
			<p><?= isset($error) ? escape($error) : '' ?></p>
			<!-- 入力フォーム -->
			<form method="post">
				<div>
					<label for="name">ユーザー名</label>
					<input type="text" name="name" id="name" required>
				</div>
				<div class="mb-4">
					<label for="pass">パスワード</label>
					<input type="password" name="pass" id="pass" required>
				</div>
				<div>
					<button class="btn btn-warning" type="submit">ログイン</button>
				</div>
				<div>
					<a href="sign_up.php">新規ユーザー登録はこちらから</a>
				</div>
			</form>
	</main>
</body>

</html>