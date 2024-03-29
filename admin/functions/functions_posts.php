<?php

function insert_post() {
    global $connection;

    if (isset($_POST['create_post'])) {
        $postTitle = $_POST['postTitle'];
        $postAuthorId = $_POST['postAuthorId'];
        $postCategoryId = $_POST['postCategoryId'];
        $postStatus = $_POST['postStatus'];
        $postImage = $_FILES['postImage']['name'];
        $auxPostImage = $_FILES['postImage']['tmp_name'];
        $postTags = $_POST['postTags'];
        $postContent = $_POST['postContent'];
        $postCommentCount = 0;

        if ((!empty($postTitle)) && (!empty($postAuthorId)) && (!empty($postCategoryId)) &&
            (!empty($postStatus)) && (!empty($postImage)) && (!empty($auxPostImage)) &&
            (!empty($postTags)) && (!empty($postContent)) && (!empty($postCommentCount))) {
            move_uploaded_file($auxPostImage, "../images/$postImage");
            $query = "INSERT INTO posts(postTitle, postAuthorId, postCategoryId, postStatus, postImage, postTags, postContent, " .
                "postDate, postCommentCount) VALUES('$postTitle', $postAuthorId, $postCategoryId, '$postStatus', '$postImage', " .
                "'$postTags', '$postContent', now(), $postCommentCount)";
            $create_post_query = mysqli_query($connection, $query);
            confirmQuery($create_post_query);
            $postId = mysqli_insert_id($connection);

            echo "<div class='alert alert-success' role='alert'>Post Created. <a href='../../post.php?id=$postId'>" .
                "View Post</a> or <a href='posts.php?source=view_all_posts'>Edit More Posts.</a></div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Fields cannot be empty.</div>";
        }
    }
}

function update_post() {
    global $connection;

    if (isset($_POST['update_post'])) {
        $postId = $_POST['postId'];
        $postTitle = $_POST['postTitle'];
        $postAuthorId = $_POST['postAuthorId'];
        $postCategoryId = $_POST['postCategoryId'];
        $postStatus = $_POST['postStatus'];
        $postImage = $_FILES['postImage']['name'];
        $auxPostImage = $_FILES['postImage']['tmp_name'];
        $postTags = $_POST['postTags'];
        $postContent = $_POST['postContent'];
        $postCommentCount = $_POST['postCommentCount'];

        if ((!empty($postTitle)) && (!empty($postAuthorId)) && (!empty($postCategoryId)) && (!empty($postId))
            (!empty($postStatus)) && (!empty($postImage)) && (!empty($auxPostImage)) &&
            (!empty($postTags)) && (!empty($postContent)) && (!empty($postCommentCount))) {
            move_uploaded_file($auxPostImage, "../images/$postImage");
            $postImage = emptyImage($postImage, $postId);
            $query = "UPDATE posts SET postTitle = '$postTitle', postAuthorId = $postAuthorId, postCategoryId = $postCategoryId, " .
                "postStatus = '$postStatus', postImage = '$postImage', postTags = '$postTags', postContent = '$postContent', " .
                "postDate = now(), postCommentCount = $postCommentCount WHERE postId = $postId";
            $update_post_query = mysqli_query($connection, $query);
            confirmQuery($update_post_query);

            echo "<div class='alert alert-success' role='alert'>Post Updated: <a href='../../post.php?id=$postId'>" .
                "View Post</a> or <a href='posts.php?source=view_all_posts'>Edit More Posts.</a></div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Fields cannot be empty.</div>";
        }
    }
}

function find_all_posts() {
    global $connection;
    $query = "SELECT * FROM posts ORDER BY postId DESC";
    $select_posts = mysqli_query($connection, $query);
    confirmQuery($select_posts);

    while ($row = mysqli_fetch_assoc($select_posts)) {
        $postId = $row['postId'];
        $postAuthorId = $row['postAuthorId'];
        $postTitle = $row['postTitle'];
        $postCategoryId = find_category_by_id($row['postCategoryId']);
        $postStatus = $row['postStatus'];
        $postImage = $row['postImage'];
        $postTags = $row['postTags'];
        $postCommentCount = $row['postCommentCount'];
        $postViewsCount = $row['postViewsCount'];
        $postDate = $row['postDate'];

        $author_query = "SELECT * FROM users WHERE userId = '$postAuthorId'";
        $select_authors = mysqli_query($connection, $author_query);

        while ($row2 = mysqli_fetch_assoc($select_authors)) {
            ?>
            <tr>
                <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $postId; ?>">
                </td>
                <td><?php echo $postId; ?></td>
                <td><?php echo $row2['userFirstName'] . " " . $row2['userLastName']; ?></td>
                <td><a href="../../post.php?id=<?php echo $postId; ?>"><?php echo $postTitle; ?></a></td>
                <td><?php echo $postCategoryId; ?></td>
                <td><?php echo $postStatus; ?></td>
                <td><img src="../images/<?php echo $postImage; ?>" alt="image" width="100"></td>
                <td><?php echo $postTags; ?></td>
                <td><?php echo $postCommentCount; ?></td>
                <td>
                    <a href="posts.php?source=view_all_posts&reset=<?php echo $postId; ?>"><?php echo $postViewsCount; ?></a>
                </td>
                <td><a href="posts.php?source=view_all_posts&publish=<?php echo $postId; ?>">Publish</a></td>
                <td><?php echo $postDate; ?></td>
                <td><a href="posts.php?source=edit_post&id=<?php echo $postId; ?>">Edit</a></td>
                <td><a onclick="javascript: return confirm('Are you sure you want to delete?');"
                       href="posts.php?source=view_all_posts&delete=<?php echo $postId; ?>">Delete</a></td>
            </tr>
            <?php
        }
    }
}

function find_post($postId) {
    global $connection;
    $query = "SELECT * FROM posts WHERE postId = $postId";
    $select_post = mysqli_query($connection, $query);
    confirmQuery($select_post);

    while ($row = mysqli_fetch_assoc($select_post)) {
        $data['postId'] = $row['postId'];
        $data['postAuthorId'] = $row['postAuthorId'];
        $data['postTitle'] = $row['postTitle'];
        $data['postCategoryId'] = $row['postCategoryId'];
        $data['postStatus'] = $row['postStatus'];
        $data['postImage'] = $row['postImage'];
        $data['postTags'] = $row['postTags'];
        $data['postContent'] = $row['postContent'];
        $data['postCommentCount'] = $row['postCommentCount'];
        $data['postDate'] = $row['postDate'];
    }

    return $data;
}

function delete_post() {
    global $connection;

    if (isset($_GET['delete'])) {
        $postId = $_GET['delete'];
        $query = "DELETE FROM posts WHERE postId = $postId";
        $delete_query = mysqli_query($connection, $query);
        confirmQuery($delete_query);
        header("Location: posts.php?source=view_all_posts");
    }
}

function publish_post() {
    global $connection;

    if (isset($_GET['publish'])) {
        $postId = $_GET['publish'];
        echo $postId;
        $query = "UPDATE posts SET postStatus = 'Published' ";
        $query .= "WHERE postId = $postId";
        $publish_post = mysqli_query($connection, $query);
        confirmQuery($publish_post);
        header("Location: posts.php?source=view_all_posts");
    }
}

function add_comment_count($postId) {
    global $connection;
    $query = "UPDATE posts SET postCommentCount = postCommentCount + 1 ";
    $query .= "WHERE postId = $postId";
    $add_comment_count = mysqli_query($connection, $query);
    confirmQuery($add_comment_count);
}

function sub_comment_count($postId) {
    global $connection;
    $query = "UPDATE posts SET postCommentCount = postCommentCount - 1 ";
    $query .= "WHERE postId = $postId";
    $sub_comment_count = mysqli_query($connection, $query);
    confirmQuery($sub_comment_count);
}

function emptyImage($postImage, $postId) {
    if (empty($postImage)) {
        global $connection;
        $query = "SELECT * FROM posts WHERE postId = $postId";
        $select_image = mysqli_query($connection, $query);
        confirmQuery($select_image);

        while ($row = mysqli_fetch_array($select_image)) {
            $postImage = $row['postImage'];
        }
    }
    return $postImage;
}

function num_posts() {
    global $connection;
    $query = "SELECT * FROM posts";
    $select_all_posts = mysqli_query($connection, $query);
    confirmQuery($select_all_posts);
    $num_posts = mysqli_num_rows($select_all_posts);
    return $num_posts;
}

function num_published_posts() {
    global $connection;
    $query = "SELECT * FROM posts WHERE postStatus = 'Published'";
    $select_all_published_posts = mysqli_query($connection, $query);
    confirmQuery($select_all_published_posts);
    $num_published_posts = mysqli_num_rows($select_all_published_posts);
    return $num_published_posts;
}

function num_draft_posts() {
    global $connection;
    $query = "SELECT * FROM posts WHERE postStatus = 'Draft'";
    $select_all_draft_posts = mysqli_query($connection, $query);
    confirmQuery($select_all_draft_posts);
    $num_draft_posts = mysqli_num_rows($select_all_draft_posts);
    return $num_draft_posts;
}

function update_status($bulkOptions, $postId) {
    global $connection;
    $query = "UPDATE posts SET postStatus = '$bulkOptions' WHERE postId = $postId";
    $update_status = mysqli_query($connection, $query);
    confirmQuery($update_status);
}

function delete_post_table($postId) {
    global $connection;
    $query = "DELETE FROM posts WHERE postId = $postId";
    $delete_query = mysqli_query($connection, $query);
    confirmQuery($delete_query);
}

function clone_posts($postId) {
    global $connection;
    $query = "SELECT * FROM posts WHERE postId = $postId";
    $select_post_query = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_array($select_post_query)) {
        $postTitle = $row['postTitle'];
        $postCategoryId = $row['postCategoryId'];
        $postDate = $row['postDate'];
        $postAuthorId = $row['postAuthorId'];
        $postStatus = $row['postStatus'];
        $postImage = $row['postImage'];
        $postTags = $row['postTags'];
        $postContent = $row['postContent'];
        $postCommentCount = 0;
    }

    $query = "INSERT INTO posts(postTitle, postAuthorId, postCategoryId, postStatus, postImage, postTags, postContent, " .
        "postDate, postCommentCount) VALUES('$postTitle', '$postAuthorId', $postCategoryId, '$postStatus', '$postImage', " .
        "'$postTags', '$postContent', now(), $postCommentCount)";
    $create_post_query = mysqli_query($connection, $query);
    confirmQuery($create_post_query);
}

function reset_views_post() {
    global $connection;
    if (isset($_GET['reset'])) {
        $postId = $_GET['reset'];
        $query = "UPDATE posts SET postViewsCount = 0 WHERE postId = $postId";
        $update_views_post = mysqli_query($connection, $query);
        confirmQuery($update_views_post);
        header("Location: posts.php?source=view_all_posts");
    }
}