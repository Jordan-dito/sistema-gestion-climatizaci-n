# 🌬️ Sistema de Gestión - Hermanos Fríos

Sistema integral de gestión empresarial para **Hermanos Fríos**, empresa especializada en climatización, instalación, mantenimiento y venta de aires acondicionados.

![PHP](https://img.shields.io/badge/PHP-7.4+-blue)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange)
![Bootstrap](https://img.shields.io/badge/Bootstrap-4.6-purple)
![License](https://img.shields.io/badge/license-Private-red)

## 📋 Descripción

Sistema completo que integra:
- **Gestión administrativa** de clientes, productos, proveedores y distribuidores
- **Control de inventario** con método FIFO (kardex)
- **Órdenes de trabajo** para instalación, mantenimiento y reparación
- **Sistema de ventas y compras** 
- **Generación de reportes** avanzados
- **Sitio web corporativo** con sistema de cotizaciones en línea
- **Sistema de roles y permisos** multinivel

## 🚀 Características Principales

### 🔐 Seguridad
- ✅ Autenticación de usuarios con roles y permisos
- ✅ Control de acceso por módulos
- ✅ Sesiones seguras
- ✅ Protección contra SQL injection (PDO)
- ✅ Recuperación de contraseñas por email

### 📊 Módulos Administrativos
- **Usuarios y Roles**: Gestión completa de permisos
- **Clientes**: Base de datos de clientes con historial
- **Productos/Almacén**: Control de inventario con kardex FIFO
- **Proveedores y Distribuidores**: Gestión de la cadena de suministro
- **Categorías**: Organización de productos

### 💼 Operaciones Comerciales
- **Compras**: Registro y seguimiento de compras a proveedores
- **Ventas**: Sistema de ventas con carrito de compras
- **Cotizaciones**: Formulario web integrado
- **Órdenes de Trabajo**: Instalación, mantenimiento y reparación

### 📈 Reportes
- Reportes de clientes, usuarios, compras y ventas
- Historial detallado de clientes
- Reportes de instalaciones y mantenimientos
- Kardex de productos
- Exportación a PDF y Excel

### 🌐 Sitio Web Corporativo
- Diseño responsivo moderno
- Formulario de cotización en línea
- Galería de productos (AIRMAX, STARSONIC, TCL)
- Secciones de servicios
- Integración con WhatsApp
- Testimonios de clientes

## 🛠️ Tecnologías Utilizadas

### Backend
- **PHP 7.4+** - Lenguaje de programación principal
- **MySQL** - Base de datos relacional
- **PDO** - Capa de abstracción de base de datos
- **PHPMailer** - Envío de correos electrónicos
- **TCPDF** - Generación de documentos PDF

### Frontend
- **HTML5 / CSS3** - Estructura y estilos
- **Bootstrap 4.6** - Framework CSS responsivo
- **AdminLTE 3.2.0** - Panel de administración
- **JavaScript / jQuery** - Interactividad
- **DataTables** - Tablas interactivas
- **SweetAlert2** - Notificaciones elegantes
- **FontAwesome** - Iconografía

## 📦 Requisitos del Sistema

- **PHP** >= 7.4
- **MySQL** >= 5.7
- **Apache/Nginx** con mod_rewrite
- **Composer** (para PHPMailer)
- **Extensiones PHP**:
  - PDO y PDO_MySQL
  - mbstring
  - openssl
  - gd o imagick (para imágenes)

## ⚙️ Instalación

### 1. Clonar el Repositorio
```bash
git clone https://github.com/Jordan-dito/sistema-gestion-climatizaci-n.git
cd sistema-gestion-climatizaci-n
```

### 2. Configurar Base de Datos
```bash
# Crear base de datos MySQL
mysql -u root -p
CREATE DATABASE c2840648_sistema CHARACTER SET utf8 COLLATE utf8_general_ci;
EXIT;

# Importar estructura (si tienes un archivo SQL)
# mysql -u root -p c2840648_sistema < database.sql
```

### 3. Configurar Conexión

**⚠️ IMPORTANTE**: Crea un archivo `app/config.php` con tus credenciales:

```php
<?php
define('SERVIDOR','localhost');
define('USUARIO','tu_usuario');
define('PASSWORD','tu_password');
define('BD','c2840648_sistema');

$servidor = "mysql:dbname=".BD.";host=".SERVIDOR;

try{
    $pdo = new PDO($servidor,USUARIO,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
}catch (PDOException $e){
    echo "Error al conectar a la base de datos";
}

$URL = "http://localhost/sistema-gestion-climatizaci-n";

// Configuración SMTP
define('SMTP_HOST', 'tu_smtp_host');
define('SMTP_PORT', 587);
define('SMTP_USER', 'tu_email@ejemplo.com');
define('SMTP_PASS', 'tu_password');
define('SMTP_FROM_NAME', 'Sistema Hermanos Fríos');

date_default_timezone_set("America/Guayaquil");
$fechaHora = date('Y-m-d H:i:s');
?>
```

### 4. Instalar Dependencias
```bash
cd login
composer install
```

### 5. Configurar Permisos
```bash
# Linux/Mac
chmod -R 755 almacen/img_productos
chmod -R 755 public/images

# Windows - Asegúrate de dar permisos de escritura a estas carpetas
```

### 6. Acceder al Sistema
```
http://localhost/sistema-gestion-climatizaci-n/login
```

## 👥 Usuarios por Defecto

Después de importar la base de datos, puedes acceder con:

```
Usuario: admin@hermanosfrios.com
Contraseña: [Consultar con el administrador]
```

## 📁 Estructura del Proyecto

```
sistema-gestion-climatizacion/
├── app/
│   ├── config.php              # Configuración principal
│   ├── controllers/            # Controladores por módulo
│   │   ├── almacen/
│   │   ├── categorias/
│   │   ├── clientes/
│   │   ├── compras/
│   │   ├── ventas/
│   │   ├── usuarios/
│   │   └── ...
│   ├── enviar_cotizacion.php   # Procesador de cotizaciones web
│   └── TCPDF-main/             # Librería PDF
├── layout/
│   ├── parte1.php              # Header del sistema
│   ├── parte2.php              # Footer del sistema
│   └── sesion.php              # Control de sesiones
├── public/
│   └── templeates/
│       └── AdminLTE-3.2.0/     # Template admin
├── assets/                     # CSS, JS, imágenes del sitio web
├── login/                      # Sistema de autenticación
├── almacen/                    # Módulo de productos
├── ventas/                     # Módulo de ventas
├── compras/                    # Módulo de compras
├── clientes/                   # Módulo de clientes
├── reportes/                   # Módulo de reportes
├── ordenes_trabajo/            # Órdenes de instalación/mantenimiento
├── index.php                   # Dashboard principal
├── index.html                  # Sitio web corporativo
└── README.md                   # Este archivo
```

## 🔒 Seguridad

### Información Sensible
El archivo `app/config.php` NO está incluido en el repositorio por seguridad. Debes crearlo manualmente con tus credenciales.

### Recomendaciones
- ✅ Cambiar todas las contraseñas predeterminadas
- ✅ Usar HTTPS en producción
- ✅ Mantener PHP y MySQL actualizados
- ✅ Realizar backups periódicos de la base de datos
- ✅ Revisar logs de acceso regularmente

## 📸 Capturas de Pantalla

### Dashboard Principal
Sistema de métricas con contadores de usuarios, roles, categorías, productos, proveedores, compras, ventas y clientes.

### Sitio Web Corporativo
Incluye secciones de servicios, productos, testimonios y formulario de cotización integrado.

## 🤝 Contribuciones

Este es un proyecto privado. Para contribuir, contacta al administrador del sistema.

## 📝 Licencia

© 2024-2025 Hermanos Fríos S.A. Todos los derechos reservados.

## 👨‍💻 Desarrollado por

**DITODEVS**

## 📞 Soporte

Para soporte técnico:
- **Email**: info@hermanosfrios.com
- **Teléfono**: +593 960 205 152
- **Ubicación**: Av. 25 de Julio, Guayaquil, Ecuador

## 🔄 Changelog

### v1.0.0 (2024)
- ✅ Sistema base implementado
- ✅ Todos los módulos operativos
- ✅ Sitio web corporativo integrado
- ✅ Sistema de roles y permisos
- ✅ Generación de reportes

---

**⭐ Si este proyecto te resulta útil, no olvides darle una estrella en GitHub!**

