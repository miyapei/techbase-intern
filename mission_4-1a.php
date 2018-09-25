<?php
header("Content-Type:text/html;charset=UTF-8");
?>

<!DOCTYPE html>
<html lang = "ja">
	<head>
		<meta charset = "UTF-8">
	</head>
	<body>
		<form action="mission_4-1.php" method="POST">



<?php

//データベースに接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

//テーブルの作成
$sql="CREATE TABLE mission4"
."("
."id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."password char(32),"
."date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP"
.");";
$stmt = $pdo->query($sql);
?>

<?php

//データベースに接続
$dsn = 'mysql:dbname=tt_266_99sv_coco_com;host=localhost';
$user = 'tt-266.99sv-coco';
$password = 'y9HCPesY';
$pdo = new PDO($dsn,$user,$password);


//新規投稿の保存
if(!empty($_POST["name"]) and !empty($_POST["comment"]) and !empty($_POST["pass_new"]) and empty($_POST["edit_id"])){
	$sql = $pdo -> prepare("INSERT INTO mission4 (name,comment,password) VALUES (:name,:comment,:password)");
	$sql -> bindParam(':name',$name,PDO::PARAM_STR);
	$sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
	$sql -> bindParam(':password',$comment,PDO::PARAM_STR);
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$password = $_POST["pass_new"];
	$sql -> execute();
}

//編集する投稿をフォームに表示
if(!empty($_POST["edit"]) and !empty($_POST["pass_edit"])){
	$edit_id=$_POST["edit"];
	$edit_pass=$_POST["pass_edit"];

	$sql = 'SELECT * FROM mission4';
	$results = $pdo -> query($sql);
	foreach($results as $row){
		if($row['id']==$edit_id and $row['password']==$edit_pass){
			$edit_id2=$edit_id;
			$edit_name=$row['name'];
			$edit_comment=$row['comment'];
		}
	}
}

//編集機能
if(!empty($_POST["name"]) and !empty($_POST["comment"]) and !empty($_POST["edit_id"])){
	$id = $_POST["edit_id"];
	$name_new = $_POST["name"];
	$comment_new = $_POST["comment"];
	$date = date("Y-m-d H:i:s");
	$sql = "update mission4 set name='$name_new',comment='$comment_new',date='$date' where id = $id";
	$result = $pdo->query($sql);
}



?>

			名前:<input type="text" name ="name" value="<?php echo $edit_name;?>"><br/>
			コメント:<input type="text" name ="comment" value="<?php echo $edit_comment;?>">
			<input type="hidden" name ="edit_id" value="<?php echo $edit_id2;?>"><!-ここに値が入っていれば編集を行う-><br/>
			パスワード：<input type="text" name ="pass_new">
			<input type="submit" value="送信"><br/>
			<br/>
			削除対象番号：<input type="text" name="delete"><br/>
			パスワード：<input type="text" name ="pass_del">
			<input type="submit" value="削除"><br/>
			<br/>
			編集対象番号:<input type="text" name="edit"><br/>
			パスワード：<input type="text" name ="pass_edit">
			<input type="submit" value="編集"><br/>
			<br/>
			コメント覧<br/>
			<br/>
		</form>
	</body>
</html>


<?php

//データベース接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

//削除機能
if(!empty($_POST["delete"]) and !empty($_POST["pass_del"])){
	$sql = 'SELECT * FROM mission4 order by id';
	$results = $pdo -> query($sql);
	$delete_id=$_POST["delete"];
	$delete_pass=$_POST["pass_del"];

	foreach($results as $row){
		if($row['id'] == $delete_id and $row['password'] == $delete_pass){
			$number = $row['id'];
			$sql = "delete from mission4 where id=$number";
			$result = $pdo->query($sql);
		}
	}
}


//ブラウザ表示
$sql = 'SELECT * FROM mission4 ORDER BY id';
$results = $pdo -> query($sql);
foreach($results as $row){
	//$rowの中にはテーブルのカラム名が入る
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['date'].'<br>';
}
?>