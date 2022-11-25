<?php

/**
 * Lee el fichero JSON con los usuarios registrados en busca del
 * usuario indicado como argumento.
 * 
 * Devuelve true si existe y false en caso contrario.
 */
function existeUsuario(string $usuario): bool
{
    $jsonString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/bd/usuarios.json');
    $jsonData = json_decode($jsonString);

    if (!$jsonData) {
        return false;
    }

    foreach ($jsonData->usuarios as $usuarioRegistrado) {
        if ($usuarioRegistrado->usuario == $usuario) {
            return true;
        }
    }

    return false;
}

/**
 * Devuelve un array con el usaurio o un array vacío si no existe.
 */
function getUsuario(string $usuario): array
{
    $jsonString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/bd/usuarios.json');
    $jsonData = json_decode($jsonString);

    if (!$jsonData) {
        return [];
    }

    foreach ($jsonData->usuarios as $usuarioRegistrado) {
        if ($usuarioRegistrado->usuario == $usuario) {
            return ['usuario' => $usuarioRegistrado->usuario, 'clave' => $usuarioRegistrado->clave];
        }
    }

    return [];
}

/**
 * Inserta en el fichero de usuarios al usuario con la clave indicada.
 */
function insertUsuario(string $usuario, string $clave)
{
    $jsonString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/bd/usuarios.json');
    $jsonData = json_decode($jsonString);
    //var_dump($jsonData);
    if (!$jsonData) {
        $jsonData = [];
        $jsonData['usuarios'] =  [['usuario' => $usuario, 'clave' => password_hash($clave, PASSWORD_BCRYPT)]];
    }else{
        $jsonData->usuarios[] = ['usuario' => $usuario, 'clave' => password_hash($clave, PASSWORD_BCRYPT)];
    }
   
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/bd/usuarios.json', json_encode($jsonData));
}

/**
 * Realiza la validación del nuevo usuario y devuelve un array vacío si no hay
 * errores y un array de arrays con los errores.
 */
function validaRegistro(string $usuario, string $clave, string $repiteClave): array
{
    $errores = [];

    if (!ctype_alnum($usuario)) {
        $errores['usuario'] = 'El nombre de usuario solo puede contener caracteres alfanuméricos';
    } else if (existeUsuario($usuario)) {
        $errores['usuario'] = 'Nombre de usuario no disponible';
    }

    if (strlen($clave) < 8) {
        $errores['clave'] = 'La contraseña debe ser de 8 caracteres como mínimo';
    } else if ($clave !== $repiteClave) {
        $errores['clave'] = 'Las contraseñas introducidas no coinciden';
    }

    return $errores;
}

/**
 * Realiza el registro del nuevo usuario con los datos enviados por argumento.
 * 
 * Si el registro se lleva a cabo sin problemas devuelve null.
 * Si hay errores envía un array de arrays con los errores.
 */
function registroUsuario(string $usuario, string $clave, string $repiteClave)
{
    $errores = validaRegistro($usuario, $clave, $repiteClave);

    if (empty($errores)) {
        insertUsuario($usuario, $clave);
    }

    return !empty($errores) ? $errores : null;
}

/**
 * Realiza el "login" del usuario.
 * 
 * Devuelve true si existe un usuario con la clave indicada y false en caso
 * contrario.
 */
function loginUsuario(string $usuario, string $clave): bool
{
    $usuarioRegistrado = getUsuario($usuario);
    if (isset($usuarioRegistrado['clave']) && password_verify($clave, $usuarioRegistrado['clave'])) {
        return true;
    } else {
        return false;
    }
}
