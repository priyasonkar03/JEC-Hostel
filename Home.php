<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>JEC Hostel</title>
  <link rel="icon" href="img/logo/attnlg.jpg">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    .navbar {
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .hero-section {
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                  url('./img/home2.jpg') no-repeat center center / cover;
      min-height: 90vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    #hero-text {
      color: white;
      font-size: 4rem;
      font-weight: bold;
      background-color: rgba(0, 0, 0, 0.3);
      border-radius: 10px;
      padding: 30px;
    }

    #hero-text small {
      font-size: 2rem;
      font-weight: 400;
      display: block;
      margin-top: 10px;
    }

    .hero-btn {
      margin-top: 20px;
      font-size: 1.2rem;
    }

    .facilities-section {
      background-color: #f8f9fa;
      padding: 60px 0;
    }

    .facility {
      background: #ffffff;
      border-radius: 15px;
      padding: 30px 20px;
      box-shadow: 0 6px 24px rgba(0, 123, 255, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .facility:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 12px 40px rgba(0, 123, 255, 0.2);
    }

    .facility i {
      color: #007bff;
      margin-bottom: 15px;
    }

    .facility h5 {
      color: #212529;
      font-weight: 600;
    }

    .facility p {
      color: #6c757d;
      font-size: 0.95rem;
    }

    .facilities-title, .about-title, .testimonial-title {
      font-weight: 700;
      color: #2c3e50;
      font-size: 2.2rem;
      margin-bottom: 30px;
    }

    .testimonial-item blockquote {
      background: #f1f1f1;
      border-left: 5px solid #007bff;
      padding: 20px;
      border-radius: 8px;
    }

    .video-container video {
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">
      <img src="img/logo/attnlg.jpg" width="40" height="40" alt=""> JEC HOSTEL
    </a>
    <div class="ml-auto">
      <a href="./registerStudent/register.php" class="btn btn-light btn-sm mr-2">Sign Up</a>
      <a href="index.php" class="btn btn-light btn-sm">Login</a>
    </div>
    
  </nav>

  <!-- HERO SECTION -->
  <div class="hero-section">
    <div id="hero-text">
      Welcome to <br> JABALPUR ENGINEERING COLLEGE HOSTEL
      <small>Your Second Home for a Comfortable Student Life</small>
      <a href="#about" class="btn btn-warning btn-lg hero-btn">Learn More</a>
    </div>
  </div>

  <!-- ABOUT SECTION -->
  <section class="container my-5 about-section" id="about">
    <h2 class="text-center about-title">About Us</h2>
    <div class="row">
      <!-- <div class="col-md-6 about-img">
        <img src="img/about.jpg" class="img-fluid rounded shadow" alt="About Hostel">
      </div> -->
      <div class="col d-flex align-items-center about-text text-justify">
        <p>Jabalpur Engineering College (JEC) offers well-structured and thoughtfully managed hostel facilities to foster a safe, disciplined, and comfortable living environment that supports academic excellence and personal development. Our hostels are designed to cater to the diverse needs of students, ensuring a true "home away from home" experience.
          Each hostel is equipped with a range of essential amenities, including clean, spacious, and ventilated rooms with ample storage, 24/7 security supported by CCTV surveillance, and round-the-clock warden supervision to maintain order and address student concerns promptly.
          To support digital learning and connectivity, high-speed Wi-Fi is available throughout the hostel premises. For health and hygiene, we provide purified drinking water, regular housekeeping, and well-maintained washrooms. Our common rooms are furnished with recreational items like indoor games, TV, and reading materials to encourage relaxation and peer bonding.
          Dedicated study rooms offer a quiet environment for focused academic work and group discussions. Additionally, students enjoy access to a nutritious and hygienic mess, serving balanced meals prepared under strict quality standards.
          Separate hostels for male and female students ensure privacy and comfort, while the hostel management team remains active in resolving issues, organizing events, and creating a welcoming atmosphere for all residents. With a perfect blend of discipline, convenience, and community spirit, JEC hostels ensure that students not only live well but thrive academically and socially.
        </p>
      </div>
    </div>
  </section>

  <!-- VIDEO SECTION -->
  <section class="container my-5">
    <div class="video-container text-center">
      <video autoplay muted loop playsinline style="width: 100%; max-height: 500px; object-fit: cover;">
        <source src="img/JecVideo.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
  </section>

 <!-- FACILITIES SECTION -->
<section class="container-fluid my-5 facilities-section px-5">
  <h2 class="text-center facilities-title mb-5">Our Facilities</h2>
  <div class="row text-center justify-content-center">
    <div class="col-lg-3 col-md-5 col-sm-10 facility mb-4 mx-3">
      <i class="fas fa-wifi fa-2x"></i>
      <h5>High-Speed Wi-Fi</h5>
      <p>24/7 seamless internet connectivity across the hostel premises to support academic and research needs.</p>
    </div>
    <div class="col-lg-3 col-md-5 col-sm-10 facility mb-4 mx-3">
      <i class="fas fa-utensils fa-2x"></i>
      <h5>Healthy Meals</h5>
      <p>Nutritious and hygienic meals served in the hostel mess, prepared with quality ingredients for student well-being.</p>
    </div>
    <div class="col-lg-3 col-md-5 col-sm-10 facility mb-4 mx-3">
      <i class="fas fa-lock fa-2x"></i>
      <h5>Secure Premises</h5>
      <p>Round-the-clock security with CCTV surveillance and wardens to ensure safety and discipline inside hostels.</p>
    </div>
    <div class="col-lg-3 col-md-5 col-sm-10 facility mb-4 mx-3">
      <i class="fas fa-book-reader fa-2x"></i>
      <h5>Study Rooms</h5>
      <p>Quiet and well-lit spaces dedicated for focused academic study and group learning sessions.</p>
    </div>
    <div class="col-lg-3 col-md-5 col-sm-10 facility mb-4 mx-3">
      <i class="fas fa-dumbbell fa-2x"></i>
      <h5>Fitness Center</h5>
      <p>Well-equipped gym facilities to promote physical wellness and a healthy lifestyle among students.</p>
    </div>
    <div class="col-lg-3 col-md-5 col-sm-10 facility mb-4 mx-3">
      <i class="fas fa-clinic-medical fa-2x"></i>
      <h5>Medical Assistance</h5>
      <p>On-call medical support and first-aid facilities for timely care in case of health concerns.</p>
    </div>
  </div>
</section>


  <!-- TESTIMONIAL SECTION -->
  <section class="container my-5 testimonial-section">
    <h2 class="text-center testimonial-title">Testimonials</h2>
    <div class="row">
      <div class="swiper testimonialSwiper">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
      <blockquote class="blockquote text-center">
        <p>"The best hostel experience I've had."</p>
        <footer class="blockquote-footer">Amit Sharma</footer>
      </blockquote>
    </div>
    <div class="swiper-slide">
      <blockquote class="blockquote text-center">
        <p>"Feels like home! Loved the food."</p>
        <footer class="blockquote-footer">Sneha Patel</footer>
      </blockquote>
    </div>
    <!-- Add more slides here -->
  </div>
  <div class="swiper-pagination"></div>
</div>

    </div>
  </section>

<!-- CONTACT SECTION -->
  <section class="container-fluid my-5 facilities-section px-5">
     <h2 class="text-center testimonial-title">Our Location</h2>
    <div class="row">
      <div class="col-md-9 about-img">
         <section class="container my-5">
          <div class="embed-responsive embed-responsive-16by9 shadow rounded">
            <!-- <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=Insert Your Embed Link Here" allowfullscreen></iframe> -->
            <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3667.4294440556323!2d79.98447107394973!3d23.191015210023973!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3981a8d6aaaaaaad%3A0xfad1b073dfb80ffd!2z4KSc4KSs4KSy4KSq4KWB4KSwIOCkh-CkguCknOClgOCkqOCkv-Ckr-CksOCkv-CkguCklyDgpJXgpYngpLLgpYfgpJw!5e0!3m2!1shi!2sin!4v1747156636058!5m2!1shi!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
      </section>  
      </div>
      <div class="col-md-3 d-flex align-items-center about-text text-justify">
        <h4>Jabalpur Engineering College
        JEC, Gokalpur<br>Jabalpur - 482011. M.P.-India.<br>
        Phone : 91-761- 2331953<br>
        e-mail: prinjec.jbp@mp.gov.in</h4>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <?php include 'footer.php'; ?>

  <!-- SCROLL TO TOP -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

  <script>
    const testimonialSwiper = new Swiper('.testimonialSwiper', {
      loop: true,
      autoplay: { delay: 4000 },
      pagination: { el: '.swiper-pagination' }
    });

    gsap.registerPlugin(ScrollTrigger);

    gsap.from("#hero-text", {
      opacity: 0,
      y: 50,
      duration: 1.5,
      ease: "power3.out",
      scrollTrigger: {
        trigger: "#hero-text",
        start: "top 90%",
      }
    });

    gsap.from(".about-title", {
      opacity: 0,
      y: -50,
      duration: 1,
      scrollTrigger: {
        trigger: ".about-title",
        start: "top 90%",
      }
    });

    gsap.from([".about-img", ".about-text"], {
      opacity: 0,
      x: -50,
      duration: 1,
      stagger: 0.3,
      scrollTrigger: {
        trigger: ".about-section",
        start: "top 80%",
      }
    });

    /*gsap.from(".facilities-title", {
      opacity: 0,
      y: -40,
      duration: 1,
      scrollTrigger: {
        trigger: ".facilities-title",
        start: "top 85%",
      }
    });

    gsap.from(".facility", {
      opacity: 0,
      y: 50,
      duration: 0.8,
      stagger: 0.2,
      scrollTrigger: {
        trigger: ".facilities-items",
        start: "top 85%",
      }
    });*/

    gsap.from(".testimonial-title", {
      opacity: 0,
      y: -50,
      duration: 1,
      scrollTrigger: {
        trigger: ".testimonial-title",
        start: "top 90%",
      }
    });

    gsap.from(".testimonial-item", {
      opacity: 0,
      x: 50,
      duration: 0.8,
      stagger: 0.3,
      scrollTrigger: {
        trigger: ".testimonial-section",
        start: "top 80%",
      }
    });
  </script>
</body>
</html>
