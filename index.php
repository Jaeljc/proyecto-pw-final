<?php
require_once 'includes/conexion.php';
$tituloPagina = 'Inicio';

$pdo = getConexion();

// Estadísticas rápidas
$totalLibros  = $pdo->query("SELECT COUNT(*) FROM titulos")->fetchColumn();
$totalAutores = $pdo->query("SELECT COUNT(*) FROM autores")->fetchColumn();
$totalPubs    = $pdo->query("SELECT COUNT(DISTINCT id_pub) FROM titulos")->fetchColumn();

// Últimos 6 libros agregados (por fecha_pub más reciente)
$stmtRecientes = $pdo->query(
    "SELECT t.id_titulo, t.titulo, t.tipo, t.precio,
            GROUP_CONCAT(CONCAT(a.nombre,' ',a.apellido) SEPARATOR ', ') AS autores
     FROM titulos t
     LEFT JOIN titulo_autor ta ON t.id_titulo = ta.id_titulo
     LEFT JOIN autores a        ON ta.id_autor  = a.id_autor
     GROUP BY t.id_titulo, t.titulo, t.tipo, t.precio
     ORDER BY t.fecha_pub DESC
     LIMIT 6"
);
$librosRecientes = $stmtRecientes->fetchAll();

include 'includes/header.php';
?>

<!-- Estadísticas -->
<div class="row g-4 mb-5">
    <div class="col-sm-4">
        <div class="stat-card d-flex align-items-center justify-content-between">
            <div>
                <div class="stat-number"><?= $totalLibros ?></div>
                <div class="text-muted mt-1">Libros disponibles</div>
            </div>
            <i class="bi bi-journals stat-icon text-primary"></i>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card d-flex align-items-center justify-content-between">
            <div>
                <div class="stat-number"><?= $totalAutores ?></div>
                <div class="text-muted mt-1">Autores registrados</div>
            </div>
            <i class="bi bi-people stat-icon text-primary"></i>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card d-flex align-items-center justify-content-between">
            <div>
                <div class="stat-number"><?= $totalPubs ?></div>
                <div class="text-muted mt-1">Editoriales</div>
            </div>
            <i class="bi bi-building stat-icon text-primary"></i>
        </div>
    </div>
</div>

<!-- Libros recientes -->
<h2 class="fw-bold mb-4 border-start border-4 border-warning ps-3">Títulos Recientes</h2>
<div class="row g-4 mb-5">
    <?php foreach ($librosRecientes as $libro): ?>
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm libro-card">
            <div class="card-body d-flex gap-3">
                <div class="book-icon">
                    <i class="bi bi-book"></i>
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <span class="badge bg-secondary tipo-badge mb-1">
                        <?= htmlspecialchars(str_replace('_', ' ', $libro['tipo'])) ?>
                    </span>
                    <h6 class="card-title mb-1 text-truncate" title="<?= htmlspecialchars($libro['titulo']) ?>">
                        <?= htmlspecialchars($libro['titulo']) ?>
                    </h6>
                    <p class="text-muted small mb-2">
                        <i class="bi bi-person me-1"></i>
                        <?= htmlspecialchars($libro['autores'] ?? 'Sin autor') ?>
                    </p>
                    <?php if ($libro['precio']): ?>
                        <span class="precio">$<?= number_format($libro['precio'], 2) ?></span>
                    <?php else: ?>
                        <span class="text-muted small">Precio no disponible</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="text-center">
    <a href="libros.php" class="btn btn-primary btn-lg me-3">
        <i class="bi bi-journals me-1"></i>Ver todos los libros
    </a>
    <a href="autores.php" class="btn btn-outline-primary btn-lg">
        <i class="bi bi-people me-1"></i>Ver todos los autores
    </a>
</div>

<!-- Botón volver arriba -->
<button id="btnTop" class="btn btn-primary rounded-circle position-fixed bottom-0 end-0 m-4 shadow"
        style="display:none; width:46px; height:46px; align-items:center; justify-content:center;"
        title="Volver arriba">
    <i class="bi bi-arrow-up"></i>
</button>

<?php include 'includes/footer.php'; ?>
