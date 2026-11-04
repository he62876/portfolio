<?php
include($_SERVER['DOCUMENT_ROOT'].'/portfolio/common.php');
session_start();

if(!isset($_SESSION['admin'])) {
    echo "<meta http-equiv='refresh' content='0;url=/portfolio/admin/login.php'>";
    exit;
}


?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/portfolio/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/portfolio/css/reset.css">
    <link rel="stylesheet" href="/portfolio/admin/css/style.css">
    <title>포트폴리오</title>

    <style>
        #header {box-shadow: 0 1px 5px #ccc;}
    </style>
</head>
<body>
    <div id="header">
        <div class="container">
            <header class="d-flex flex-wrap justify-content-center py-3">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
                <span class="fs-4">Simple header</span>
            </a>

            <ul class="nav nav-pills">
                <li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Features</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Pricing</a></li>
                <li class="nav-item"><a href="#" class="nav-link">FAQs</a></li>
                <li class="nav-item"><a href="#" class="nav-link">About</a></li>
            </ul>
            </header>
        </div>
</div>