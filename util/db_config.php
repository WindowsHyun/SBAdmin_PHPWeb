<?php
$mysql_hostname = 'localhost';
$mysql_username = 'root';
$mysql_password = 'windowshyun';
$mysql_database = 'GameServer';
$mysql_login_table = 'admin_table';     // user_table -> 일반 가입 처리 admin_table -> 관리자 전용 가입 불가 [메뉴에서만 가입 처리 가능]
$mysql_regist_code = 'regist_code';
$mysql_menu = 'menu';
$mysqli = new  mysqli($mysql_hostname, $mysql_username, $mysql_password, $mysql_database);
// mysqli_connect_errno();
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
}
?>