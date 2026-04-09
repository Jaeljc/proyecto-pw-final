<?php
require_once 'includes/conexion.php';
$tituloPagina = 'Autores';

$pdo = getConexion();

// Consulta todos los autores con la cantidad de libros que tienen
$stmt = $pdo->query(
    "SELECT a.id_autor, a.apellido, a.nombre, a.telefono,
            a.ciudad, a.estado, a.pais,
            COUNT(ta.id_titulo) AS total_libros
     FROM autores a
     LEFT JOIN titulo_autor ta ON a.id_autor = ta.id_autor
     GROUP BY a.id_autor, a.apellido, a.nombre, a.telefono, a.ciudad, a.estado, a.pais
     ORDER BY a.apellido ASC, a.nombre ASC"
);
$autores = $stmt->fetchAll();
$totalAutores = count($autores);

include 'includes/header.php';
?>

<!-- Barra de filtros -->
<div class="filtros-bar d-flex flex-wrap align-items-center gap-3 mb-4">
    <div class="flex-grow-1">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" id="buscarAutor" class="form-control border-start-0 ps-0"
                   placeholder="Buscar por nombre, apellido o ciudad…" autocomplete="off">
        </div>
    </div>
    <div>
        <span class="badge bg-primary fs-6 px-3 py-2" id="contadorAutores">
            <?= $totalAutores ?> autor(es)
        </span>
    </div>
</div>

<!-- Mensaje sin resultados -->
<div id="sinResultadosAutor" class="alert alert-warning text-center d-none" role="alert">
    <i class="bi bi-search me-2"></i>No se encontraron autores con ese criterio.
</div>

<!-- Tabla de autores -->
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Autor</th>
                        <th>Teléfono</th>
                        <th>Ciudad</th>
                        <th>Estado</th>
                        <th>País</th>
                        <th class="text-center">Libros</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($autores as $autor): ?>
                    <?php
                        $nombreCompleto = trim($autor['nombre']) . ' ' . trim($autor['apellido']);
                        $busquedaData = strtolower($nombreCompleto . ' ' . $autor['ciudad'] . ' ' . $autor['pais']);
                        $iniciales = mb_strtoupper(mb_substr(trim($autor['nombre']), 0, 1) . mb_substr(trim($autor['apellido']), 0, 1));
                    ?>
                    <tr class="autor-fila" data-busqueda="<?= htmlspecialchars($busquedaData) ?>">
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="autor-avatar" style="width:42px; height:42px; font-size:1rem;">
                                    <?= $iniciales ?>
                                </div>
                                <div>
                                    <div class="fw-semibold"><?= htmlspecialchars($nombreCompleto) ?></div>
                                    <div class="text-muted small"><?= htmlspecialchars($autor['id_autor']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <i class="bi bi-telephone text-muted me-1"></i>
                            <?= htmlspecialchars($autor['telefono']) ?>
                        </td>
                        <td><?= htmlspecialchars($autor['ciudad']) ?></td>
                        <td><?= htmlspecialchars($autor['estado']) ?></td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                <?= htmlspecialchars($autor['pais']) ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <?php if ($autor['total_libros'] > 0): ?>
                                <span class="badge bg-primary rounded-pill">
                                    <?= $autor['total_libros'] ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted small">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Botón volver arriba -->
<button id="btnTop" class="btn btn-primary rounded-circle position-fixed bottom-0 end-0 m-4 shadow"
        style="display:none; width:46px; height:46px; align-items:center; justify-content:center;"
        title="Volver arriba">
    <i class="bi bi-arrow-up"></i>
</button>

<?php include 'includes/footer.php'; ?>
