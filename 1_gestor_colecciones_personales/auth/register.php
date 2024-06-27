<?php
include ("../conexion.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Capturar información
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validar información
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "¡Por favor llena todos los campos!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "¡Correo electrónico no válido!";
    } elseif ($password !== $confirm_password) {
        $error_message = "¡Las contraseñas no coinciden!";
    } else {
        // Verificar disponibilidad del correo
        $stmt = $connection -> prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt -> num_rows > 0) {
            $error_message = "¡Este correo electrónico ya está en uso!";
        } else {
            // Procesar información
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            try {
                // Preparar la declaración
                $statement = $connection -> prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $statement -> bind_param("sss", $username, $email, $hashed_password);

                // Ejecutar la inserción
                $statement -> execute();

                // Verificar si se insertó
                if ($statement -> affected_rows > 0) {
                    $success_message = "¡Usuario registrado correctamente!";
                } else {
                    $error_message = "¡Error al registrar el usuario!";
                }

            } catch (mysqli_sql_exception $e) {
                $error_message = "¡Error al registrar! " . $e -> getMessage();
            }
        }
    }

    if (isset($error_message)) {
        header("Location: ../index.php?error=".urlencode($error_message));
        exit;
    } else if (isset($success_message)) {
        header("Location: ../index.php?success=".urlencode("¡Registro correcto!"));
        exit;
    }
}