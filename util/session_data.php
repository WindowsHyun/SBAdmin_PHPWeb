<?php
session_start();
if (!isset($_SESSION['session_id'])) {
    session_regenerate_id(true);
    $_SESSION['session_id'] = session_id();
} else {
    if ($_SESSION['session_id'] !== session_id()) {
        // 세션 ID가 일치하지 않는 경우, 로그아웃 처리 등의 보안 조치를 취할 수 있습니다.
        // 예를 들어, 다음과 같이 세션을 파괴하고 로그아웃 처리를 수행할 수 있습니다.
        session_unset();
        session_destroy();
        // 로그아웃 처리 등의 보안 조치를 수행합니다.
        echo "<meta http-equiv='refresh' content='0;url=.'>";
    }
}

$user_mail = "";
$user_no = "";
$user_name = "";
$user_permission = "";

if (!isset($_SESSION['user_mail']) || $_SESSION['user_mail'] == "" || !isset($_SESSION['user_name']) || $_SESSION['user_name'] == "" || !isset($_SESSION['user_no']) || $_SESSION['user_no'] == "" || !isset($_SESSION['user_permission']) || $_SESSION['user_permission'] == "") {
    // 로그인이 안되어 있을 경우
    $user_mail = "";
    $user_no = "";
    $user_name = "";
    $user_permission = "";
} else {
    $user_mail = $_SESSION['user_mail'];
    $user_no = DecryptSession($_SESSION['user_no'], $_SESSION['user_mail']);
    $user_name = DecryptSession($_SESSION['user_name'], $_SESSION['user_mail']);
    $user_permission = DecryptSession($_SESSION['user_permission'], $_SESSION['user_mail']);
}
?>