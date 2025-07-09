<?php
session_start();
require "config/dbCon.php";

$cl = new Confi();
$pdo = $cl->dbConnection();

$serverdown = $cl->serverdown;

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require __DIR__ . "/assets/_phpmail.php";

unset($_SESSION['mailError']);

if (isset($_SESSION['mail_msg'])) {
  $message = $_SESSION['mail_msg'];
  unset($_SESSION['mail_msg']); // Clear it immediately
  echo '<script>
  alert(' . json_encode($message) . ');
  </script>';
}

if (!$serverdown) {
$stmt = $pdo->prepare("SELECT 
    b.id, 
    b.blog_title, 
    b.blog_cat_id, 
    b.created_date,
    d.short_description,
    d.full_description,
    c.cat_name,
    i.thumb_name, 
    i.thumb_uploaded_name, 
    v.total_view
FROM blog b
LEFT JOIN blog_description d 
  ON b.id = d.blog_id
LEFT JOIN category c 
  ON b.blog_cat_id = c.id
LEFT JOIN thumbnail i 
  ON b.id = i.blog_id
LEFT JOIN views v 
  ON b.id = v.blog_id
ORDER BY b.created_date DESC
LIMIT 6 ");

$stmt->execute();
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// portfolios --
$portfolio_stmt = $pdo->prepare("SELECT id, port_url, port_name, port_desc, port_cat, port_uploaded_name
    FROM portfolio
    ORDER BY created_at DESC
    LIMIT 6");

$portfolio_stmt->execute();
$portfolios = $portfolio_stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Esteham H. Zihad Ansari</title>
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
  
  
<script src="admin/assets/js/jquery-3.7.1.min.js"></script>
</head>

<body class="">
  <!-- Main Container Start -->
  <div class="main-container">
    <!-- Aside Start -->
    <div class="aside">
      <div class="logo">
        <a href="index.php"><span>Xet </span>Folio</a>
      </div>
      <div class="nav-toggler">
        <span></span>
      </div>
      <ul class="nav">
        <li>
          <a href="#home" class="active"><i class="fa fa-home"></i> Home</a>
        </li>
        <li>
          <a href="#about"><i class="fa fa-user"></i> About</a>
        </li>
        <li>
          <a href="#service"><i class="fa fa-list"></i> Services</a>
        </li>
        <li>
          <a href="#portfolio"><i class="fa fa-briefcase"></i> My Works</a>
        </li>
        <li>
          <a href="#blog"><i class="fa-brands fa-readme"></i> Blog</a>
        </li>
        <li>
          <a href="#contact"><i class="fa fa-comments"></i> Contact</a>
        </li>

      </ul>
    </div>
    <!-- Aside End -->
    <!-- Main Content Start -->
    <div class="main-content">
      
      <!-- Home Section Start -->
      <section class="home active section" id="home">
        <div class="container">
          <div class="row">
            <div class="home-info padd-15">
              <h3 class="hello">
                Hello, I am <span class="name">Esteham H. Zihad Ansari</span>
              </h3>
              <h3 class="my-profession">
                I'm a <span class="typing">Web Designer</span>
              </h3>
              <p>
                I'm a web designer with extensive experience for over 2
                years. My expertise is to create and design website, graphic
                design, and many more...
              </p>
               <a href="#" class="btn">Download CV</a> 
            </div>
            <div class="home-img padd-15">
              <img src="images/hero.jpg" alt="hero" />
            </div>
          </div>
        </div>
      </section>
      <!-- Home Section End -->

  <!-- About Section Start -->
<section class="about section" id="about">
  <div class="container">
    <div class="row">
      <div class="section-title padd-15">
        <h2>About Me</h2>
      </div>
    </div>
    <div class="container">
      <div class="about-content padd-15">
        <div class="row">
          <div class="about-text padd-15">
            <h3>I'm a <span>Web Developer</span></h3>
            <p>
              Passionate and self-driven web developer with a strong foundation in HTML, CSS, JavaScript, PHP, and modern frameworks like React and Laravel. I enjoy building creative, efficient, and user-friendly websites and web applications. I'm always eager to learn new technologies and take on challenging projects that help me grow professionally.
            </p>
          </div>
        </div>
<div class="container-fluid">
  <div class="personal-info padd-15">
    <div class="row">
      <div class="info-item padd-15">
        <p>Freelance : <span>Available</span></p>
      </div>
      <div class="info-item padd-15">
        <p>Age : <span id="age"></span></p>
      </div>
      <div class="info-item padd-15">
        <p>Website : <span>www.xetroot.com</span></p>
      </div>
      <div class="info-item padd-15">
        <p>Email : <span>spider@xetroot.com</span></p>
      </div>
      <div class="info-item padd-15">
        <p>Degree : <span>Honours in Philosophy</span></p>
      </div>
      <div class="info-item padd-15">
        <p>Phone : <span>+880 121 2546 254</span></p>
      </div>
      <div class="info-item padd-15">
        <p>City : <span>Dhaka</span></p>
      </div>
      <div class="info-item padd-15">
      </div>
    </div>
    <div class="skills padd-15">
      <div class="container-fluid" style="display: flex; flex-wrap: wrap;">
        <div class="col-sm-6" style="flex: 0 0 50%; max-width: 50%;">
          <div class="skills-item padd-15">
            <h5>HTML</h5>
            <div class="progress">
              <div class="progress-in" style="width: 95%"></div>
              <div class="skill-percent"></div>
            </div>
          </div>
          <div class="skills-item padd-15">
            <h5>CSS</h5>
            <div class="progress">
              <div class="progress-in" style="width: 65%"></div>
              <div class="skill-percent"></div>
            </div>
          </div>
          <div class="skills-item padd-15">
            <h5>JavaScript</h5>
            <div class="progress">
              <div class="progress-in" style="width: 85%"></div>
              <div class="skill-percent"></div>
            </div>
          </div>
          <div class="skills-item padd-15">
            <h5>PHP</h5>
            <div class="progress">
              <div class="progress-in" style="width: 95%"></div>
              <div class="skill-percent"></div>
            </div>
          </div>
        </div>
        <div class="col-sm-6" style="flex: 0 0 50%; max-width: 50%;">
          <div class="skills-item padd-15">
            <h5>Laravel</h5>
            <div class="progress">
              <div class="progress-in" style="width: 90%"></div>
              <div class="skill-percent"></div>
            </div>
          </div>
          <div class="skills-item padd-15">
            <h5>React</h5>
            <div class="progress">
              <div class="progress-in" style="width: 90%"></div>
              <div class="skill-percent"></div>
            </div>
          </div>
          <div class="skills-item padd-15">
            <h5>jQuery</h5>
            <div class="progress">
              <div class="progress-in" style="width: 85%"></div>
              <div class="skill-percent"></div>
            </div>
          </div>
          <div class="skills-item padd-15">
            <h5>Bootstrap 5</h5>
            <div class="progress">
              <div class="progress-in" style="width: 75%"></div>
              <div class="skill-percent">75%</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
        <div class="row">
          <div class="education padd-15">
            <h3 class="title">Education</h3>
            <div class="row">
              <div class="timeline-box padd-15">
                <div class="timeline shadow-dark">
                  <!-- Timeline item -->
                  <div class="timeline-item">
                    <div class="circle-dot"></div>
                    <h3 class="timeline-date">
                      <i class="fa fa-calendar"></i> 2025
                    </h3>
                    <h4 class="timeline-title">
                      Completed a Web Development course under IsDB IT Scholarship
                    </h4>
                    <p class="timeline-text">
                      Successfully completed an 8.5-month professional web development course focused on frontend and backend technologies, project management, and hands-on training in building real-world applications.
                    </p>
                  </div>
                  <!-- Timeline item -->
                  <div class="timeline-item">
                    <div class="circle-dot"></div>
                    <h3 class="timeline-date">
                      <i class="fa fa-calendar"></i> 2025
                    </h3>
                    <h4 class="timeline-title">
                      MASTER in Computer Science (Running)
                    </h4>
                    <p class="timeline-text">
                      Currently pursuing a Master's degree in Computer Science with focus areas including software engineering, data structures, and web technologies.
                    </p>
                  </div>
                  <!-- Timeline item -->
                  <div class="timeline-item">
                    <div class="circle-dot"></div>
                    <h3 class="timeline-date">
                      <i class="fa fa-calendar"></i> 2018 - 2022
                    </h3>
                    <h4 class="timeline-title">
                      Honours in Botany
                    </h4>
                    <p class="timeline-text">
                      Completed undergraduate studies in Botany, gaining deep knowledge in plant biology, ecology, and scientific research methodology.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="experience padd-15">
            <h3 class="title">Experience</h3>
            <div class="row">
              <div class="timeline-box padd-15">
                <div class="timeline shadow-dark">
                  <!-- Timeline item -->
                  <div class="timeline-item">
                    <div class="circle-dot"></div>
                    <h3 class="timeline-date">
                      <i class="fa fa-calendar"></i> 2025
                    </h3>
                    <h4 class="timeline-title">
                      Build a professional Portfolio with Admin panel
                    </h4>
                    <p class="timeline-text">
                      Designed and developed a fully functional personal portfolio website with an integrated admin panel for content management using PHP and MySQL.
                    </p>
                  </div>
                  <!-- Timeline item -->
                  <div class="timeline-item">
                    <div class="circle-dot"></div>
                    <h3 class="timeline-date">
                      <i class="fa fa-calendar"></i> 2025
                    </h3>
                    <h4 class="timeline-title">
                      Build a Production level e-commerce website
                    </h4>
                    <p class="timeline-text">
                      Developed a complete e-commerce platform with user authentication, product management, shopping cart, and secure payment integration using Laravel.
                    </p>
                  </div>
                  <!-- Timeline item -->
                  <div class="timeline-item">
                    <div class="circle-dot"></div>
                    <h3 class="timeline-date">
                      <i class="fa fa-calendar"></i> 2025
                    </h3>
                    <h4 class="timeline-title">
                      Build a Point of sale website (production level)
                    </h4>
                    <p class="timeline-text">
                      Created a POS system for retail management, including inventory tracking, sales reporting, and dynamic invoice generation, optimized for desktop and mobile.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- About Section End -->
  
  
  <!-- Services Section Start -->
<section class="service section" id="service">
  <div class="container">
    <div class="row">
      <div class="section-title padd-15">
        <h2>Services</h2>
      </div>
    </div>
    <div class="row">
      <!-- Services item -->
      <div class="service-item padd-15">
        <div class="service-item-inner">
          <div class="icon">
            <i class="fa fa-server"></i>
          </div>
          <h4>Backend Development</h4>
          <p>
            I build secure, fast, and scalable server-side logic using PHP and Laravel to power web applications.
          </p>
        </div>
      </div>
      <!-- Services item -->
      <div class="service-item padd-15">
        <div class="service-item-inner">
          <div class="icon">
            <i class="fa fa-desktop"></i>
          </div>
          <h4>Frontend Development</h4>
          <p>
            I create responsive and interactive interfaces using HTML, CSS, JavaScript, Bootstrap, and jQuery.
          </p>
        </div>
      </div>
      <!-- Services item -->
      <div class="service-item padd-15">
        <div class="service-item-inner">
          <div class="icon">
            <i class="fa fa-brands fa-react"></i>
          </div>
          <h4>React.js Development</h4>
          <p>
            I build modern single-page applications using React with reusable components and fast rendering.
          </p>
        </div>
      </div>
      <!-- Services item -->
      <div class="service-item padd-15">
        <div class="service-item-inner">
          <div class="icon">
            <i class="fa fa-brands fa-laravel"></i>
          </div>
          <h4>Laravel Development</h4>
          <p>
            I develop full-featured web apps using Laravel's powerful features, RESTful APIs, and MVC architecture.
          </p>
        </div>
      </div>
      <!-- Services item -->
      <div class="service-item padd-15">
        <div class="service-item-inner">
          <div class="icon">
            <i class="fa fa-brands fa-php"></i>
          </div>
          <h4>PHP Programming</h4>
          <p>
            I write clean and efficient PHP code for both custom projects and integrating with databases and APIs.
          </p>
        </div>
      </div>
      <!-- Services item -->
      <div class="service-item padd-15">
        <div class="service-item-inner">
          <div class="icon">
            <i class="fa fa-brands fa-wordpress"></i>
          </div>
          <h4>WordPress Theme Development</h4>
          <p>
            I design and develop custom WordPress themes tailored to your branding, speed, and SEO needs.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Services Section End -->

      <!-- Portfolio Section Start -->

      <section class="portfolio section" id="portfolio">
        <div class="container">
          <div class="row">
            <div class="section-title padd-15">
              <h2>My Works</h2>
            </div>
          </div>
          <div class="row">
            <div class="portfolio-heading padd-15">
              <h2>My Last Projects :</h2>
            </div>
          </div>
          <div class="portfolio-grid">
            <?php if (!$serverdown && !empty($portfolios)): ?>
              <?php foreach ($portfolios as $port):
                $porturl  = $port['port_url'];
              ?>
                <div class="portfolio-item portfolio-div">
                  <div class="portfolio-item-inner">
                      <div class="portfolio-img-container">
                        <a href="<?= htmlspecialchars($porturl, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer">
                        <img
                          src="images/portfolio/<?= htmlspecialchars($port['port_uploaded_name']) ?>"
                          alt="<?= htmlspecialchars($port['port_name']) ?>" />
                      </div>
                    
                    <div class="portfolio-content">
                      <h3 class="portfolio-title"><?= htmlspecialchars($port['port_name']) ?></h3>
                      <p class="portfolio-description"><?= htmlspecialchars($port['port_desc']) ?></p>
                      <?php
                      $cats = explode(',', $port['port_cat']);
                      foreach ($cats as $cat):
                        $cat = trim($cat);
                        if ($cat === '') {
                          continue;
                        }
                      ?>
                        <span class="portfolio-category"><?= htmlspecialchars($cat) ?></span>
                      <?php endforeach; ?>
                    </div>
                  </a>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
          <h2 class="padd-15">The server is experiencing downtime, the portfolio can't be loaded right now.
          </h2>
           <?php endif; ?>
          </div>
        </div>
      </section>
      
      
<script>
  $(document).ready(function () {
    $(".portfolio-div").on("click", function () {
      var link = $(this).find("a").attr("href");
      if (link) {
        window.open(link, "_blank");
        // window.location.href = link;
      }
    });
  });
</script>
      
      <!-- Portfolio Section End -->


      <!-- Blog Section Start -->
      <section class="blog section" id="blog">
        <div class="container">
          <div class="row">
            <div class="section-title padd-15">
              <h2>Blog</h2>
            </div>
          </div>
          <div class="row">
            <div class="blog-heading padd-15">
              <h2>My Recent Blogs :</h2>
            </div>
          </div>
          <div class="row">

            <?php
            if (!$serverdown && $blogs):
              foreach ($blogs as $blog):
                $idu = $blog['id'];
                $id = urlencode($idu);
            ?>



                <!-- Blog item -->
                <div class="blog-item padd-15">
                  <div class="blog-item-inner">
                    <div class="image">
                      <img src="images/blog/<?= $blog['thumb_uploaded_name'] ?>" alt="<?= $blog['thumb_name'] ?>">
                    </div>
                    <div class="blog-info">
                      <div class="category">
                        <a href="#">
                          <p><i class="fa-sharp fa-solid fa-book-open-reader"></i> <?= $blog['cat_name'] ?></p>
                        </a>
                      </div>
                      <div class="date">
                        <p><i class="fa-solid fa-calendar-days"></i> <?= $blog['created_date'] ?></p>
                      </div>
                    </div>
                    <a href="blog.php?p=<?= $id ?>">
                      <h4><?= $blog['blog_title'] ?></h4>
                    </a>
                    <p> <?= $blog['short_description'] ?>
                    </p>
                    <a href="blog.php?p=<?= $id ?>">Read More...</a>
                  </div>
                </div>

            <?php endforeach; ?>
            <?php else: ?>
          <h2 class="padd-15">The server is currently offline, blogs can't be loaded right now.
          </h2>
          <?php endif; ?>
          </div>
          </div>
      </section>
      <!-- Blog Section End -->

<!-- Contact Section Start -->
<section class="contact section" id="contact">
  <div class="container">
    <!-- Section title -->
    <div class="row">
      <div class="section-title padd-15">
        <h2>Contact Me</h2>
      </div>
    </div>

    <!-- Subtitle -->
    <div class="row">
      <div class="padd-15">
        <h3 class="contact-title">Do You Have Any Questions?</h3>
        <h4 class="contact-sub-title">I'M AT YOUR SERVICE</h4>
      </div>
    </div>

    <!-- Contact Info Items -->
    <div class="row">
      <!-- Contact info item -->
      <div class="contact-info-item padd-15 col-md-3 col-sm-6">
        <div class="icon"><i class="fa fa-phone"></i></div>
        <h4>Call Me On</h4>
        <p>+8801773448153</p>
      </div>
      <div class="contact-info-item padd-15 col-md-3 col-sm-6">
        <div class="icon"><i class="fa fa-map-marker-alt"></i></div>
        <h4>Lives In</h4>
        <p>Dhaka</p>
      </div>
      <div class="contact-info-item padd-15 col-md-3 col-sm-6">
        <div class="icon"><i class="fa fa-envelope"></i></div>
        <h4>Email</h4>
        <p>spider@xetroot.com</p>
      </div>
      <div class="contact-info-item padd-15 col-md-3 col-sm-6">
        <div class="icon"><i class="fa fa-globe-europe"></i></div>
        <h4>Website</h4>
        <p><a href="https://www.xetroot.com" target="_blank">Esteham H. Zihad Ansari</a></p>
      </div>
    </div>

    <!-- Form Title -->
    <div class="row">
      <div class="padd-15">
        <h3 class="contact-title">SEND ME AN EMAIL</h3>
        <h4 class="contact-sub-title">I'M VERY RESPONSIVE TO MESSAGES</h4>
      </div>
    </div>

    <!-- Contact Form -->
    <div class="row">
      <div class="contact-form padd-15">
        <form action="" method="post" class="row">
          <!-- CSRF Protection -->
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

          <!-- Name -->
          <div class="form-item col-6 padd-15">
            <div class="form-group">
              <input type="text" name="name" class="form-control" placeholder="Name" required />
            </div>
          </div>

          <!-- Email -->
          <div class="form-item col-6 padd-15">
            <div class="form-group">
              <input type="email" name="email" class="form-control" placeholder="Email" required />
            </div>
          </div>

          <!-- Subject -->
          <div class="form-item col-12 padd-15">
            <div class="form-group">
              <input type="text" name="subject" class="form-control" placeholder="Subject" required />
            </div>
          </div>

          <!-- Message -->
          <div class="form-item col-12 padd-15">
            <div class="form-group">
              <textarea class="form-control" name="message" placeholder="Message" required></textarea>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-item col-12 padd-15">
            <div class="form-group">
              <button type="submit" name="send_message" class="btn">Send Message</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<!-- Contact Section End -->

 
    </div>
    <!-- Main content Content End -->
  </div>
  <!-- Main Container End -->
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
  <!-- Style Switcher End -->
  <!-- Custom JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js"
    referrerpolicy="no-referrer"></script>
  <script src="js/script.js"></script>
  <script src="js/style-switcher.js"></script>
  <script>
      const birthDate = new Date("1998-07-07T00:00:00");

      function formatNumber(num) {
        return num < 10 ? "0" + num : num;
      }

      function updateAge() {
        const now = new Date();
        let diff = now - birthDate;

        const years = Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25));
        diff -= years * 1000 * 60 * 60 * 24 * 365.25;

        const months = Math.floor(diff / (1000 * 60 * 60 * 24 * 30.44));
        diff -= months * 1000 * 60 * 60 * 24 * 30.44;

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        diff -= days * 1000 * 60 * 60 * 24;

        let hours = Math.floor(diff / (1000 * 60 * 60));
        diff -= hours * 1000 * 60 * 60;

        let minutes = Math.floor(diff / (1000 * 60));
        diff -= minutes * 1000 * 60;

        let seconds = Math.floor(diff / 1000);

        // Format to 2 digits
        hours = formatNumber(hours);
        minutes = formatNumber(minutes);
        seconds = formatNumber(seconds);

        document.getElementById("age").innerHTML =
          `${years}y ${months}m ${days}d-` +
          `[<span class="timepart">${hours}</span>-` +
          `<span class="timepart">${minutes}</span>-` +
          `<span class="timepart">${seconds}</span>]`;
      }

      setInterval(updateAge, 1000);
      updateAge();
    </script>
</body>
</html>