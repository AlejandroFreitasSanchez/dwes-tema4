<?php
session_start();
require 'modelo.php';

//si no estas logueado te dice que no tienes permisos y no muestra la pagina
if(!$_SESSION || !$_SESSION['usuario']) {
    header('HTTP/1.0 401 Unauthorized');
    echo "No puedes acceder a esta pagina, <a href='../login.php'>Inicia sesion</a>";
    exit();
}


$productoNuevo = [];
//comprueba que un producto es valido pasandolo por los filtros
function productoValido($producto) {
    global $productos;
    $resultado = array_filter($productos, fn($p) => $p['id'] == $producto);
    if (count($resultado) == 1) {
        return $producto;
    } else {
        return false;
    }
}

if ($_POST) {
    //datos validados
    $datos = [
        'producto' => htmlspecialchars(trim($_POST['producto'])),
        'cantidad' => htmlspecialchars(trim($_POST['cantidad']))
    ];
    //array filtros
    $argumentos = [
        'producto' => [
            'filter' => FILTER_CALLBACK,
            'options' => 'productoValido'
        ],
        'cantidad' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range' => 1]
        ]
    ];

    $validaciones = filter_var_array($datos, $argumentos);

    //si las validaciones se cumplen:
    if ($validaciones['producto'] !== false && $validaciones['cantidad'] !== false) {
        //se recogen los datos
        $producto = $datos['producto'];
        $cantidad = $datos['cantidad'];
        //se pasan a la session
        $_SESSION['carro'][$producto] = $cantidad;

        $productoNuevo[$producto] = $cantidad;
        
        //var_dump($_SESSION['carro']);
        
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda</title>
</head>
<body>
    <header>
        <h1>Tienda</h1>
    </header>

    <nav>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="../pagina_publica.php">Página pública</a></li>
            <li><a href="pagina_privada.php">Página privada</a></li>
            <li><strong>Tienda</strong></li>
            <li><a href="carrito.php">Carrito (<?= totalProductos() ?>)</a></li>
            <?php echo "<li><a href='logout.php'>Cerrar sesión ({$_SESSION['usuario']})</a></li>"; ?>
        </ul>
    </nav>

    <main>
        <?php if ($productoNuevo) { ?>
        <section>
            <p>
                Se ha añadido un nuevo producto:
            </p>
            <p>
                <ul>
                    
                    <li><?= array_key_first($productoNuevo) . ": " . $productoNuevo[array_key_first($productoNuevo)] ?></li>
                </ul>
            </p>
        </section>
        <?php } ?>

        <section>
            <form action="" method="post">
                <p>
                    <label for="producto">Elige un producto</label>
                    <select name="producto" id="producto">
                        <?php 
                        //muestra la lista de productos
                        foreach ($productos as $producto) {
                            echo "<option value='{$producto['id']}'>{$producto['valor']}</option>";
                            //si el producto no es valido
                            if (isset($validaciones) && $validaciones['producto'] === false) {
                                echo "<p>$producto no es una opción válida</p>";
                            }
                        }
                        ?>
                    </select>
                </p>
                <p>
                    <label for="cantidad">Elige la cantidad</label>
                    <input type="number" name="cantidad" id="cantidad">
                    <?php
                    //si la cantidad es menor que 0:
                    if (isset($validaciones) && $validaciones['cantidad'] === false) {
                        echo "<p>{$datos['cantidad']} no es una cantidad válida, elige una cantidad mayor que 0</p>";
                    }
                    ?>
                </p>
                <p>
                    <input type="submit" value="Añadir al carrito">
                </p>
            </form>
        </section>
    </main>

    <footer>
        <small><em>&copy; El SuperCarrito de la compra</em></small>
    </footer>
</body>
</html>
