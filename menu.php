<?php
include("./util/db_config.php");
include("./util/EncryptUtil.php");
// menu DB 불러오기
$sql = "SELECT * FROM `".$mysql_database."`.`".$mysql_menu."` ORDER BY me_order ASC , me_suborder ASC";
$result = $mysqli->query($sql);

$menuArr = array();
$submenuArr = array();
while ($row = mysqli_fetch_assoc($result)) {
	$menuData = array();
	$menuData['me_no'] = $row['me_no'];
	$menuData['me_order'] = $row['me_order'];
	$menuData['me_suborder'] = $row['me_suborder'];
	$menuData['me_class'] = $row['me_class'];
	$menuData['me_level'] = $row['me_level'];
	$menuData['me_name'] = $row['me_name'];
	$menuData['me_icon'] = $row['me_icon'];
	$menuData['me_href'] = $row['me_href'];

	if ($menuData['me_suborder'] == "0") {
		// 서브메뉴가 없을 경우 메인 메뉴에 추가
		$menuArr[] = $menuData;
	} else {
		// 서브메뉴가 있을 경우 서브 메뉴에 추가
		$submenuArr[$menuData['me_order']][] = $menuData;
	}
}

$mb_level = DecryptSession($_SESSION['user_permission'], $_SESSION['user_mail']);
?>

<script>
	function loadPage(url, data = '') {
		if (url != "#") {
			// 페이지 로딩중 표시
			setVisible('#loading', true);
			if (data == '') {
				$("#container-fluid").load("./page/" + url + ".php", function() {
					// 페이지 로딩이 완료시 표시 끄기 [jQuery .load()]
					setVisible('#loading', false);
				});
			} else {
				$("#container-fluid").load("./page/" + url + ".php", {
					data
				}, function() {
					// 페이지 로딩이 완료시 표시 끄기 [jQuery .load()]
					setVisible('#loading', false);
				});
			}
			// 뒤로가기를 위한 pushState
			window.history.pushState({
				"url": url,
				"data": data
			}, null, "index");
		}
	}
	window.onpopstate = function(event) {
		// pushState에서 url, data를 받아서 loadPage에 넣어준다.
		loadPage(history.state["url"], history.state["data"]);
	};
</script>

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="index.html">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>
            <div class="sb-sidenav-menu-heading">Interface</div>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Layouts
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="layout-static.html">Static Navigation</a><a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a></nav>
            </div>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                Pages
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">Authentication
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>
                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                        <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="login.html">Login</a><a class="nav-link" href="register.html">Register</a><a class="nav-link" href="password.html">Forgot Password</a></nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">Error
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>
                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                        <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="401.html">401 Page</a><a class="nav-link" href="404.html">404 Page</a><a class="nav-link" href="500.html">500 Page</a></nav>
                    </div>
                </nav>
            </div>
            <div class="sb-sidenav-menu-heading">Addons</div>
            <a class="nav-link" href="charts.html">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Charts
            </a><a class="nav-link" href="tables.html">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Tables
            </a>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        Start Bootstrap
    </div>
</nav>