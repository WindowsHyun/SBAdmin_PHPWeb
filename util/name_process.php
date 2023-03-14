<?php
	include("./db_config.php");
	// 입력 값 확인
	if( !isset($_POST['chkName']) ){
		echo "비정상 적인 접근 입니다.";
		exit;
	}

	// 공백 입력 확인
	if ( $_POST['chkName'] == '' ){
		echo "비정상 적인 접근 입니다.";
		exit;
	}

	// Referer 체크
	if ( strpos($_SERVER['HTTP_REFERER'] , "register") == false){
		echo "비정상 적인 접근 입니다.";
		exit;
	}

	$chk_name = $_POST['chkName'];

	$sql = sprintf("SELECT COUNT(*) AS cnt FROM `%s` WHERE `name` = '%s'",
               $mysql_member_login_table,
               $mysqli->real_escape_string($chk_name));

	$result = $mysqli->query($sql);
	$row = mysqli_fetch_assoc($result);

	if($row['cnt'] > 0) {
		echo "중복 된 닉네임 입니다. false";
	}else{
		echo "사용하셔도 좋은 닉네임 입니다. true";
	}
?>