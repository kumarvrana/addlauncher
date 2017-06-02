<?php
	$db = new PDO('mysql:host="192.168.0.39";dbname=test;charset=UTF-8', 'root', '');


	if($_POST['submit']){

		$name = $_POST['name'];
		$slug = str_replace(' ', '-', $name);
		$check = $db->query("Select count(*) from table where slug=".$slug);
		if($check > 0){
			die($check);
		}
		$db->query('INSERT INTO `test_slug` (`name`, `slug`) VALUES ("$name", "$slug")');
	}
	?>
	<form method="post"  action="">
		<input type="text" name="name">
		<!--input type="text" name="slug"-->
		<input type="submit" name="submit" value="submit">
	</form>