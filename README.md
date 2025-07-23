# Plataforma E-Learning

Una plataforma web para la evaluación periódica de conocimientos de ingeniería desarrollada con Spring Boot y MySQL.

## Características

### Para Administradores
- **Dashboard Administrativo**: Visualización de estadísticas y gestión general
- **Gestión de Evaluaciones**: Crear, editar, activar/desactivar evaluaciones
- **Vista de Estudiantes**: Monitoreo de estudiantes registrados
- **Control de Acceso**: Sistema de autenticación y autorización

### Para Estudiantes
- **Registro y Autenticación**: Sistema de registro seguro para estudiantes
- **Dashboard del Estudiante**: Vista general de evaluaciones disponibles y progreso
- **Perfil Personal**: Visualización de resultados y historial de evaluaciones
- **Sistema de Evaluaciones**: Interface para realizar evaluaciones (en desarrollo)

## Tecnologías Utilizadas

- **Backend**: Spring Boot 3.2.0
- **Base de Datos**: MySQL
- **Seguridad**: Spring Security 6
- **Frontend**: Thymeleaf + Bootstrap 5
- **Gestión de Dependencias**: Maven
- **ORM**: Spring Data JPA (Hibernate)

## Arquitectura

El proyecto sigue el patrón MVC (Modelo-Vista-Controlador):

```
src/main/java/com/elearning/platform/
├── config/          # Configuraciones (Security, etc.)
├── controller/      # Controladores MVC
├── model/          # Entidades JPA
├── repository/     # Repositorios de datos
├── service/        # Lógica de negocio
└── init/           # Inicialización de datos
```

## Instalación y Configuración

### Prerrequisitos
- Java 17 o superior
- MySQL 8.0 o superior
- Maven 3.6 o superior

### Configuración de Base de Datos

1. Crear una base de datos MySQL:
```sql
CREATE DATABASE elearning_platform;
```

2. Configurar la conexión en `src/main/resources/application.properties`:
```properties
spring.datasource.url=jdbc:mysql://localhost:3306/elearning_platform?createDatabaseIfNotExist=true&useSSL=false&serverTimezone=UTC
spring.datasource.username=tu_usuario
spring.datasource.password=tu_contraseña
```

### Ejecución

1. Compilar el proyecto:
```bash
mvn clean compile
```

2. Ejecutar la aplicación:
```bash
mvn spring-boot:run
```

3. Acceder a la aplicación en: `http://localhost:8080`

## Usuarios de Prueba

El sistema crea automáticamente usuarios de prueba:

### Administrador
- **Email**: admin@elearning.com
- **Contraseña**: admin123

### Estudiante
- **Email**: estudiante@test.com
- **Contraseña**: student123

## Estructura de Base de Datos

### Entidades Principales

- **User**: Usuarios del sistema (admin/estudiante)
- **Evaluation**: Evaluaciones creadas por administradores
- **Question**: Preguntas de las evaluaciones
- **Answer**: Respuestas posibles para las preguntas
- **EvaluationResult**: Resultados de evaluaciones completadas
- **StudentAnswer**: Respuestas dadas por estudiantes

### Relaciones

- Un usuario puede ser Admin o Estudiante
- Los Admins pueden crear múltiples Evaluaciones
- Las Evaluaciones contienen múltiples Preguntas
- Las Preguntas tienen múltiples Respuestas
- Los Estudiantes pueden tener múltiples Resultados

## Funcionalidades Implementadas

✅ **Autenticación y Autorización**
- Sistema de login/logout
- Registro de estudiantes
- Control de acceso por roles

✅ **Panel Administrativo**
- Dashboard con estadísticas
- CRUD de evaluaciones
- Gestión de estado de evaluaciones

✅ **Panel del Estudiante**
- Dashboard personal
- Vista de evaluaciones disponibles
- Perfil con historial de resultados

✅ **Interface de Usuario**
- Diseño responsive con Bootstrap
- Interface en español
- Navegación intuitiva

## Funcionalidades en Desarrollo

🚧 **Sistema de Evaluaciones**
- Gestión de preguntas y respuestas
- Motor de evaluación en tiempo real
- Cálculo automático de puntuaciones

🚧 **Reportes y Analytics**
- Gráficos de progreso
- Reportes de rendimiento
- Estadísticas avanzadas

## Contribución

Para contribuir al proyecto:

1. Fork del repositorio
2. Crear una rama feature: `git checkout -b feature/nueva-funcionalidad`
3. Commit de cambios: `git commit -m 'Agregar nueva funcionalidad'`
4. Push a la rama: `git push origin feature/nueva-funcionalidad`
5. Crear un Pull Request

## Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## Contacto

Para preguntas o sugerencias, contactar al equipo de desarrollo.