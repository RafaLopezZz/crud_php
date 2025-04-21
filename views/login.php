<div class="row justify-content-center">
    <div class="col-md-6" style="padding-bottom: 10rem">
        <div class="card">
            <div class="card-header">
                Login
            </div>
            <div class="card-body">
                <form action="controllers/auth_controller.php" method="POST">
                    <div class="mb-3" style="padding-top: 10px">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </form>

                <div class="mt-4 text-center">
                    <p>¿No tienes cuenta? <a href="registro.php" class="btn btn-outline-secondary btn-sm">Regístrate aquí</a></p>
                </div>
            </div>
        </div>
    </div>
</div>