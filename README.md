Instrucciones para configurar y ejecutar la aplicación
Prerrequisitos
Servidor web (Apache, Nginx, etc.)
PHP 7.4 o superior
MySQL o MariaDB
Navegador web
------------------
Instalación
Clonar el repositorio
bash
git clone    https://github.com/tu_usuario/tu_repositorio.git
Configurar la base de datos
Importar el archivo personas.sql en tu servidor de base de datos para crear las tablas necesarias.
Configurar la conexión a la base de datos
Editar el archivo includes/db.php con tus credenciales de base de datos.
php

<?php
$servername = "tu_servidor";
$username = "tu_usuario";
$password = "tu_contraseña";
$dbname = "tu_base_de_datos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
Iniciar el servidor
Si usas PHP built-in server:
bash

php -S localhost:8000
Abrir la aplicación en tu navegador
Ir a http://localhost:8000 o la URL donde hayas configurado tu servidor web.
Estructura del proyecto
arduino

tu_repositorio/
├── api/
│   ├── create.php
│   ├── read.php
│   ├── update.php
│   ├── delete.php
├── includes/
│   └── db.php
├── css/
│   └── style.css
├── js/
│   └── script.js
├── index.html
└── README.md
