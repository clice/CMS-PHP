<?php
ob_start();
include "../../includes/db.php";
include "../functions/functions_categories.php";
include "../functions/functions_comments.php";
include "../functions/functions_posts.php";
include "../functions/functions_users.php";
include "../functions/general_functions.php";
session_start();

if (!isset($_SESSION['userRole'])) {
    header("Location: ../../");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <link href="../css/sb-admin.css" rel="stylesheet">

    <link href="../css/loader.css" rel="stylesheet">

    <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>

    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>

<div id="wrapper">