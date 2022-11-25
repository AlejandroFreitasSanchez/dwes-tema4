<?php
session_start();
require './privado/modelo.php';
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
            <li><strong>Página pública</strong></li>
            <?php
                if(isset($_SESSION['usuario'])){
                    echo "<li><a href='privado/pagina_privada.php'>Página privada</a></li>";
                    echo "<li><a href='privado/tienda.php'>Tienda</a></li>";
                    echo "<li><a href='privado/carrito.php'>Carrito (".totalProductos().")</a></li>";
                    echo "<li><a href='privado/logout.php'>Cerrar sesión ({$_SESSION['usuario']})</a></li>";
                }
            ?>
           
            <?php if(!isset($_SESSION['usuario'])){
                echo "<li><a href='login.php'>Iniciar sesión</a></li>";
                echo "<li><a href='registro.php'>Regístrate</a></li>";
            }
            ?>
        </ul>
    </nav>

    <main>
        <section>
            <article>
                <h1>Página pública</h1>
                <p>
                    Esta es la página pública, aquí puede acceder todo el mundo, estén o 
                    registrados y hayan o no iniciado sesión.
                </p>
            </article>
        </section>
    </main>

    <footer>
        <small>&copy; sitio web</small>
    </footer>
</body>
</html>
