<!doctype html>
<html lang="kr">
<?php
// echo $SERVER['PHP_SELF'];
include("./head.php");
include("./util/login_session.php");
?>

<body class="sb-nav-fixed" id="page-top">
    <!-- topNavbar, modal Start -->
    <?php include("./topNavbar.php"); ?>
    <?php include("./modal.php"); ?>
    <!-- topNavbar, modal End -->

    <div id="wrapper">
        <!-- Menu Start -->
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php include("./menu.php"); ?>
            </div>

            <!-- Menu End -->

            <!-- Content Start -->
            <div id="layoutSidenav_content">
                <!-- InContent Start -->
                <div id="container-fluid" class="container-fluid">
                    <div style="height:3000px;"></div>
                </div>
                <!-- InContent End -->

                <!-- Tail Start -->
                <?php include("./tail.php"); ?>
                <!-- Tail End -->
            </div>
        </div>
        <!-- Content End -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button Start-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Scroll to Top Button End-->

</body>

<script>
    // $(document).ready(function() {
    // 	$("#container-fluid").load("./page/blank.php");
    // });

    // function setVisible(selector, visible) {
    // 	document.querySelector(selector).style.display = visible ? 'block' : 'none';
    // }

    // document.addEventListener('DOMContentLoaded', function() {
    // 	setVisible('#loading', false);
    // }, false);
</script>

</html>