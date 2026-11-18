# 🚀 Sistema de Registro con Laravel, MySQL, Métricas en Vivo y Pruebas de Estrés con Apache JMeter

Sistema web completo de registro de usuarios desarrollado con **Laravel 11/12**, base de datos **MySQL**, control estricto de validaciones, monitor de métricas en tiempo real, soporte y auditoría de **CORS** y suite de pruebas de carga y estrés con **Apache JMeter**.

---

## 📸 Capturas de Pantalla

* **Formulario y Dashboard Principal (`/registro`):**
  * Validación en cliente y servidor de DNI (exactamente 8 dígitos numéricos).
  * Control estricto de imagen: **Límite máximo de 1 MB (1,048,576 bytes)** con alerta en rojo si supera el tamaño permitido y bloqueo de envío.
  * Visualización de la fotografía del usuario en la tabla y modal emergente de alta resolución.
* **Directorio Completo de Usuarios (`/usuarios`):**
  * Buscador en tiempo real por DNI o Nombres.
  * Paginación limpia y visualización de todas las fotografías registradas.
* **Monitor de Métricas en Vivo y Simulador de Estrés (`/metricas`):**
  * Gráficas interactivas con **Chart.js** comparando latencia vs concurrencia.
  * Medidor de uso de memoria RAM PHP en megabytes y porcentaje.
  * Ejecutor en tiempo real de pruebas de estrés con barra de progreso y botón de **Reinicio**.
  * Inspector de JSON en tiempo real (`/api/metricas`).

---

## 🛠️ Tecnologías y Arquitectura

* **Backend:** PHP 8.3 & Laravel 11/12
* **Base de Datos:** MySQL / MariaDB 11.4 LTS (Compatible con SQLite y PostgreSQL para Render)
* **Frontend:** Blade, HTML5, CSS3, Bootstrap 5.3, Bootstrap Icons, Chart.js
* **Pruebas de Carga:** Apache JMeter 5.6.3 (OpenJDK 17)
* **Despliegue Cloud:** Docker & Render

---

## 📊 Resultados de las Pruebas de Estrés (Apache JMeter)

Se evaluaron 4 escenarios con más de **1,080 solicitudes combinadas** (GET Formulario, GET CORS con cabeceras `Origin` y POST Multipart subiendo imagen física):

| Escenario | Usuarios Concurrentes (Hilos) | Rampa (*Ramp-Up*) | Solicitudes | Exitosas | Tasa de Error | Latencia Media (ms) | Throughput (RPS) |
| :--- | :---: | :---: | :---: | :---: | :---: | :---: | :---: |
| **1. Normal** | 10 | 2 s | 30 | 30 | **0.00 %** | 787 ms | 6.5 req/s |
| **2. Carga Media** | 50 | 5 s | 150 | 150 | **0.00 %** | 4,813 ms | 6.5 req/s |
| **3. Carga Alta** | 100 | 10 s | 300 | 300 | **0.00 %** | 10,389 ms | 6.2 req/s |
| **4. Estrés** | 200 | 15 s | 600 | 600 | **0.00 %** | 23,724 ms | 5.7 req/s |

---

## 💻 Ejecución en Local (Windows)

1. Clona el repositorio:
   ```bash
   git clone https://github.com/frankwilliammendozayucra/sistema-registro-laravel.git
   cd sistema-registro-laravel
   ```
2. Inicia todos los servicios en un solo clic ejecutando:
   ```cmd
   start_all.bat
   ```
3. Abre tu navegador en:
   * **Registro:** `http://127.0.0.1:8000/registro`
   * **Directorio de Usuarios:** `http://127.0.0.1:8000/usuarios`
   * **Métricas y Estrés en Vivo:** `http://127.0.0.1:8000/metricas`

---

## ☁️ Despliegue en Render

Este proyecto incluye `Dockerfile` y `render.yaml` listos para desplegar en Render con **0 configuración manual**:

1. En [Render Dashboard](https://dashboard.render.com/), haz clic en **New +** > **Web Service**.
2. Conecta tu repositorio de GitHub `sistema-registro-laravel`.
3. Selecciona el runtime **Docker**.
4. Haz clic en **Create Web Service**. ¡Render compilará y publicará la aplicación automáticamente con SSL gratuito!

---

Desarrollado por **Frank William Mendoza Yucra** &bull; 2026.
