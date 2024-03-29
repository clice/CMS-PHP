<?php
include "../includes/admin_header.php";
include "../includes/admin_navigation.php";
?>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Users
                    <small>Subheading</small>
                </h1>

                <?php
                if (isset($_GET['source'])) {
                    $source = $_GET['source'];
                } else {
                    $source = "";
                }

                switch ($source) {
                    case 'add_user':
                        include "users/add_user.php";
                        break;

                    case 'edit_user':
                        include "users/edit_user.php";
                        break;

                    case 'view_all_users':
                        include "users/view_all_users.php";
                        break;
                }
                ?>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include "../includes/admin_footer.php"; ?>