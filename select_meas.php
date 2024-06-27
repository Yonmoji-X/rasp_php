<?php
//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=rasp;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DB_CONECT'.$e->getMessage());
}

//２．データ登録SQL作成
$sql = "SELECT * FROM meas_table";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute(); //ture or false

//３．データ表示
// $view=""; //無視
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
//JSON値を渡す場合に使う
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
<link href="css/main.css" rel="stylesheet">
<style>
div{padding: 10px;font-size:16px;}
td{border: 1px solid black}
</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="select.php">機器一覧</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->


<!-- Main[Start] -->
<div>
  <h2>測定カード</h2>
    <div class="container jumbotron">
      <table>
      <?php foreach($values as $value){ ?>
        <tr>
          <td>測定ID<?=$value["id"]?></td>
          <td>測定名：<?=$value["measName"]?></td>
          <td>測定間隔：<?=$value["intrvlTime"]?>分</td>
          <td>機器ID：<?=$value["rspId"]?></td>
          <td>割合:<?=$value["rate"]?>%</td>
          <td><button>測定開始</button></td>
        </tr>
      <?php } ?>
      </table>
    </div>
</div>
<!-- Main[End] -->


<script>
  //JSON受け取り
  $a = '<?=$json?>'
  const json = JSON.parse($a);
  console.log(json)



</script>
</body>
</html>
