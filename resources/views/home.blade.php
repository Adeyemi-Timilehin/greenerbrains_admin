<!DOCTYPE HTML>
<!--
	Projection by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>

<head>
  <title>GreenerBrains Mobile</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="assets/css/main.css" />
  <script src="js/api.js"></script>
</head>

<body>

  <!-- Header -->
  <header id="header">
    <div class="inner">
      <a href="/" class="logo"><strong>Greenerbrains</strong></a>
      <nav id="nav">
        @if(\Auth::check())
        <a id="home_link" href="{{ url('/home') }}">Home</a>
        <a id="dashboard_link" href="{{ route('dashboard') }}">Dashboard</a>
        <a id="logout_link" href="{{ route('logout') }}">Logout</a>
        @else
        <a id="login_link" href="{{ route('login') }}">Login</a>
        <!--<a id="register_link" href="{{ route('register') }}">Register</a>-->
        @endif
        <script>
          if (API.isLoggedIn()) {
            let nav = document.getElementById("nav");
            if (nav) {

            }
          }
        </script>
      </nav>
      <a href="#navPanel" class="navPanelToggle"><span class="fa fa-bars"></span></a>
    </div>
  </header>

  <!-- Banner -->
  <section id="banner">
    <div class="inner">
      <header>
        <h1>GreenerBrains</h1>
      </header>

      <div class="flex ">
        <div>
          <span class="icon fa-camera"></span>
          <h3>Learn</h3>
          <p>We make learning funfilled</p>
        </div>

        <div>
          <span class="icon fa-car"></span>
          <h3>Subscribe</h3>
          <p>Subscribe to premium courses</p>
        </div>

        <div>
          <span class="icon fa-bug"></span>
          <h3>Get Better</h3>
          <p>Study to get yourself approved</p>
        </div>

      </div>

      <footer>
        <a href="http://www.greenerbrains.com/register" class="button">Get Started</a>
      </footer>
    </div>
  </section>


  <!-- Three -->
  <section id="three" class="wrapper align-center">
    <div class="inner">
      <div class="flex flex-2">
        <article>
          <div class="image round">
            <img src="images/pic01.jpg" alt="Pic 01" />
          </div>
          <header>
            <h3>Free Courses</h3>
          </header>
          <p>Valued courses given out for free </p>
          <footer>
            <a href="http://www.greenerbrains.com/course" class="button">Learn More</a>
          </footer>
        </article>
        <article>
          <div class="image round">
            <img src="images/pic02.jpg" alt="Pic 02" />
          </div>
          <header>
            <h3>Premium Courses</h3>
          </header>
          <p>Get access to high quality premium courses when you subscribe</p>
          <footer>
            <a href="http://www.greenerbrains.com/course" class="button">Learn More</a>
          </footer>
        </article>
      </div>
    </div>
  </section>

  <!-- Footer -->
  {{-- <footer id="footer">
				<div class="inner">

					<h3>Get in touch</h3>

					<form action="#" method="post">

						<div class="field half first">
							<label for="name">Name</label>
							<input name="name" id="name" type="text" placeholder="Name">
						</div>
						<div class="field half">
							<label for="email">Email</label>
							<input name="email" id="email" type="email" placeholder="Email">
						</div>
						<div class="field">
							<label for="message">Message</label>
							<textarea name="message" id="message" rows="6" placeholder="Message"></textarea>
						</div>
						<ul class="actions">
							<li><input value="Send Message" class="button alt" type="submit"></li>
						</ul>
					</form>

					<div class="copyright">
						&copy; Untitled. Design: <a href="https://templated.co">TEMPLATED</a>. Images: <a href="https://unsplash.com">Unsplash</a>.
					</div>

				</div>
			</footer>  --}}

  <!-- Scripts -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/skel.min.js"></script>
  <script src="assets/js/util.js"></script>
  <script src="assets/js/main.js"></script>


</body>

</html>