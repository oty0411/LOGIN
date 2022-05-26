<?php
try {
    // データベースに接続してPDOインスタンスを作成
    $dsn = 'mysql:dbname=IPPA_05_01;charset=utf8mb4;port=3306;host=localhost';
    $user = 'root';
    $pass = '';
    $driver_options = array(PDO::ATTR_PERSISTENT => true);
    $pdo = new PDO($dsn, $user, $pass, $driver_options);
} catch (PDOException $e) {
    // DBアクセスに失敗した場合、エラーメッセージを表示
    echo 'データベース接続エラー : ' . $e->getMessage() . '<br/>時間をおいてから再度お試しください。';
    exit;
}