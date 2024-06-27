<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de colecciones personales</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="main.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row justify-content-center align-items-center h-100 text-center">
            <div class="col-md-6">
                <div class="card bg-default">
                    <div class="card-header">
                        <h3 id="toggleTitle">¿Aún no tienes una cuenta?</h3>
                        <button onclick="toggleForm()" class="btn btn-link" id="toggleForm">Crear cuenta</button>
                    </div>
                    <div class="card-body">
                        <!-- Login -->
                        <form id="loginForm" action="auth/login.php" method="post">
                            <h4>Iniciar sesión</h4>
                            <div class="form-group"> <!-- Contenido del formulario -->
                                <label for="email" class="text-secondary">Correo electrónico</label>
                                <input maxlength="100" type="email" class="form-control" name="email" id="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-secondary">Contraseña</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>

                            <input type="submit" class="btn btn-primary mt-3" value="Iniciar sesión">
                        </form>

                        <!-- Register -->
                        <form style="display: none;" id="registerForm" action="auth/register.php" method="post"> <!--  style="display: none;" -->
                            <h4>Crear cuenta</h4>
                            <div class="form-group"> <!-- Contenido del formulario -->
                                <label for="username" class="text-secondary">Nombre de usuario</label>
                                <input maxlength="50" type="text" class="form-control" name="username" id="username" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="text-secondary">Correo electrónico</label>
                                <input maxlength="100" type="email" class="form-control" name="email" id="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-secondary">Contraseña</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password" class="text-secondary">Confirmar contraseña</label>
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
                            </div>

                            <input type="submit" class="btn btn-primary mt-3" value="Crear cuenta">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="toast text-bg-success" id="successToast" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 20px; right: 20px;">
            <div class="toast-header">
                <strong class="me-auto">¡Éxito!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <?= htmlspecialchars($_GET['success'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
            </div>
        </div>

        <div class="toast text-bg-danger" id="errorToast" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 20px; right: 20px;">
            <div class="toast-header">
                <strong class="me-auto">¡Error!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <?= htmlspecialchars($_GET['error'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <script>
        function toggleForm() {
            let registerForm = document.getElementById("registerForm");
            let loginForm = document.getElementById("loginForm");
            let toggleBtn = document.getElementById("toggleForm");
            let toggleTitle = document.getElementById("toggleTitle");

            if (registerForm.style.display === "none") {
                registerForm.style.display = "block";
                loginForm.style.display = "none";
                toggleTitle.textContent = "¿Ya tienes una cuenta?";
                toggleBtn.textContent = "Iniciar sesión";
            } else {
                registerForm.style.display = "none";
                loginForm.style.display = "block";
                toggleTitle.textContent = "¿Aún no tienes una cuenta?";
                toggleBtn.textContent = "Crear cuenta";
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Mostrar toast de éxito si existe la URL de éxito
            <?php if (isset($_GET['success'])): ?>
                var successToastEl = document.getElementById('successToast');
                var successToast = new bootstrap.Toast(successToastEl);
                successToast.show();
            <?php endif; ?>

            // Mostrar toast de error si existe la URL de error
            <?php if (isset($_GET['error'])): ?>
                var errorToastEl = document.getElementById('errorToast');
                var errorToast = new bootstrap.Toast(errorToastEl);
                errorToast.show();
            <?php endif; ?>

            // Limpiar los parámetros de éxito y error de la URL
            var url = new URL(window.location.href);
            url.searchParams.delete('success');
            url.searchParams.delete('error');
            window.history.replaceState({}, document.title, url.toString());
        });
    </script>

</body>

</html>