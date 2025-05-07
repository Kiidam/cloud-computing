# Cloud Computing Security API 🛡️

**Proyecto:** Desarrollo de un Prototipo Funcional de una Aplicación Basada en Servicios en la Nube que Implemente Medidas de Seguridad para Proteger los Datos y Servicios Empresariales

**Curso:** Computación en la Nube

API REST implementada con Laravel 12 para gestionar servicios en la nube, medidas de seguridad e incidentes. ☁️

## 📊 Entidades Principales

-   **CloudService**: Gestión de servicios cloud (AWS, Azure, GCP, etc.)
-   **SecurityMeasure**: Control de medidas de seguridad implementadas
-   **SecurityIncident**: Registro y seguimiento de incidentes de seguridad

## 📋 Requisitos

-   PHP >= 8.2
-   Composer
-   SQLite (recomendado para pruebas)
-   Laravel CLI

## 🚀 Instalación

1. Clona el repositorio:

```bash
git clone https://github.com/urdaydev/cloud-computing.git
cd cloud-computing
```

2. Instala las dependencias:

```bash
composer install
```

3. Configura el archivo .env:

```bash
cp .env.example .env
php artisan key:generate
```

4. Configura la base de datos en el archivo .env
   Para usar SQLite (recomendado para pruebas):

    ```
    DB_CONNECTION=sqlite
    ```

    Y crea el archivo de base de datos:

    ```bash
    touch database/database.sqlite
    ```

5. Ejecuta las migraciones y los seeders:

```bash
php artisan migrate --seed
```

6. Inicia el servidor:

```bash
php artisan serve
```

La API estará disponible en:

-   http://localhost:8000/api
-   http://127.0.0.1:8000/api

## 🔌 API Endpoints

Las pruebas se realizarán usando [Postman](https://www.postman.com/).

> ⚠️ **Headers Requeridos**:
>
> ```
> Accept: application/json
> Content-Type: application/json
> ```
>
> Estos headers son necesarios para el correcto funcionamiento de la API.

Ejemplo de configuración en Postman:

-   URL: http://127.0.0.1:8000/api/cloud-services
-   Método: GET
-   Headers:
    ```diff
    + Accept: application/json
    + Content-Type: application/json
    ```

### 🖥️ Cloud Services

#### Obtener todos los servicios

```http
GET /api/cloud-services
```

#### Crear un servicio

```http
POST /api/cloud-services
```

Body:

```json
{
    "name": "AWS S3",
    "provider": "AWS",
    "type": "Storage",
    "description": "Cloud storage service",
    "status": "active",
    "configuration": {
        "region": "us-east-1",
        "bucket": "my-app-storage"
    }
}
```

#### Obtener un servicio específico

```http
GET /api/cloud-services/{id}
```

#### Actualizar un servicio

```http
PUT /api/cloud-services/{id}
```

Body: (campos opcionales)

```json
{
    "name": "AWS S3 Updated",
    "status": "inactive"
}
```

#### Eliminar un servicio

```http
DELETE /api/cloud-services/{id}
```

### 🔒 Security Measures

#### Obtener todas las medidas

```http
GET /api/security-measures
```

#### Crear una medida

```http
POST /api/security-measures
```

Body:

```json
{
    "name": "Data Encryption",
    "type": "Encryption",
    "description": "AES-256 encryption for stored data",
    "status": "implemented",
    "settings": {
        "algorithm": "AES-256",
        "key_rotation": "90 days"
    },
    "implementation_date": "2025-05-07",
    "review_date": "2025-08-07"
}
```

#### Obtener una medida específica

```http
GET /api/security-measures/{id}
```

#### Actualizar una medida

```http
PUT /api/security-measures/{id}
```

Body: (campos opcionales)

```json
{
    "status": "under-review",
    "review_date": "2025-09-07"
}
```

#### Eliminar una medida

```http
DELETE /api/security-measures/{id}
```

### 🚨 Security Incidents

#### Obtener todos los incidentes

```http
GET /api/security-incidents
```

#### Crear un incidente

```http
POST /api/security-incidents
```

Body:

```json
{
    "title": "Unauthorized Access Attempt",
    "description": "Multiple failed login attempts detected",
    "severity": "medium",
    "status": "investigating",
    "cloud_service_id": 1,
    "detected_at": "2025-05-07T10:00:00",
    "affected_resources": {
        "service": "Authentication System",
        "ip_addresses": ["192.168.1.100"]
    },
    "resolution_steps": ["IP blocked", "Security rules updated"]
}
```

#### Obtener un incidente específico

```http
GET /api/security-incidents/{id}
```

#### Actualizar un incidente

```http
PUT /api/security-incidents/{id}
```

Body: (campos opcionales)

```json
{
    "status": "resolved",
    "resolved_at": "2025-05-07T15:30:00",
    "resolution_steps": [
        "IP blocked",
        "Security rules updated",
        "Additional monitoring implemented"
    ]
}
```

#### Eliminar un incidente

```http
DELETE /api/security-incidents/{id}
```

## 📝 Notas Adicionales

-   Todos los endpoints retornan respuestas en formato JSON
-   Los códigos de estado HTTP indican el resultado de la operación
-   La autenticación no está implementada en esta versión
-   Se incluye manejo de errores para solicitudes inválidas
