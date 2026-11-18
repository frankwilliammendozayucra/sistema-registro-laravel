@echo off
title Servidor de Registro Laravel + MySQL
echo ============================================================
echo   Iniciando Proyecto: Registro Usuarios + Metricas + CORS
echo ============================================================

set "ROOT=%~dp0"
set "PHP=%ROOT%tools\php\php.exe"
set "MARIADB=%ROOT%tools\mariadb\bin\mariadbd.exe"
set "MY_INI=%ROOT%tools\mariadb\my.ini"

:: Iniciar MariaDB en segundo plano
tasklist /fi "imagename eq mariadbd.exe" | findstr /i "mariadbd.exe" >nul
if errorlevel 1 (
    echo [*] Iniciando motor de base de datos MySQL (MariaDB)...
    start "MariaDB Server" /b "%MARIADB%" --defaults-file="%MY_INI%"
    timeout /t 2 /nobreak >nul
) else (
    echo [*] MySQL (MariaDB) ya se encuentra activo.
)

:: Iniciar Laravel en el puerto 8000
echo [*] Iniciando servidor Laravel en http://127.0.0.1:8000 ...
start "" http://127.0.0.1:8000/registro
"%PHP%" "%ROOT%registro_app\artisan" serve --host=0.0.0.0 --port=8000
