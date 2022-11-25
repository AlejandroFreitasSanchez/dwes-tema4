<?php
session_start();
require 'modelo.php';

//si no estas logueado te dice que no tienes permisos y no muestra la pagina
if(!$_SESSION || !$_SESSION['usuario']) {
    header('HTTP/1.0 401 Unauthorized');
    echo "No puedes acceder a esta pagina, <a href='../login.php'>Inicia sesion</a>";
    exit();
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
            <li><a href="../index.php">Home</strong></li>
            <li><a href="../pagina_publica.php">Página pública</a></li>
            <li><strong>Página privada</strong></li>
            <li><a href="tienda.php">Tienda</a></li>
            <li><a href="carrito.php">Carrito (<?= totalProductos() ?>)</a></li>
            <li><a href="logout.php">Cerrar sesión (<?php if(isset($_SESSION['usuario'])){echo $_SESSION['usuario'];} ?>)</a></li>
        </ul>
    </nav>

    <main>
        <section>
            <article>
                <h1>Página privada</h1>
                <p>
                    Esta es la página privada, aquí solo debería acceder usuarios
                    registrados y que hayan iniciado sesión.
                </p>
            </article>
        </section>
    </main>

    <footer>
        <small>&copy; sitio web</small>
    </footer>
</body>
</html>