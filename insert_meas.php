<?php
// 1. POSTデータ取得（サニタイズやバリデーションのために適宜追加）
$measName = htmlspecialchars($_POST["measName"], ENT_QUOTES, 'UTF-8');
$intrvlTime = htmlspecialchars($_POST["intrvlTime"], ENT_QUOTES, 'UTF-8');
$rspId = htmlspecialchars($_POST["rspId"], ENT_QUOTES, 'UTF-8'); // hiddenなのでサニタイズは必要ないが、一貫性を保つために追加
$rate = htmlspecialchars($_POST["rate"], ENT_QUOTES, 'UTF-8');

// 2. DB接続します（接続情報はセキュリティ上の理由から非公開）
try {
    $pdo = new PDO('mysql:dbname=rasp;charset=utf8;host=localhost', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードを例外に設定
} catch (PDOException $e) {
    exit('DB_CONNECT:' . $e->getMessage());
}

// 3. データ登録SQL作成
$sql = "INSERT INTO meas_table(measName, intrvlTime, rspId, rate, indate) VALUES(:measName, :intrvlTime, :rspId, :rate, NOW())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':measName', $measName, PDO::PARAM_STR);
$stmt->bindValue(':intrvlTime', $intrvlTime, PDO::PARAM_INT);
$stmt->bindValue(':rspId', $rspId, PDO::PARAM_INT);
$stmt->bindValue(':rate', $rate, PDO::PARAM_INT);

// 4. データ登録処理後
try {
    $stmt->execute(); // SQLを実行
    // 5. index.phpへリダイレクト
    header("Location: index.php");
    exit();
} catch (PDOException $e) {
    // SQL実行時にエラーがある場合は例外をキャッチしてエラーメッセージを出力
    exit("SQL_ERROR:" . $e->getMessage());
}
?>
