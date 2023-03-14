<?php
include("./db_config.php");
include("./EncryptUtil.php");

$register_code = $_POST['inputRegisterCode'];
$user_pw = $_POST['inputPassword'];
$user_email = $_POST['inputEmail'];
$user_name = $_POST['inputName'];
$regtime = "" . date("Y-m-d H:i:s") . "";

// 이메일 중복 체크를 한번 더 한다.
$sql = "SELECT mail FROM `" . $mysql_member_login_table . "` WHERE mail = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_assoc($result);

if ($row['mail'] != '') {
	echo "중복 된 이메일 주소 입니다.";
	exit();
}

// 가입 코드를 확인 한다.
$sql = "SELECT * FROM `" . $mysql_regist_code . "` WHERE `regist_code` = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $register_code);
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_assoc($result);

if ($row['count'] > 0) {
	// 가입할 수 있는 코드가 있을 경우
	$count = --$row['count'];
} else {
	echo "가입 할 수 없는 코드 입니다.";
	exit();
}

// 실제 가입 처리를 한다.
$hashed_password = password_hash($user_pw, PASSWORD_DEFAULT);
$sql = "INSERT INTO `" . $mysql_database . "`.`" . $mysql_member_login_table . "` (`name`, `mail`, `pwd`, `level`, `code`, `token`, `regtime`, `lastLogin`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssssssss", $user_name, $user_email, $hashed_password, 2, $register_code, "", $regtime, $regtime);
$result = $stmt->execute();

if ($result == true) {
	// 가입 카운트는 줄어 든다.
	$sql = "UPDATE `" . $mysql_database . "`.`" . $mysql_regist_code . "` SET `count`=? WHERE `no`=?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ii", $count, $row['no']);
	$stmt->execute();
	echo "가입 완료!";
	echo "<meta http-equiv='refresh' content='0;url=index'>";
} else {
	echo "가입 실패!";
	exit();
}
?>