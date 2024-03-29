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
                    Posts
                    <small>Subheading</small>
                </h1>

                <?php
                if (isset($_GET['source'])) {
                    $source = $_GET['source'];
                } else {
                    $source = "";
                }

                switch ($source) {
                    case 'add_post':
                        include "posts/add_post.php";
                        break;

                    case 'edit_post':
                        include "posts/edit_post.php";
                        break;

                    case 'view_all_posts':
                        include "posts/view_all_posts.php";
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