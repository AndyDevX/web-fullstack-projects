<?php
include ("../conexion.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Capturar información
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validar información
    if (empty($email) || empty($password)) {
        $error_message = "¡Por favor llena todos los campos!";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "¡Correo electrónico no válido!";
    } else {
        // Verificar existencia del usuario
        $stmt = $connection -> prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt -> bind_param("s", $email);
        $stmt -> execute();
        $stmt -> store_result();

        if ($stmt -> num_rows > 0) {
            // Ejecutar el resto de la operación
            $stmt -> bind_result($user_id, $hashed_password);
            $stmt -> fetch();

            // Verificar si la contraseña coincide
            if (password_verify($password, $hashed_password)) {
                // Contraseña correcta
                $success_message = "¡Inicio de sesión correcto!";
            } else {
                // Contraseña incorrecta
                $error_message = "¡Contraseña incorrecta!";
            }
        } else {
            $error_message = "¡Usuario no encontrado!";
        }
    }

    if (isset($error_message)) {
        header("Location: ../index.php?error=".urlencode($error_message));
        exit;
    } else if (isset($success_message)) {
        header("Location: ../home.php?success=".urlencode($success_message));
        exit;
    }
}