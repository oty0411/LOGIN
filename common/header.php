<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Workout</title>
</head>

<body>
    <header>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <h1><a href="index.php">My Workout</a></h1>
        <ul>
            <!-- ログイン状態によってメニュー内容を切り替える -->
            <?php if (isset($_SESSION['id'])) : ?>
                <li><a href="my_page.php">マイページ</a></li>
                <li><a href="logout.php">ログアウト</a></li>
            <?php else : ?>
                <li><a href="login.php">ログイン</a></li>
                <li><a href="sign_up.php">ユーザー登録</a></li>
            <?php endif ?>
            </li>
        </ul>
    </header>