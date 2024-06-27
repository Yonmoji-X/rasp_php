<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
  <link href="css/main.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="select.php">機器一覧</a>
        <a class="navbar-brand" href="select_meas.php">測定一覧</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div class="jumbotron">
  <form method="POST" action="insert.php">
    <fieldset>
      <legend>機器登録</legend>
      <label>機器名：<input type="text" name="rspName"></label><br>
      <label>所有者Email：<input type="text" name="ownerEmail"></label><br>
      <!-- 非表示のinput -->
      <input type="hidden" id="status" name="status" value="off"><br>
      <label>測定ID：<input type="text" name="measId"></label><br>
      <label>詳細：<textarea name="text" rows="4" cols="40"></textarea></label><br>
      <input type="submit" value="送信">
    </fieldset>
  </form>
</div>
<!-- Main[End] -->

</body>
</html>
