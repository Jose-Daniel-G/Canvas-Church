# 🎓 Sistema de Gestión Académica (LMS) - REDEEMER

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![AdminLTE](https://img.shields.io/badge/AdminLTE-3.x-3c8dbc?style=for-the-badge)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-Proprietary-red?style=for-the-badge)

**Learning Management System similar a Canvas / Moodle**

*Sistema integral de gestión académica desarrollado en Laravel + AdminLTE*

[📖 Características](#-características-principales) • [📸 Capturas](#-capturas-de-pantalla) • [🚀 Instalación](#-instalación) • [📋 Roadmap](#-roadmap-pendientes)

---

</div>

## 📋 Tabla de Contenidos

- [Descripción General](#-descripción-general)
- [Características Principales](#-características-principales)
- [Capturas de Pantalla](#-capturas-de-pantalla)
- [Stack Tecnológico](#-stack-tecnológico)
- [Instalación](#-instalación)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Módulos Implementados](#-módulos-implementados)
- [Roadmap - Pendientes](#-roadmap-pendientes)
- [Contribución](#-contribución)
- [Licencia](#-licencia)
- [Contacto](#-contacto)

---

## 🌟 Descripción General

**REDEEMER LMS** es un sistema completo de gestión académica diseñado para instituciones educativas. Desarrollado con **Laravel 10.x** y **AdminLTE 3.x**, proporciona una plataforma robusta y escalable para la gestión de cursos, estudiantes, profesores y todo el proceso educativo.

### ✨ ¿Por qué REDEEMER LMS?

- 🎯 **Completo**: Gestión integral de estudiantes, cursos, tareas y calificaciones
- 🔒 **Seguro**: Autenticación robusta con roles y permisos
- 📊 **Analítico**: Dashboards y reportes para cada tipo de usuario
- 🎨 **Moderno**: Interfaz AdminLTE responsive y profesional
- 🔌 **Extensible**: Arquitectura Laravel escalable
- 📱 **Responsive**: Funciona en desktop, tablet y móvil

---

## 🚀 Características Principales

### 👥 Gestión de Usuarios

<table>
<tr>
<td width="50%">

#### Estudiantes
- ✅ CRUD completo de estudiantes
- ✅ Perfiles con información académica
- ✅ Historial de cursos y calificaciones
- ✅ Dashboard personalizado
- ✅ Seguimiento de progreso

</td>
<td width="50%">

#### Profesores
- ✅ Gestión de información docente
- ✅ Asignación de cursos
- ✅ Horarios personalizados
- ✅ Panel de calificaciones
- ✅ Gestión de tareas

</td>
</tr>
<tr>
<td width="50%">

#### Administradores
- ✅ SuperAdmin y Admin roles
- ✅ Control total del sistema
- ✅ Gestión de permisos
- ✅ Reportes y estadísticas

</td>
<td width="50%">

#### Secretaría/Programador
- ✅ Gestión de inscripciones
- ✅ Configuración de horarios
- ✅ Generación de reportes
- ✅ Soporte administrativo

</td>
</tr>
</table>
## 📑 Índice de Contenidos

1. [Menú Principal - Admin/SuperAdmin]
2. [Gestión de Usuarios]
   - [Estudiantes]
   - [Programador/Secretaria]
   - [Profesores]
3. [Gestión de Cursos]-cursos
4. [Inscripciones]
5. [Horarios]
6. [Dashboards]
   - [Dashboard Estudiante]
   - [Dashboard Profesor]
   - [Dashboard Admin]
7. [Módulos Específicos]
### 📚 Gestión Académica

- **Cursos**: CRUD completo con información detallada, prerequisitos y contenido modular
- **Inscripciones**: Sistema de matrícula con validación de cupos y conflictos
- **Horarios**: Gestión visual de horarios con detección de conflictos
- **Calificaciones**: Sistema completo de evaluación y libro de notas
- **Tareas**: Módulo de asignación, entrega y calificación de tareas
- **Progreso**: Seguimiento del avance de estudiantes en tiempo real

### 📊 Dashboards Personalizados

- **Dashboard Estudiante**: Cursos activos, tareas pendientes, calificaciones, progreso
- **Dashboard Profesor**: Cursos asignados, tareas por revisar, estadísticas de rendimiento
- **Dashboard Admin**: KPIs institucionales, métricas, alertas del sistema

---

## 📸 Capturas de Pantalla

### 1️⃣ Panel de Administración

<div align="center">

![Menú Admin](images/APP_GESTION_ACADEMICA_REDEEMER_page-0001.jpg)

*Panel de navegación principal con menú lateral AdminLTE. Acceso rápido a todos los módulos: Dashboard, Usuarios, Cursos, Inscripciones, Horarios y Configuración.*

</div>

---

### 2️⃣ Gestión de Usuarios

#### Estudiantes (CRUD)

<div align="center">

![Gestión de Estudiantes](images/APP_GESTION_ACADEMICA_REDEEMER_page-0002.jpg)

*Tabla completa de estudiantes con funciones de crear, editar, eliminar y búsqueda avanzada. Muestra ID, nombre, email, programa y acciones disponibles.*

</div>

#### Programador / Secretaria

<div align="center">

![Panel Secretaria](images/APP_GESTION_ACADEMICA_REDEEMER_page-0003.jpg)

*Interfaz administrativa para personal de soporte con acceso a inscripciones, horarios y reportes.*

</div>

#### Profesores

<div align="center">

![Gestión de Profesores](images/APP_GESTION_ACADEMICA_REDEEMER_page-0004.jpg)

*Módulo de gestión docente con información de cursos asignados, horarios y estadísticas.*

</div>

---

### 3️⃣ Gestión de Cursos

#### Sistema de Roles

<div align="center">

![Roles del Sistema](images/APP_GESTION_ACADEMICA_REDEEMER_page-0005.jpg)

*Configuración de roles y permisos: SuperAdmin, Admin, Profesor, Secretaria, Estudiante.*

</div>

#### Listado y Creación de Cursos

<div align="center">

![CRUD Cursos](images/APP_GESTION_ACADEMICA_REDEEMER_page-0006.jpg)

*Formulario de creación de cursos con campos: nombre, código, descripción, profesor, período, créditos, prerequisitos.*

</div>

#### Editar Curso - Información Adicional

<div align="center">

![Editar Curso](images/APP_GESTION_ACADEMICA_REDEEMER_page-0007.jpg)

*Panel de edición avanzada con secciones para contenido, evaluaciones, recursos y configuración.*

</div>

#### Eliminar Curso

<div align="center">

![Eliminar Curso](images/APP_GESTION_ACADEMICA_REDEEMER_page-0008.jpg)

*Modal de confirmación de eliminación con advertencias de impacto y opción de archivar.*

</div>

#### Ver Curso Detallado

<div align="center">

![Ver Curso](images/APP_GESTION_ACADEMICA_REDEEMER_page-0009.jpg)

*Vista completa del curso con pestañas: información, contenido, estudiantes, calificaciones y actividad.*

</div>

---

### 4️⃣ Inscripciones

<div align="center">

![Inscripciones](images/APP_GESTION_ACADEMICA_REDEEMER_page-0010.jpg)

*Sistema de gestión de matrículas con información de cupos, horarios y validación de prerequisitos.*

</div>

---

### 5️⃣ Gestión de Horarios

#### Vista General del Sistema

<div align="center">

![Horarios Sistema](images/APP_GESTION_ACADEMICA_REDEEMER_page-0011.jpg)

*Calendario visual con todos los cursos programados, detección automática de conflictos.*

</div>

#### Horarios del Profesor

<div align="center">

![Horarios Profesor](images/APP_GESTION_ACADEMICA_REDEEMER_page-0012.jpg)

*Vista personalizada del horario docente con clases, tutorías y carga académica.*

</div>

---

### 6️⃣ Dashboards

#### Dashboard del Estudiante

<div align="center">

![Dashboard Estudiante](images/APP_GESTION_ACADEMICA_REDEEMER_page-0013.jpg)

*Panel principal con cursos activos, tareas pendientes, calendario y progreso académico.*

</div>

#### Dashboard del Profesor

<div align="center">

![Dashboard Profesor](images/APP_GESTION_ACADEMICA_REDEEMER_page-0014.jpg)

*Panel docente con cursos, tareas por revisar, estadísticas y estudiantes en riesgo.*

</div>

#### Dashboard Admin

<div align="center">

![Dashboard Admin](images/APP_GESTION_ACADEMICA_REDEEMER_page-0015.jpg)

*Vista ejecutiva con KPIs, métricas institucionales, gráficos analíticos y alertas.*

</div>

---

### 7️⃣ Módulo de Tareas

<div align="center">

![Módulo Tareas Admin](images/APP_GESTION_ACADEMICA_REDEEMER_page-0016.jpg)

*Panel administrativo de supervisión global de tareas con estadísticas y configuración.*

</div>

---

### 8️⃣ Módulos del Estudiante

#### Presentación del Curso

<div align="center">

![Presentación Curso](images/APP_GESTION_ACADEMICA_REDEEMER_page-0017.jpg)

*Página de bienvenida con introducción, objetivos, estructura y requisitos del curso.*

</div>

#### Vista del Curso

<div align="center">

![Navegación Curso](images/APP_GESTION_ACADEMICA_REDEEMER_page-0018.jpg)

*Interfaz principal con menú de unidades, contenido multimedia, actividades y progreso.*

</div>

#### Calificaciones del Estudiante

<div align="center">

![Calificaciones Estudiante](images/APP_GESTION_ACADEMICA_REDEEMER_page-0019.jpg)

*Libro de calificaciones personal con detalle de evaluaciones, estadísticas y retroalimentación.*

</div>

#### Perfil del Estudiante

<div align="center">

![Perfil Estudiante](images/APP_GESTION_ACADEMICA_REDEEMER_page-0020.jpg)

*Página de perfil editable con información personal, académica, historial y configuración.*

</div>

---

### 9️⃣ Módulos del Profesor

#### Calificaciones del Profesor

<div align="center">

![Calificaciones Profesor](images/APP_GESTION_ACADEMICA_REDEEMER_page-0021.jpg)

*Libro de calificaciones en formato tabla con edición rápida, estadísticas y exportación.*

</div>

---

### 🔟 Seguimiento y Configuración

#### Estado de Curso / Progreso del Estudiante

<div align="center">

![Progreso Estudiante](images/APP_GESTION_ACADEMICA_REDEEMER_page-0022.jpg)

*Panel de seguimiento con barras de progreso, actividades completadas, métricas y logros.*

</div>

---

## 💻 Stack Tecnológico

### Backend
- **Framework**: Laravel 10.x
- **PHP**: 8.2+
- **Base de Datos**: MySQL 8.0
- **ORM**: Eloquent
- **Autenticación**: Laravel Sanctum / Breeze
- **Autorización**: Spatie Laravel Permission

### Frontend
- **Template**: AdminLTE 3.x
- **CSS Framework**: Bootstrap 5
- **JavaScript**: jQuery, Alpine.js
- **Componentes**: DataTables, Select2, Chart.js
- **Íconos**: Font Awesome

### Herramientas de Desarrollo
- **Dependency Manager**: Composer, npm
- **Build Tool**: Vite / Laravel Mix
- **Testing**: PHPUnit, Laravel Dusk
- **Code Quality**: PHP CS Fixer, Laravel Pint

---

## 🚀 Instalación

### Requisitos Previos

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js >= 18.x
- npm / yarn

### Pasos de Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/tu-usuario/redeemer-lms.git
cd redeemer-lms

# 2. Instalar dependencias de PHP
composer install

# 3. Instalar dependencias de Node.js
npm install

# 4. Copiar archivo de configuración
cp .env.example .env

# 5. Generar clave de aplicación
php artisan key:generate

# 6. Configurar base de datos en .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=redeemer_lms
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password

# 7. Ejecutar migraciones y seeders
php artisan migrate --seed

# 8. Crear enlace simbólico para storage
php artisan storage:link

# 9. Compilar assets
npm run dev
# o para producción
npm run build

# 10. Iniciar servidor de desarrollo
php artisan serve
```

### Usuarios por Defecto (Seeders)

```
SuperAdmin:
- Email: superadmin@redeemer.edu
- Password: password

Admin:
- Email: admin@redeemer.edu
- Password: password

Profesor:
- Email: profesor@redeemer.edu
- Password: password

Estudiante:
- Email: estudiante@redeemer.edu
- Password: password
```

---

## 📁 Estructura del Proyecto

```
redeemer-lms/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   ├── Professor/
│   │   │   └── Student/
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Course.php
│   │   ├── Enrollment.php
│   │   ├── Assignment.php
│   │   └── Grade.php
│   └── Services/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   ├── professor/
│   │   ├── student/
│   │   └── layouts/
│   └── js/
├── routes/
│   ├── web.php
│   └── api.php
└── public/
```

---

## ✅ Módulos Implementados

### ✔️ Completados

- [x] **Autenticación y Autorización**
  - Sistema de login/registro
  - Roles: SuperAdmin, Admin, Profesor, Secretaria, Estudiante
  - Middleware de permisos
  
- [x] **Gestión de Usuarios**
  - CRUD de estudiantes
  - CRUD de profesores
  - Gestión de roles y permisos
  - Perfiles personalizados
  
- [x] **Gestión de Cursos**
  - CRUD completo de cursos
  - Prerequisitos
  - Contenido modular
  - Información detallada
  
- [x] **Inscripciones**
  - Sistema de matrícula
  - Validación de cupos
  - Gestión de lista de espera
  
- [x] **Horarios**
  - Calendario visual
  - Detección de conflictos
  - Horarios personalizados por profesor
  
- [x] **Dashboards**
  - Dashboard estudiante
  - Dashboard profesor
  - Dashboard admin
  
- [x] **Tareas**
  - Asignación de tareas
  - Entrega de trabajos
  - Sistema de calificación básico
  
- [x] **Progreso del Estudiante**
  - Seguimiento de avance
  - Visualización de completitud
  - Métricas de participación

---

## 📋 Roadmap - Pendientes

### 🔴 Alta Prioridad

- [ ] **Sistema de Notificaciones**
  - [ ] Notificaciones en la aplicación (real-time)
  - [ ] Notificaciones por email
  - [ ] Notificaciones por SMS
  - [ ] Preferencias de notificaciones por usuario
  - [ ] Plantillas de emails personalizables

- [ ] **Módulo de Calificaciones Avanzado**
  - [ ] Revisión y mejora del sistema actual
  - [ ] Múltiples criterios de evaluación
  - [ ] Rúbricas de calificación
  - [ ] Ponderación flexible
  - [ ] Cálculo automático de promedios
  - [ ] Redondeo configurable
  - [ ] Exportación de actas

- [ ] **Sistema de Reportes**
  - [ ] Reportes académicos por estudiante
  - [ ] Reportes de rendimiento por curso
  - [ ] Reportes institucionales
  - [ ] Estadísticas de asistencia
  - [ ] Exportación en PDF/Excel
  - [ ] Reportes personalizables
  - [ ] Gráficos y visualizaciones

### 🟡 Prioridad Media

- [ ] **Foros y Discusiones**
  - [ ] Foros por curso
  - [ ] Hilos de discusión
  - [ ] Moderación de contenido
  - [ ] Notificaciones de respuestas

- [ ] **Sistema de Mensajería**
  - [ ] Chat entre usuarios
  - [ ] Mensajes privados
  - [ ] Mensajes grupales
  - [ ] Historial de conversaciones

- [ ] **Calendario Académico**
  - [ ] Eventos institucionales
  - [ ] Recordatorios automáticos
  - [ ] Sincronización con Google Calendar
  - [ ] Vista mensual/semanal/diaria

- [ ] **Biblioteca de Recursos**
  - [ ] Repositorio de materiales
  - [ ] Categorización de recursos
  - [ ] Sistema de búsqueda
  - [ ] Control de versiones

### 🟢 Mejoras Futuras

- [ ] **Gamificación**
  - [ ] Sistema de insignias
  - [ ] Puntos y logros
  - [ ] Tabla de clasificación
  - [ ] Recompensas

- [ ] **Analíticas Avanzadas**
  - [ ] Machine Learning para predicción de rendimiento
  - [ ] Análisis de patrones de aprendizaje
  - [ ] Recomendaciones personalizadas
  - [ ] Detección temprana de riesgo académico

- [ ] **Integración con Herramientas Externas**
  - [ ] Google Drive / OneDrive
  - [ ] Zoom / Google Meet
  - [ ] Slack / Microsoft Teams
  - [ ] Sistemas de pago

- [ ] **App Móvil Nativa**
  - [ ] iOS (Swift)
  - [ ] Android (Kotlin)
  - [ ] Notificaciones push
  - [ ] Modo offline

- [ ] **Sistema de Asistencia**
  - [ ] Registro de asistencia
  - [ ] Códigos QR
  - [ ] Reportes de asistencia
  - [ ] Alertas de inasistencia

- [ ] **Certificados y Diplomas**
  - [ ] Generación automática
  - [ ] Plantillas personalizables
  - [ ] Verificación blockchain
  - [ ] Compartir en redes sociales

---

## 🤝 Contribución

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

### Estándares de Código

- Seguir PSR-12 para PHP
- Usar Laravel Pint para formateo
- Escribir tests para nuevas funcionalidades
- Documentar métodos y clases 


---

<div align="center">

**Desarrollado con ❤️ por el equipo de REDEEMER**

⭐ Si te gusta este proyecto, dale una estrella en GitHub

</div>
Historial             🔴 CRUD PENDIENTE