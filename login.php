<?php
session_start();
//Si hay una seseion iniciada rederidige a index.php
if (isset($_SESSION['usuario'])) {
    header('location: index.php');
    exit();
}

require 'lib/gestionUsuarios.php';

//Si hay post y el usuario se loguea correctamente _SESSION['usuario'] pasa a ser el usuario introducido por post. Te redirige al index.php. Se crea en session un carrito
if ($_POST) {
    if(loginUsuario($_POST['usuario'], $_POST['clave'])){
        $_SESSION['usuario'] = $_POST['usuario'];
        $_SESSION['carro'] = [];
        header('location: index.php');
    }
    
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de autenticación</title>
</head>
<body>
    <header>
        <h1>Sistema de autenticación</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="pagina_publica.php">Página pública</a></li>
            <li><strong>Iniciar sesión</strong></li>
            <li><a href='registro.php'>Regístrate</a></li>
        </ul>
    </nav>

    <main>
        <h1>Inicia sesión</h1>

        <form action="login.php" method="post">
            <p>
                <label for="usuario">Nombre de usuario</label><br>
                <input type="text" name="usuario" id="usuario" value="<?php echo $_POST && isset($_POST['usuario']) ? $_POST['usuario'] : "";?>">
            </p>
            <p>
                <label for="clave">Contraseña</label><br>
                <input type="password" name="clave" id="clave">
            </p>
            <p>
                <input type="submit" value="Inicia sesión">
            </p>
        </form>

        <?php
            //Si hay post es que ha habido un error.
            if($_POST){      
                echo "Contraseña o usuario incorrectos";
            }
        ?>
    </main>

    <footer>
        <small>&copy; sitio web</small>
    </footer>
</body>
</html>
