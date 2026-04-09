
document.addEventListener('DOMContentLoaded', function () {

    // ── Filtro en tiempo real de libros ──────────────────────────
    const campoBusqueda = document.getElementById('buscarLibro');
    if (campoBusqueda) {
        campoBusqueda.addEventListener('input', function () {
            const termino = this.value.toLowerCase().trim();
            const tarjetas = document.querySelectorAll('.libro-item');
            let visibles = 0;

            tarjetas.forEach(function (tarjeta) {
                const texto = tarjeta.dataset.busqueda || '';
                if (texto.includes(termino)) {
                    tarjeta.style.display = '';
                    visibles++;
                } else {
                    tarjeta.style.display = 'none';
                }
            });

            // Mensaje "sin resultados"
            const sinResultados = document.getElementById('sinResultados');
            if (sinResultados) {
                sinResultados.style.display = visibles === 0 ? 'block' : 'none';
            }

            // Contador
            const contadorResultados = document.getElementById('contadorResultados');
            if (contadorResultados) {
                contadorResultados.textContent = visibles + ' libro(s) encontrado(s)';
            }
        });
    }

    // ── Filtro en tiempo real de autores ─────────────────────────
    const campoBusquedaAutor = document.getElementById('buscarAutor');
    if (campoBusquedaAutor) {
        campoBusquedaAutor.addEventListener('input', function () {
            const termino = this.value.toLowerCase().trim();
            const filas = document.querySelectorAll('.autor-fila');
            let visibles = 0;

            filas.forEach(function (fila) {
                const texto = fila.dataset.busqueda || '';
                if (texto.includes(termino)) {
                    fila.style.display = '';
                    visibles++;
                } else {
                    fila.style.display = 'none';
                }
            });

            const sinResultados = document.getElementById('sinResultadosAutor');
            if (sinResultados) {
                sinResultados.style.display = visibles === 0 ? 'block' : 'none';
            }

            const contador = document.getElementById('contadorAutores');
            if (contador) {
                contador.textContent = visibles + ' autor(es) encontrado(s)';
            }
        });
    }

    // ── Validación del formulario de contacto ────────────────────
    const formularioContacto = document.getElementById('formContacto');
    if (formularioContacto) {
        formularioContacto.addEventListener('submit', function (e) {
            if (!formularioContacto.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            formularioContacto.classList.add('was-validated');
        });
    }

    // ── Activar tooltips Bootstrap ───────────────────────────────
    const tooltipTriggers = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggers.forEach(function (el) {
        new bootstrap.Tooltip(el);
    });

    // ── Botón "volver arriba" ─────────────────────────────────────
    const btnTop = document.getElementById('btnTop');
    if (btnTop) {
        window.addEventListener('scroll', function () {
            btnTop.style.display = window.scrollY > 300 ? 'flex' : 'none';
        });
        btnTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ── Animación fade-in a las cards al hacer scroll ────────────
    const observador = new IntersectionObserver(function (entradas) {
        entradas.forEach(function (entrada) {
            if (entrada.isIntersecting) {
                entrada.target.classList.add('animate-fade-in');
                observador.unobserve(entrada.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.card').forEach(function (card) {
        observador.observe(card);
    });

});
