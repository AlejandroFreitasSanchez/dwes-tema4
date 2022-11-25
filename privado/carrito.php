<?php
require 'modelo.php';
session_start();

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
    <title>Carrito de la compra</title>
</head>
<body>
    <header>
        <h1>Tu carrito:</h1>
    </header>

    <nav>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="../pagina_publica.php">Página pública</a></li>
            <li><a href="pagina_privada.php">Página privada</a></li>
            <li><a href="tienda.php">Tienda</a></li>
            <li><strong>Carrito (<?= totalProductos() ?>)</strong></li>
            <?php echo "<li><a href='logout.php'>Cerrar sesión ({$_SESSION['usuario']})</a></li>"; ?>
        </ul>
    </nav>

    <main>
        <section>
            <h1>Cesta de la compra</h1>
            
            <?php
            if ($_SESSION) {
                echo "<ul>";
                //muestra todos los productos guardados en _SESSION['carro]
                foreach ($_SESSION['carro'] as $producto => $cantidad) { 
                    echo <<<END
                        <li>$producto: $cantidad</li>
                    END;
                }
                echo "</ul>";
            } else {
                echo "<p>No hay productos en el carrito de la compra</p>";
            }
            ?>
        </section>
    </main>

    <footer>
        <small><em>&copy; El SuperCarrito de la compra</em></small>
    </footer>
</body>
</html>
