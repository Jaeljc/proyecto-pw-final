<?php
require_once 'includes/conexion.php';
$tituloPagina = 'Libros';

$pdo = getConexion();

// Consulta todos los libros con sus autores (JOIN)
$stmt = $pdo->query(
    "SELECT t.id_titulo, t.titulo, t.tipo, t.precio, t.total_ventas,
            t.fecha_pub, t.notas,
            GROUP_CONCAT(CONCAT(a.nombre,' ',a.apellido) SEPARATOR ', ') AS autores
     FROM titulos t
     LEFT JOIN titulo_autor ta ON t.id_titulo = ta.id_titulo
     LEFT JOIN autores a        ON ta.id_autor  = a.id_autor
     GROUP BY t.id_titulo, t.titulo, t.tipo, t.precio, t.total_ventas, t.fecha_pub, t.notas
     ORDER BY t.titulo ASC"
);
$libros = $stmt->fetchAll();
$totalLibros = count($libros);

// Tipos únicos para el filtro
$tiposStmt = $pdo->query("SELECT DISTINCT tipo FROM titulos ORDER BY tipo");
$tipos = $tiposStmt->fetchAll(PDO::FETCH_COLUMN);

include 'includes/header.php';
?>

<!-- Barra de filtros -->
<div class="filtros-bar d-flex flex-wrap align-items-center gap-3 mb-4">
    <div class="flex-grow-1">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" id="buscarLibro" class="form-control border-start-0 ps-0"
                   placeholder="Buscar por título, autor o tipo…" autocomplete="off">
        </div>
    </div>
    <div>
        <span class="badge bg-primary fs-6 px-3 py-2" id="contadorResultados">
            <?= $totalLibros ?> libro(s)
        </span>
    </div>
</div>

<!-- Mensaje sin resultados -->
<div id="sinResultados" class="alert alert-warning text-center d-none" role="alert">
    <i class="bi bi-search me-2"></i>No se encontraron libros con ese criterio de búsqueda.
</div>

<!-- Grid de libros -->
<div class="row g-4" id="listaLibros">
    <?php foreach ($libros as $libro): ?>
    <?php
        $busquedaData = strtolower($libro['titulo'] . ' ' . ($libro['autores'] ?? '') . ' ' . str_replace('_', ' ', $libro['tipo']));
        $colorTipo = match(true) {
            str_contains($libro['tipo'], 'business')  => 'primary',
            str_contains($libro['tipo'], 'cook')      => 'success',
            str_contains($libro['tipo'], 'psych')     => 'info',
            str_contains($libro['tipo'], 'comp')      => 'warning',
            default                                   => 'secondary',
        };
    ?>
    <div class="col-md-6 col-lg-4 libro-item" data-busqueda="<?= htmlspecialchars($busquedaData) ?>">
        <div class="card h-100 shadow-sm libro-card">
            <div class="card-header bg-white border-bottom d-flex align-items-center gap-3 py-3">
                <div class="book-icon">
                    <i class="bi bi-book-fill"></i>
                </div>
                <div class="overflow-hidden">
                    <span class="badge bg-<?= $colorTipo ?> tipo-badge mb-1">
                        <?= htmlspecialchars(str_replace('_', ' ', $libro['tipo'])) ?>
                    </span>
                    <h6 class="mb-0 text-truncate" title="<?= htmlspecialchars($libro['titulo']) ?>">
                        <?= htmlspecialchars($libro['titulo']) ?>
                    </h6>
                </div>
            </div>
            <div class="card-body">
                <!-- Autor(es) -->
                <p class="mb-2 small">
                    <i class="bi bi-person-fill text-primary me-1"></i>
                    <strong>Autor(es):</strong>
                    <?= htmlspecialchars($libro['autores'] ?? 'No registrado') ?>
                </p>
                <!-- Precio -->
                <p class="mb-2 small">
                    <i class="bi bi-tag-fill text-success me-1"></i>
                    <strong>Precio:</strong>
                    <?php if ($libro['precio']): ?>
                        <span class="fw-bold text-success">$<?= number_format($libro['precio'], 2) ?></span>
                    <?php else: ?>
                        <span class="text-muted">No disponible</span>
                    <?php endif; ?>
                </p>
                <!-- Ventas -->
                <?php if ($libro['total_ventas']): ?>
                <p class="mb-2 small">
                    <i class="bi bi-graph-up text-warning me-1"></i>
                    <strong>Ventas:</strong>
                    <?= number_format($libro['total_ventas']) ?> unidades
                </p>
                <?php endif; ?>
                <!-- Fecha publicación -->
                <p class="mb-2 small">
                    <i class="bi bi-calendar3 text-secondary me-1"></i>
                    <strong>Publicación:</strong>
                    <?= date('d/m/Y', strtotime($libro['fecha_pub'])) ?>
                </p>
                <!-- Notas -->
                <?php if (!empty($libro['notas'])): ?>
                <p class="card-text text-muted small mt-2 border-top pt-2">
                    <?= htmlspecialchars(mb_strimwidth($libro['notas'], 0, 100, '…')) ?>
                </p>
                <?php endif; ?>
            </div>
            <div class="card-footer bg-white border-top-0 text-muted small">
                <i class="bi bi-hash me-1"></i>ISBN: <?= htmlspecialchars($libro['id_titulo']) ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Botón volver arriba -->
<button id="btnTop" class="btn btn-primary rounded-circle position-fixed bottom-0 end-0 m-4 shadow"
        style="display:none; width:46px; height:46px; align-items:center; justify-content:center;"
        title="Volver arriba">
    <i class="bi bi-arrow-up"></i>
</button>

<?php include 'includes/footer.php'; ?>
