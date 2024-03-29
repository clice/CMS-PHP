<?php
include "includes/db.php";
include "includes/header.php";
include "includes/navigation.php";
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php
            if (isset($_GET['id'])) {
                $categoryId = $_GET['id'];

                $query = "SELECT * FROM posts WHERE postCategoryId = $categoryId AND postStatus = 'published'";

                $select_posts_by_category = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_posts_by_category)) {
                    $postId = $row['postId'];
                    $postTitle = $row['postTitle'];
                    $postAuthorId = $row['postAuthorId'];
                    $postUser = $row['postUser'];
                    $postDate = $row['postDate'];
                    $postImage = $row['postImage'];
                    $postContent = substr($row['postContent'], 0, 100);
                    $postTags = $row['postTags'];
                    $postStatus = $row['postStatus'];
                    $postCommentCount = $row['postCommentCount'];
                    $postViewsCount = $row['postViewsCount'];

                    $author_query = "SELECT * FROM users WHERE userId = '$postAuthorId'";
                    $select_authors = mysqli_query($connection, $author_query);

                    while ($row2 = mysqli_fetch_assoc($select_authors)) {
                        ?>
                        <h1 class="page-header">
                            Page Heading
                            <small>Secondary Text</small>
                        </h1>
                        <h2>
                            <a href="post.php?id=<?php echo $postId; ?>"><?php echo $postTitle; ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="author_post.php?author=<?php echo $postAuthorId; ?>">
                                <?php echo $row2['userFirstName'] . " " . $row2['userLastName']; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $postDate; ?></p>
                        <hr>
                        <img class="img-responsive" src="admin/images/<?php echo $postImage; ?>" alt="">
                        <hr>
                        <p class="text-justify"><?php echo $postContent . "..."; ?></p>
                        <a class="btn btn-primary" href="#">Read More <span
                                    class="glyphicon glyphicon-chevron-right"></span></a>
                        <?php
                    }
                }
            }
            ?>
            <hr>

        </div>

        <?php include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php"; ?>
