<?php

require("config/dbCon.php");

$con = new Confi();

$conn = $con->dbConnection();

if(isset($_GET['p'])){
    $id = urldecode($_GET['p']);
} else {
    die('No id.');
}

$stmt = "SELECT 
            b.id, b.blog_title, b.created_date,
            c.cat_name,
            d.short_description,
            d.full_description,
            i.thumb_name,
            i.thumb_uploaded_name,
            v.total_view
        FROM blog b
        LEFT JOIN category c ON b.blog_cat_id = c.id
        LEFT JOIN blog_description d ON b.id = d.blog_id
        LEFT JOIN thumbnail i ON b.id = i.blog_id
        LEFT JOIN views v ON b.id = v.blog_id
        where b.id = :id";
        
$blog =  $conn->prepare($stmt);
$blog->execute([':id' => $id]);
$blog = $blog->fetch(PDO::FETCH_ASSOC);

$recent_stmt = "SELECT 
            b.id, b.blog_title, b.created_date,
            c.cat_name,
            d.short_description,
            d.full_description,
            i.thumb_name,
            i.thumb_uploaded_name,
            v.total_view
        FROM blog b
        LEFT JOIN category c ON b.blog_cat_id = c.id
        LEFT JOIN blog_description d ON b.id = d.blog_id
        LEFT JOIN thumbnail i ON b.id = i.blog_id
        LEFT JOIN views v ON b.id = v.blog_id
        ORDER BY b.created_date DESC
        LIMIT 6";
$recent_blogs =  $conn->prepare($recent_stmt);
$recent_blogs->execute();
$recent_blogs = $recent_blogs->fetchAll(PDO::FETCH_ASSOC);


?>



<html lang="en">

<head>
    <!----------
Project Name: Modern Portfolio Website
Description: A complete responsive modern portfolio website design
             by using HTML CSS and Vanilla JavaScript from scratch.
Author: Esteham H. Zihad Ansari
Github: https://github.com/esteham
License: MIT License
Copyright: 2025 ©esteham 
---------->



    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Esteham H. Zihad Ansari - <?= $blog['blog_title'] ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali&display=swap" rel="stylesheet">


    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/blog-single.css">
    <link rel="stylesheet" href="css/skins/color-1.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <!-- Style Switcher -->
    <link rel="stylesheet" href="css/skins/color-1.css" class="alternate-style" title="color-1" disabled />
    <link rel="stylesheet" href="css/skins/color-2.css" class="alternate-style" title="color-2" disabled />
    <link rel="stylesheet" href="css/skins/color-3.css" class="alternate-style" title="color-3" disabled />
    <link rel="stylesheet" href="css/skins/color-4.css" class="alternate-style" title="color-4" disabled />
    <link rel="stylesheet" href="css/skins/color-5.css" class="alternate-style" title="color-5" disabled />

    <link rel="stylesheet" href="css/style-switcher.css" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="images/fabicon.png" />
</head>

<body class="">
    <!-- Container Start -->
    <div class="blog-container">
        <!-- Top Section Start -->
        <div class="top-section">
            <div class="top-row">
                <div class="logo">
                    <a href="index.php"><span>Mhr</span>SpiDer</a>
                </div>
                <div class="back-btn">
                    <a href="index.php" class="btn">GO BACK</a>
                </div>
            </div>
            <div class="bottom-row">
                <div class="blog-details">
                    <div class="blog-title">
                        <h1><?= $blog['blog_title'] ?></h1>
                    </div>
                    <div class="category">
                        <p><a href="#"><i class="fa-sharp fa-solid fa-book-open-reader"></i> <?= $blog['cat_name'] ?> </a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Top Section End -->

        <!-- Body Section Start -->
        <div class="body-section">
            <div class="body-row">
                <div class="left">
                    <div class="blog-img">
                        <img src="images/blog/<?= $blog['thumb_uploaded_name'] ?>" alt="<?= $blog['thumb_name'] ?>" class='full-width-img'>
                    </div>
                    <div class="blog-info">
                        <div class="category">
                            <p><a href="#"><i class="fa-sharp fa-solid fa-book-open-reader"></i> <?= $blog['cat_name'] ?></a></p>
                        </div>
                        <div class="date">
                            <p><i class="fa-solid fa-calendar-days"></i> <?= $blog['created_date'] ?></p>
                        </div>
                    </div>
                    <div class="blog-title">
                        <h1><?= $blog['blog_title'] ?></h1>
                    </div>
                    <div class="blog-desc">
                        <p><?= $blog['full_description'] ?></p>
                    </div>
                    <div class="social-share">
                        <div class="row">
                            <div class="title padd-15">
                                <p>Share On Social Media</p>
                            </div>
                            <div class="social-icons">
                                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                                <a href="#"><i class="fa-brands fa-youtube"></i></a>
                                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="right">
                    <div class="row">
                        <div class="section-title padd-15">
                            <h2>Recent Posts</h2>
                        </div>
                    </div>
                    <!-- Recent Posts Start -->
                    <div class="recent-posts">
                        <!-- Recent Post -->
                        <?php if($recent_blogs):
                        foreach($recent_blogs as $item):
                        $id = urlencode($item['id']) ?>
                        
                        <a href="?p=<?=$id?>">
                            <div class="post-row">
                                <div class="post-img">
                                    <img src="images/blog/<?= $item['thumb_uploaded_name']?>" alt="<?= $item['thumb_name']?>">
                                </div>
                                <div class="post-desc">
                                    <p><?= $item['blog_title']?></p>
                                    <p><i class="fa-solid fa-calendar-days"></i> <?= $item['created_date']?></p>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; endif; ?>
                       
                    </div>
                    <!-- Recent Posts End -->
                    <br>
                    <div class="row">
                        <div class="section-title padd-15">
                            <h2>Related Posts</h2>
                        </div>
                    </div>
                    <!-- Related Posts Start -->
                    <div class="recent-posts">
                        <!-- Related Post -->
                         <?php if($recent_blogs):
                        foreach($recent_blogs as $item): ?>
                        <a href="#">
                            <div class="post-row">
                                <div class="post-img">
                                    <img src="images/blog/<?= $item['thumb_uploaded_name']?>" alt="<?= $item['thumb_name']?>">
                                </div>
                                <div class="post-desc">
                                    <p><?= $item['short_description']?></p>
                                    <p><i class="fa-solid fa-calendar-days"></i> <?= $item['created_date']?></p>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; endif; ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- Body Section End -->
        <!-- Footer Section Start -->
        <div class="footer-section">
            <div class="footer-row">
                <div class="left">
                    <p>© Copyright 2023. All Rights Reserved.</p>
                </div>
                <div class="right">
                    <p>Developed By <a href="#" target="_blank">Esteham H. Zihad Ansari</a></p>
                </div>
            </div>
        </div>
        <!-- Footer Section End -->
        <!-- Container End -->
        <!-- Style Switcher Start -->
        <div class="style-switcher">
            <div class="style-switcher-toggler s-icon">
                <i class="fas fa-cog fa-spin"></i>
            </div>
            <div class="day-night s-icon">
                <i class="fas"></i>
            </div>
            <h4>Theme Colors</h4>
            <div class="colors">
                <span class="color-1" onclick="setActiveStyle('color-1')"></span>
                <span class="color-2" onclick="setActiveStyle('color-2')"></span>
                <span class="color-3" onclick="setActiveStyle('color-3')"></span>
                <span class="color-4" onclick="setActiveStyle('color-4')"></span>
                <span class="color-5" onclick="setActiveStyle('color-5')"></span>
            </div>
        </div>
    </div>
    <!-- Style Switcher End -->
    <!-- Custom JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js"
        referrerpolicy="no-referrer"></script>
    <script src="js/script.js"></script>
    <script src="js/style-switcher.js"></script>
</body>

</html>