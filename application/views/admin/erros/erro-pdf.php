<!DOCTYPE html>
<html lang="pt-br" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?= $this->session->userdata('nome_empresa') ?? $titulo; ?></title>

  <!-- Links header -->
  <?php header_scripts(); ?>

  <script>
    var phoenixIsRTL = window.config.config.phoenixIsRTL;
    if (phoenixIsRTL) {
      var linkDefault = document.getElementById('style-default');
      var userLinkDefault = document.getElementById('user-style-default');
      linkDefault.setAttribute('disabled', true);
      userLinkDefault.setAttribute('disabled', true);
      document.querySelector('html').setAttribute('dir', 'rtl');
    } else {
      var linkRTL = document.getElementById('style-rtl');
      var userLinkRTL = document.getElementById('user-style-rtl');
      linkRTL.setAttribute('disabled', true);
      userLinkRTL.setAttribute('disabled', true);
    }
  </script>
</head>


<body>

  <!-- ===============================================-->
  <!--    Main Content-->
  <!-- ===============================================-->
  <main class="main" id="top">
    <div class="px-3">
      <div class="row min-vh-100 flex-center p-5">
        <div class="col-12 col-xl-10 col-xxl-8">
          <div class="row justify-content-center align-items-center g-5">

            <div class="col-12 col-lg-6 text-center">

              <img class="img-fluid mb-6 w-100 w-lg-75 d-dark-none" src="<?= base_url('assets/img/icons/error-azul.png'); ?>" alt="" />

              <img class="img-fluid mb-6 w-100 w-lg-75 d-light-none" src="<?= base_url('assets/img/icons/error-azul.png'); ?>" alt="" />

              <h2 class="text-800 fw-bolder mb-3"><?= $titulo; ?></h2>
              <p class="text-900 mb-5"><?= $descricao; ?></p>

              <a class="btn btn-lg btn-primary w-100 cursor-pointer" href="<?=base_url('relatorios/relColetas')?>">Voltar</a>
            </div>
          </div>
        </div>
      </div>
    </div>


    <script>
      var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
      var navbarTop = document.querySelector('.navbar-top');
      if (navbarTopStyle === 'darker') {
        navbarTop.classList.add('navbar-darker');
      }

      var navbarVerticalStyle = window.config.config.phoenixNavbarVerticalStyle;
      var navbarVertical = document.querySelector('.navbar-vertical');
      if (navbarVertical && navbarVerticalStyle === 'darker') {
        navbarVertical.classList.add('navbar-darker');
      }
    </script>
  </main>
  <!-- ===============================================-->
  <!--    End of Main Content-->
  <!-- ===============================================-->





  <!-- ===============================================-->
  <!--    JavaScripts-->
  <!-- ===============================================-->

  <?php footer_scripts(); ?>

</body>

</html>