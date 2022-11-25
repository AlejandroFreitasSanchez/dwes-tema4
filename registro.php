<?php
session_start();

//si hay una seseion iniciada rederidige a index.php
if (isset($_SESSION['usuario'])) {
    header('location: index.php');
    exit();
}

require 'lib/gestionUsuarios.php';

//Si hay post y errores en el registro, se guardan para usarlos en los mensajes de error.
if ($_POST) {
    $errores = registroUsuario(
        isset($_POST['usuario']) ? $_POST['usuario'] : "",
        isset($_POST['clave']) ?  $_POST['clave'] : "",
        isset($_POST['repite_clave']) ?  $_POST['repite_clave'] : ""
    );
    
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registro de usuarios</title>
</head>

<body>
   
    <header>
        <h1>Sistema de autenticación</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="pagina_publica.php">Página pública</a></li>
            <li><a href='login.php'>Iniciar sesión</a></li>
            <li><strong>Regístrate</strong></li>
        </ul>
    </nav>

    <main>
        <?php
        if (!$_POST || ($_POST && $errores)){   ?>
      
        <h1>Regístrate</h1>
        <form action="registro.php" method="post">
            <p>
                <label for="usuario">Nombre de usuario</label><br>
                <input type="text" name="usuario" id="usuario" 
                       value="<?php echo $_POST && isset($_POST['usuario']) ? $_POST['usuario'] : "";?>">
                <p class="mensajeError" style="color: red;"><?php if(isset($errores) && isset($errores['usuario'])){echo $errores['usuario'];};?></p>
            </p>
            <p>
                <label for="clave">Contraseña</label><br>
                <input type="password" name="clave" id="clave">
                <p class="mensajeError" style="color: red;"><?php if(isset($errores) && isset($errores['clave'])){echo $errores['clave'];};?></p>
            </p>
            <p>
                <label for="repite_clave">Repite la contraseña</label><br>
                <input type="password" name="repite_clave" id="repite_clave">
                <p class="mensajeError" style="color: red;"><?php if(isset($errores) && isset($errores['repite_clave'])){echo $errores['repite_clave'];};?></p>
            </p>
            <p>
                <input type="submit" value="Registrarse">
            </p>
        </form>
        <?php }else{
            echo "<h2 style='color: black;'>Te has registrado correctamente :D</h2>";
            echo "<h2><a href='login.php'>Iniciar sesión</a></h2>";
        }?>
    </main>

    <footer>
        <small>&copy; sitio web</small>
    </footer>
</body>

</html>