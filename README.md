# Librería JJ Online — Proyecto Final
**Curso:** Programación Web
**Autor:** Jael Castro (2024-1468)

---

## Estructura del proyecto

```
libreria/
├── index.php                    ← Página de inicio (estadísticas + libros recientes)
├── libros.php                   ← Listado de todos los libros
├── autores.php                  ← Listado de todos los autores
├── contacto.php                 ← Formulario de contacto (GET/POST + PDO)
├── css/
│   └── estilos.css              ← Estilos personalizados
├── js/
│   └── main.js                  ← JavaScript (filtros, validación, scroll)
└── includes/
    ├── conexion.php             ← Conexión PDO (configurar aquí usuario/contraseña)
    ├── header.php               ← Header/navbar compartido
    ├── footer.php               ← Footer compartido
    └── crear_tabla_contacto.sql ← SQL para crear la tabla contacto manualmente
```
---

## Instalación local

### 1 · Importar la base de datos
1. Abre **phpMyAdmin** (http://localhost/phpmyadmin).
2. Crea una base de datos llamada `dblibreria`.
3. Importa el archivo `Base_Datos_Libreria.sql`.
4. Opcionalmente ejecuta `includes/crear_tabla_contacto.sql`  
   *(la tabla contacto también se crea automáticamente al enviar el primer formulario)*.

### 2 · Configurar la conexión
Edita `includes/conexion.php` y ajusta:
```php
define('DB_USER', 'root');   // tu usuario MySQL
define('DB_PASS', '');       // tu contraseña MySQL
```

### 3 · Copiar al servidor local
Coloca la carpeta `libreria/` dentro de `htdocs/` (XAMPP) o `www/` (WAMP/Laragon).

Accede en: **http://localhost/libreria/**

---

## Despliegue en hosting gratuito (InfinityFree / Byet / 000webhost)

1. Registrarte en [infinityfree.net](https://infinityfree.net) u otro hosting gratuito PHP+MySQL.
2. Crear una base de datos MySQL desde el panel de control.
3. Importar `Base_Datos_Libreria.sql` vía **phpMyAdmin** del hosting.
4. Actualizar `includes/conexion.php` con los datos del hosting (host, usuario, contraseña, nombre BD).
5. Subir todos los archivos por FTP (FileZilla) a la carpeta `htdocs/`.

---

## Tecnologías utilizadas
- **HTML5 / CSS3** — estructura y estilos base
- **Bootstrap 5.3** — componentes responsivos y grid
- **Bootstrap Icons** — iconografía
- **JavaScript (ES6)** — filtros en tiempo real, validación, scroll
- **PHP 8** — lógica del servidor, plantillas, procesamiento de formulario
- **MySQL + PDO** — consultas y almacenamiento de datos
- **GET / POST** — métodos HTTP para formularios
- **foreach / count() / sizeof()** — recorrido de resultados

---

## Funcionalidades implementadas
| # | Requerimiento | Estado |
|---|---------------|--------|
| 1 | Importar base de datos `dblibreria` | ✅ |
| 2 | Crear aplicación web | ✅ |
| 3 | Plantilla Bootstrap | ✅ Bootstrap 5 |
| 4 | Portal en español | ✅ |
| 5 | Página listado de libros | ✅ `libros.php` |
| 6 | Página listado de autores | ✅ `autores.php` |
| 7 | Formulario de contacto | ✅ `contacto.php` |
| 8 | Tabla `contacto` con campos requeridos | ✅ |
| 9 | Guardar formulario en tabla `contacto` | ✅ |
| 10 | Conexiones y consultas con **PDO** | ✅ |
| 11 | CSS y JavaScript aplicados | ✅ |
