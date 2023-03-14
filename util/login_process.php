<?php
include("./db_config.php");
include("./EncryptUtil.php");

function login_process_get_ip(){
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

// 입력 값 확인
if (!isset($_POST['inputEmailAddress']) || !isset($_POST['inputPassword'])) {
    echo "비정상 적인 접근 입니다.";
    print_r($_POST);
	exit;
}

// 공백 입력 확인
if ($_POST['inputEmailAddress'] == '' || $_POST['inputPassword'] == '') {
	echo "비정상 적인 접근 입니다.";
	exit;
}

// Referer 체크
if (strpos($_SERVER['HTTP_REFERER'], "login") == false) {
	echo "비정상 적인 접근 입니다.";
	exit;
}

$user_mail = $_POST['inputEmailAddress'];
$user_pw = $_POST['inputPassword'];

$sql = "SELECT * FROM `" . $mysql_admin_login_table . "` WHERE mail = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $user_mail);
$stmt->execute();
$result = $stmt->get_result();




if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$hashed_password = $row['pwd'];

	// 비밀번호 검증
	if (password_verify($user_pw, $hashed_password)) {
		// 로그인 성공시, lastLogin 시간을 남긴다.
		$userNo = $row['no'];
		$loginTime = "" . date("Y-m-d H:i:s") . "";
		$sql = "UPDATE `" . $mysql_database . "`.`" . $mysql_admin_login_table . "` SET `lastLogin`=?, `lastLoginIP`=?  WHERE `no`=?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("ssi", $loginTime, login_process_get_ip(), $userNo);
		$stmt->execute();

		$_SESSION['user_mail'] = $user_mail;
		$_SESSION['user_ip'] = login_process_get_ip();
		$_SESSION['user_no'] = EncryptSession($row['no'], $user_mail);
		$_SESSION['user_name'] = EncryptSession($row['name'], $user_mail);
		$_SESSION['user_permission'] = EncryptSession($row['permission'], $user_mail);
		// Webtoon Seesion 가져오기
		if ($_POST['readData'] != "") {
			echo "<meta http-equiv='refresh' content='0;url=site?" . $_POST['readData'] . "'>";
		} else {
			echo "<meta http-equiv='refresh' content='0;url=index'>";
		}
	} else {
		// 로그인 실패
		echo "아이디 또는 패스워드가 잘못되었습니다.";
		echo "<br>";
		exit;
	}
} else {
	// 로그인 실패
	echo "아이디 또는 패스워드가 잘못되었습니다.";
	echo "<br>";
	exit;
}
?>