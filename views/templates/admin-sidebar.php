<aside class="dashboard__sidebar">
    <nav class="dashboard__menu">
        <a href="/admin/dashboard" class="dashboard__enlace <?php echo pagina_actual("/dashboard") ? "dashboard__enlace--actual" : ""; ?> ">
            <i class="fa-solid fa-house dashboard__icono"></i>
            <samp class="dashboard__menu-texto">
                Inicio
            </samp>
        </a>

        <a href="/admin/ponentes" class="dashboard__enlace <?php echo pagina_actual("/ponentes")? "dashboard__enlace--actual" : ""; ?> ">
            <i class="fa-solid fa-microphone dashboard__icono"></i>
            <samp class="dashboard__menu-texto">
                Ponentes
            </samp>
        </a>

        <a href="/admin/eventos" class="dashboard__enlace <?php echo pagina_actual("/eventos")? "dashboard__enlace--actual" : ""; ?> ">
            <i class="fa-solid fa-calendar dashboard__icono"></i>
            <samp class="dashboard__menu-texto">
                Eventos
            </samp>
        </a>

        <a href="/admin/registrados" class="dashboard__enlace <?php echo pagina_actual("/registrados")? "dashboard__enlace--actual" : ""; ?> ">
            <i class="fa-solid fa-users dashboard__icono"></i>
            <samp class="dashboard__menu-texto">
                Registrados
            </samp>
        </a>

        <a href="/admin/regalos" class="dashboard__enlace <?php echo pagina_actual("/regalos")? "dashboard__enlace--actual" : ""; ?> ">
            <i class="fa-solid fa-gift dashboard__icono"></i>
            <samp class="dashboard__menu-texto">
                Regalos
            </samp>
        </a>
    </nav>
</aside>