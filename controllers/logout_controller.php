<?php

require_once __DIR__ . '/../models/config.php'; 

class LogoutController
{
    /**
     * Ejecuta el proceso de logout:
     * - limpia sesión
     * - destruye cookie
     * - redirige a login
     */
    public function logout(): void
    {
        // Iniciar/reanudar sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Limpiar datos de sesión
        $_SESSION = [];

        // Eliminar cookie de sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // Destruir sesión
        session_destroy();

        // Redirigir
        header('Location: ' . BASE_URL . 'index.php');
        exit;
    }
}

$controller = new LogoutController();
$controller->logout();

?>