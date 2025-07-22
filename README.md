# CRM Sistema para Cámara de Comercio

Sistema integral de gestión de relaciones con comercios afiliados, desarrollado en PHP con Laravel y MySQL.

## Características Principales

### Gestión de Usuarios y Accesos
- ✅ Registro y login seguro con validación de email
- ✅ Sistema de roles: Administrador General, Colaboradores, Comercios Afiliados
- ✅ Recuperación de contraseña vía correo electrónico
- ✅ Control de acceso basado en roles

### Módulo de Afiliaciones
- ✅ Alta manual y por formulario online de nuevos comercios
- ✅ Validación de documentación requerida (RFC, INE, comprobante domicilio, etc.)
- ✅ Estatus de afiliación: Pendiente, Aprobado, Rechazado, Cancelado
- ✅ Vencimiento de afiliaciones con notificaciones automáticas

### Panel de Comercio Afiliado
- ✅ Acceso a perfil editable
- ✅ Subida de documentos
- ✅ Consulta de estatus y vigencia de afiliación
- ✅ Reporte de pagos realizados
- ✅ Acceso a beneficios activos

### Panel de Colaboradores
- ✅ Visualización de comercios afiliados por colaborador
- ✅ Sistema de comisiones por afiliación aprobada
- ✅ Informes mensuales con ranking interno
- ✅ Notificaciones internas del sistema

### Dashboard de Administrador
- ✅ Gráficas de desempeño por colaborador
- ✅ Estadísticas por región, giro comercial, fecha, estatus
- ✅ Filtros dinámicos para análisis detallado
- ✅ Exportación de reportes en PDF/Excel
- ✅ Control de cuentas y permisos

### Módulo de Pagos
- ✅ Registro manual de pagos
- ✅ Generación de facturas
- ✅ Visualización de pagos por usuario
- ✅ Sistema de recordatorios de renovación

### Módulo de Comunicaciones
- ✅ Envío de correos automáticos por cambio de estatus
- ✅ Segmentación por giro, ubicación o fecha de afiliación
- ✅ Panel de mensajes internos

### Funcionalidades Adicionales
- ✅ Módulo de Eventos: Inscripciones a ferias o capacitaciones
- ✅ Directorio público de afiliados con buscador por categoría
- 🔄 Integración con WhatsApp Business API (en desarrollo)

## Tecnologías Utilizadas

- **Backend**: PHP 8+
- **Framework**: Laravel 10
- **Base de Datos**: MySQL 8+
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Gráficas**: Chart.js
- **Librerías adicionales**:
  - Laravel Sanctum (API Authentication)
  - Intervention Image (Procesamiento de imágenes)
  - Laravel Excel (Exportación de reportes)
  - DomPDF (Generación de PDFs)

## Instalación

1. Clonar el repositorio
```bash
git clone https://github.com/danjohn007/Prueba.git
cd Prueba
```

2. Instalar dependencias
```bash
composer install
npm install
```

3. Configurar variables de entorno
```bash
cp .env.example .env
php artisan key:generate
```

4. Configurar base de datos en el archivo `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crm_camara_comercio
DB_USERNAME=root
DB_PASSWORD=
```

5. Ejecutar migraciones y seeders
```bash
php artisan migrate
php artisan db:seed
```

6. Configurar almacenamiento
```bash
php artisan storage:link
```

7. Compilar assets
```bash
npm run dev
```

8. Iniciar servidor
```bash
php artisan serve
```

## Estructura del Proyecto

```
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # Controladores del administrador
│   │   ├── Auth/            # Autenticación
│   │   ├── Business/        # Panel de comercios
│   │   └── Collaborator/    # Panel de colaboradores
│   ├── Models/              # Modelos Eloquent
│   └── Http/Middleware/     # Middleware personalizado
├── database/
│   ├── migrations/          # Migraciones de base de datos
│   └── seeders/             # Seeders
├── resources/
│   └── views/               # Vistas Blade
│       ├── admin/           # Vistas del administrador
│       ├── auth/            # Vistas de autenticación
│       ├── business/        # Vistas del panel de comercios
│       └── collaborator/    # Vistas del panel de colaboradores
└── routes/
    └── web.php              # Rutas de la aplicación
```

## Uso del Sistema

### Registro de Usuarios
1. Los usuarios pueden registrarse como Comercio o Colaborador
2. Verificación de email requerida
3. Los administradores son creados mediante seeders

### Gestión de Comercios
1. Los comercios completan su perfil tras el registro
2. Suben documentación requerida
3. Los administradores aprueban o rechazan las solicitudes

### Sistema de Comisiones
1. Los colaboradores reciben comisiones por afiliaciones aprobadas
2. Seguimiento mensual de rendimiento
3. Ranking interno de colaboradores

### Reportes y Estadísticas
1. Dashboard con métricas en tiempo real
2. Exportación de reportes personalizados
3. Gráficas interactivas de rendimiento

## Contribución

1. Fork el proyecto
2. Crear una rama para la nueva funcionalidad (`git checkout -b feature/nueva-funcionalidad`)
3. Commit los cambios (`git commit -am 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Crear un Pull Request

## Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## Soporte

Para soporte técnico o consultas, contactar a:
- Email: soporte@camaracomercio.com
- Teléfono: +52 (55) 1234-5678

## Estado del Proyecto

🟢 **Activo** - En desarrollo continuo con nuevas funcionalidades y mejoras.