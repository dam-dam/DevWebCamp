<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo ?></h2>
    <p class="auth__texto">Confrma tu cuenta de DevWebcomb</p>

    <?php 
    require_once __DIR__ . "/../templates/alertas.php" ;
    //debuguear($usuario);
    ?>
    <?php if(isset($alertas["exito"])){ ?>
    
    <div class="acciones acciones--centrar">
            <a href="/login" class="acciones__enlace">Iniciar sesion</a>
    </div>
    <?php } ?>
   
    
</main>