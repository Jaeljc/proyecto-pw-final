<?php
require_once 'includes/conexion.php';
$tituloPagina = 'Contacto';

$errores   = [];
$exito     = false;
$valores   = ['nombre' => '', 'correo' => '', 'asunto' => '', 'comentario' => ''];

// ── Procesar formulario (POST) ───────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitizar entradas
    $nombre     = trim(htmlspecialchars($_POST['nombre']     ?? ''));
    $correo     = trim(htmlspecialchars($_POST['correo']     ?? ''));
    $asunto     = trim(htmlspecialchars($_POST['asunto']     ?? ''));
    $comentario = trim(htmlspecialchars($_POST['comentario'] ?? ''));

    $valores = compact('nombre', 'correo', 'asunto', 'comentario');

    // Validaciones
    if (empty($nombre))     $errores['nombre']     = 'El nombre es obligatorio.';
    if (empty($correo))     $errores['correo']     = 'El correo es obligatorio.';
    elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores['correo'] = 'Ingresa un correo válido.';
    if (empty($asunto))     $errores['asunto']     = 'El asunto es obligatorio.';
    if (empty($comentario)) $errores['comentario'] = 'El comentario es obligatorio.';

    // Si no hay errores, insertar con PDO
    if (empty($errores)) {
        $pdo = getConexion();

        
        $pdo->exec("CREATE TABLE IF NOT EXISTS `contacto` (
            `id`          INT(11)      NOT NULL AUTO_INCREMENT,
            `fecha`       DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `nombre`      VARCHAR(100) NOT NULL,
            `correo`      VARCHAR(150) NOT NULL,
            `asunto`      VARCHAR(200) NOT NULL,
            `comentario`  TEXT         NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $stmt = $pdo->prepare(
            "INSERT INTO contacto (fecha, nombre, correo, asunto, comentario)
             VALUES (NOW(), :nombre, :correo, :asunto, :comentario)"
        );
        $stmt->execute([
            ':nombre'     => $nombre,
            ':correo'     => $correo,
            ':asunto'     => $asunto,
            ':comentario' => $comentario,
        ]);

        $exito  = true;
        $valores = ['nombre' => '', 'correo' => '', 'asunto' => '', 'comentario' => ''];
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <!-- Alerta de éxito -->
        <?php if ($exito): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>¡Mensaje enviado!</strong> Tu mensaje ha sido recibido correctamente. Te responderemos pronto.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
        <?php endif; ?>

        <!-- Tarjeta del formulario -->
        <div class="contacto-card card shadow">
            <div class="card-header bg-primary text-white py-3 px-4">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-envelope-fill me-2"></i>Envíanos un Mensaje
                </h5>
            </div>
            <div class="card-body p-4 p-md-5">

                <form id="formContacto" method="POST" action="contacto.php" novalidate>

                    <!-- Nombre -->
                    <div class="mb-4">
                        <label for="nombre" class="form-label fw-semibold">
                            <i class="bi bi-person me-1 text-primary"></i>Nombre completo
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="nombre" name="nombre"
                               class="form-control <?= isset($errores['nombre']) ? 'is-invalid' : '' ?>"
                               value="<?= htmlspecialchars($valores['nombre']) ?>"
                               placeholder="Ej. Juan Pérez"
                               maxlength="100" required>
                        <?php if (isset($errores['nombre'])): ?>
                            <div class="invalid-feedback"><?= $errores['nombre'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Correo -->
                    <div class="mb-4">
                        <label for="correo" class="form-label fw-semibold">
                            <i class="bi bi-envelope me-1 text-primary"></i>Correo electrónico
                            <span class="text-danger">*</span>
                        </label>
                        <input type="email" id="correo" name="correo"
                               class="form-control <?= isset($errores['correo']) ? 'is-invalid' : '' ?>"
                               value="<?= htmlspecialchars($valores['correo']) ?>"
                               placeholder="ejemplo@correo.com"
                               maxlength="150" required>
                        <?php if (isset($errores['correo'])): ?>
                            <div class="invalid-feedback"><?= $errores['correo'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Asunto -->
                    <div class="mb-4">
                        <label for="asunto" class="form-label fw-semibold">
                            <i class="bi bi-chat-text me-1 text-primary"></i>Asunto
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="asunto" name="asunto"
                               class="form-control <?= isset($errores['asunto']) ? 'is-invalid' : '' ?>"
                               value="<?= htmlspecialchars($valores['asunto']) ?>"
                               placeholder="¿Sobre qué deseas consultarnos?"
                               maxlength="200" required>
                        <?php if (isset($errores['asunto'])): ?>
                            <div class="invalid-feedback"><?= $errores['asunto'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Comentario -->
                    <div class="mb-4">
                        <label for="comentario" class="form-label fw-semibold">
                            <i class="bi bi-pencil-square me-1 text-primary"></i>Comentario / Mensaje
                            <span class="text-danger">*</span>
                        </label>
                        <textarea id="comentario" name="comentario" rows="5"
                                  class="form-control <?= isset($errores['comentario']) ? 'is-invalid' : '' ?>"
                                  placeholder="Escribe tu mensaje aquí…"
                                  required><?= htmlspecialchars($valores['comentario']) ?></textarea>
                        <?php if (isset($errores['comentario'])): ?>
                            <div class="invalid-feedback"><?= $errores['comentario'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Botón enviar -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-send-fill me-2"></i>Enviar Mensaje
                        </button>
                    </div>

                    <p class="text-muted small text-center mt-3 mb-0">
                        <i class="bi bi-shield-check me-1"></i>
                        Tu información es confidencial y no será compartida con terceros.
                    </p>

                </form>
            </div>
        </div>

        <!-- Info de contacto -->
        <div class="row g-3 mt-4">
            <div class="col-sm-4">
                <div class="card text-center shadow-sm border-0 h-100 py-3">
                    <div class="card-body">
                        <i class="bi bi-geo-alt-fill text-primary fs-2 mb-2"></i>
                        <h6 class="fw-bold">Dirección</h6>
                        <p class="text-muted small mb-0">Santo Domingo, República Dominicana</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-center shadow-sm border-0 h-100 py-3">
                    <div class="card-body">
                        <i class="bi bi-telephone-fill text-primary fs-2 mb-2"></i>
                        <h6 class="fw-bold">Teléfono</h6>
                        <p class="text-muted small mb-0">+1 (809) 000-0000</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-center shadow-sm border-0 h-100 py-3">
                    <div class="card-body">
                        <i class="bi bi-envelope-fill text-primary fs-2 mb-2"></i>
                        <h6 class="fw-bold">Correo</h6>
                        <p class="text-muted small mb-0">info@libreria.com</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
