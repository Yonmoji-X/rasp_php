<?php
// 1. POSTデータ取得（サニタイズやバリデーションのために適宜追加）
$rspName = htmlspecialchars($_POST["rspName"], ENT_QUOTES, 'UTF-8');
$ownerEmail = htmlspecialchars($_POST["ownerEmail"], ENT_QUOTES, 'UTF-8');
$status = htmlspecialchars($_POST["status"], ENT_QUOTES, 'UTF-8'); // hiddenなのでサニタイズは必要ないが、一貫性を保つために追加
$text = htmlspecialchars($_POST["text"], ENT_QUOTES, 'UTF-8');
$measId = intval($_POST["measId"]); // 数値として扱うのでintval()でキャストする

// 2. DB接続します（接続情報はセキュリティ上の理由から非公開）
try {
    $pdo = new PDO('mysql:dbname=rasp;charset=utf8;host=localhost', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードを例外に設定
} catch (PDOException $e) {
    exit('DB_CONNECT:' . $e->getMessage());
}

// 3. データ登録SQL作成
$sql = "INSERT INTO rsp(rspName, ownerEmail, status, text, measId, indate) VALUES(:rspName, :ownerEmail, :status, :text, :measId, NOW())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':rspName', $rspName, PDO::PARAM_STR);
$stmt->bindValue(':ownerEmail', $ownerEmail, PDO::PARAM_STR);
$stmt->bindValue(':status', $status, PDO::PARAM_STR);
$stmt->bindValue(':text', $text, PDO::PARAM_STR);
$stmt->bindValue(':measId', $measId, PDO::PARAM_INT);

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
