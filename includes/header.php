<?php
$paginaActual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($tituloPagina ?? 'Librería JJ Online') ?> | Librería JJ Online</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/estilos.css" rel="stylesheet">
</head>
<body>

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
            <i class="bi bi-book-half fs-4"></i>
            <span class="fw-bold">Librería JJ Online</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Alternar navegación">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $paginaActual === 'index.php' ? 'active' : '' ?>" href="index.php">
                        <i class="bi bi-house-door me-1"></i>Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $paginaActual === 'libros.php' ? 'active' : '' ?>" href="libros.php">
                        <i class="bi bi-journals me-1"></i>Libros
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $paginaActual === 'autores.php' ? 'active' : '' ?>" href="autores.php">
                        <i class="bi bi-people me-1"></i>Autores
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $paginaActual === 'contacto.php' ? 'active' : '' ?>" href="contacto.php">
                        <i class="bi bi-envelope me-1"></i>Contacto
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero banner (solo en index) -->
<?php if ($paginaActual === 'index.php'): ?>
<header class="hero-banner text-white text-center d-flex align-items-center justify-content-center">
    <div class="hero-overlay"></div>
    <div class="position-relative z-1 px-3">
        <h1 class="display-4 fw-bold mb-3 animate-fade-in">Bienvenido a Librería JJ Online</h1>
        <p class="lead mb-4">Descubre miles de títulos y sus autores en un solo lugar</p>
        <a href="libros.php" class="btn btn-light btn-lg me-2 shadow">
            <i class="bi bi-journals me-1"></i>Ver Libros
        </a>
        <a href="autores.php" class="btn btn-outline-light btn-lg shadow">
            <i class="bi bi-people me-1"></i>Ver Autores
        </a>
    </div>
</header>
<?php else: ?>
<!-- Page header para subpáginas -->
<div class="page-header bg-primary text-white py-4">
    <div class="container">
        <h1 class="mb-0 fw-bold"><?= htmlspecialchars($tituloPagina ?? '') ?></h1>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php" class="text-white-50">Inicio</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= htmlspecialchars($tituloPagina ?? '') ?></li>
            </ol>
        </nav>
    </div>
</div>
<?php endif; ?>

<main class="py-5">
    <div class="container">
