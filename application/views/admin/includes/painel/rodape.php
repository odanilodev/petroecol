<footer class="footer position-absolute">
    <div class="row g-0 justify-content-between align-items-center h-100">
        <div class="col-12 col-sm-auto text-center">
            <p class="mb-0 mt-2 mt-sm-0 text-900">Desenvolvido por <a class="mx-1" href="https://centrodainteligencia.com.br">Centro da Inteligência</a><span class="d-none d-sm-inline-block"></span><span class="d-none d-sm-inline-block mx-1">|</span><br class="d-sm-none" />2023 &copy; Todos os direitos reservados</p>
        </div>
        <div class="col-12 col-sm-auto text-center">
            <p class="mb-0 text-600">v1.0.0</p>
        </div>
    </div>
</footer>
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