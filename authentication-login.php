<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <!--<title> Login and Registration Form in HTML & CSS | CodingLab </title>-->
  <link rel="stylesheet" href="dist/css/login/login.css">
  <!-- Fontawesome CDN Link -->
  <!--
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
-->
  <link rel="stylesheet" href="assets/font/fontawesome/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="dist/css/login/frontImg3.png" alt="">
        <div class="text">
        </div>
      </div>
      <div class="back">
        <div class="text">
          <span class="text-1">Complete miles of journey <br> with one step</span>
          <span class="text-2">Let's get started</span>
        </div>
      </div>
    </div>
    <div class="forms">
      <div class="form-content">
        <div class="login-form">
          <div class="title">Iniciar sesi&oacuten</div>
          <form id="loginform" method="">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" placeholder="Usuario" id="nick" name="nick" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Contraseña" id="password" name="password" required>
              </div>
              <div class="text"><a href="#">¿Olvidaste tu contraseña?</a></div>
              <div class="button input-box">
                <input type="submit" value="Ingresar" id="inicio-sesion">
              </div>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- All Required js -->
  <!-- ============================================================== -->
  <script src="assets/jquery/jquery.min.js"></script>
  <!--
  <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="./assets/libs/popper.js/dist/umd/popper.min.js"></script>
  <script src="./assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
-->
  <!-- Bootstrap tether Core JavaScript -->
  <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="assets/dist/js/sweetalert2.all.min.js"></script>

  
  <!-- ============================================================== -->
  <!-- This page plugin js -->
  <!-- ============================================================== -->
  <script>
    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();
    // ============================================================== 
    // Login and Recover Password 
    // ============================================================== 
    // $('#to-recover').on("click", function() {
    //     $("#loginform").slideUp();
    //     $("#recoverform").fadeIn();
    // });

    $('#loginform').submit(function (e) {
      const data = {
        nick: $('#nick').val(),
        password: $('#password').val()
      };
      $.post('inicio_sesion.php', data, function (response) {

      console.log(response)
        if (response == 'acceso') {
          window.location.href = 'App/View/System/home/index.php';
        } else {
          ventanaMensaje("Usuario o contraseña incorrectos");
        }
      });
      e.preventDefault();
    });

    function ventanaMensaje(txt) {
      $('#nick').val("");
      $('#password').val("");
      Swal.fire({
        title: txt,
        icon: 'error'
      });
    }
  </script>


</body>



</html>