# Prototipo de Seguridad en la Nube para la I.E Señor de la Divina Misericordia ☁️🔒

**Descripción del Proyecto:**
Desarrollo de un prototipo funcional de una aplicación basada en servicios en la nube, orientada a la protección de datos y servicios de la I.E Señor de la Divina Misericordia mediante la implementación de medidas de seguridad modernas.

**Tecnología Base:** Laravel 12 (PHP)

---

## 🗂️ Módulos Principales
- **Servicios Cloud:** Administración de recursos y plataformas en la nube (AWS, Azure, GCP, etc.)
- **Medidas de Seguridad:** Registro y control de políticas y acciones de seguridad implementadas
- **Incidentes de Seguridad:** Seguimiento y gestión de eventos o amenazas detectadas

---

## ⚙️ Requisitos Técnicos
- PHP 8.2 o superior
- Composer
- SQLite (ideal para pruebas locales)
- Laravel CLI

---

## 🚦 Guía de Instalación Rápida

1. Clona este repositorio:
   ```bash
   git clone https://github.com/kiidam/cloud-computing.git
   cd cloud-computing
   ```
2. Instala las dependencias:
   ```bash
   composer install
   ```
3. Configura el entorno:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Ajusta la base de datos en `.env`:
   ```env
   DB_CONNECTION=sqlite
   ```
   Y crea el archivo:
   ```bash
   touch database/database.sqlite
   ```
5. Ejecuta migraciones y seeders:
   ```bash
   php artisan migrate --seed
   ```
6. Inicia el servidor de desarrollo:
   ```bash
   php artisan serve
   ```

La API estará disponible en:
- http://localhost:8000/api
- http://127.0.0.1:8000/api

---

## 📬 Pruebas y Consumo de la API

- Utiliza [Postman](https://www.postman.com/) o similar para probar los endpoints.
- Incluye siempre estos headers:
  - `Accept: application/json`
  - `Content-Type: application/json`

### Ejemplo de petición GET
- **URL:** http://127.0.0.1:8000/api/cloud-services
- **Método:** GET

### Ejemplo de petición POST (crear servicio cloud)
```json
{
  "name": "Google Drive",
  "provider": "Google",
  "type": "Storage",
  "description": "Almacenamiento institucional",
  "status": "active",
  "configuration": {
    "region": "us-central1",
    "bucket": "institucion-drive"
  }
}
```

---

## 📑 Endpoints Disponibles

### Servicios Cloud
- `GET    /api/cloud-services`           → Listar servicios
- `POST   /api/cloud-services`           → Crear servicio
- `GET    /api/cloud-services/{id}`      → Consultar servicio
- `PUT    /api/cloud-services/{id}`      → Actualizar servicio
- `DELETE /api/cloud-services/{id}`      → Eliminar servicio

### Medidas de Seguridad
- `GET    /api/security-measures`        → Listar medidas
- `POST   /api/security-measures`        → Crear medida
- `GET    /api/security-measures/{id}`   → Consultar medida
- `PUT    /api/security-measures/{id}`   → Actualizar medida
- `DELETE /api/security-measures/{id}`   → Eliminar medida

### Incidentes de Seguridad
- `GET    /api/security-incidents`       → Listar incidentes
- `POST   /api/security-incidents`       → Reportar incidente
- `GET    /api/security-incidents/{id}`  → Consultar incidente
- `PUT    /api/security-incidents/{id}`  → Actualizar incidente
- `DELETE /api/security-incidents/{id}`  → Eliminar incidente

---

## 📝 Notas Importantes
- Todas las respuestas son en formato JSON.
- No se requiere autenticación para pruebas locales.
- El sistema maneja errores y validaciones para solicitudes incorrectas.
- Puedes adaptar la configuración para usar MySQL o PostgreSQL en producción.

---

**Desarrollado por:** Kiidam para la I.E Señor de la Divina Misericordia
