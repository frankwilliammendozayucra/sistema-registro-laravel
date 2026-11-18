@echo off
echo [*] Deteniendo procesos PHP y MariaDB...
taskkill /f /im php.exe 2>nul
taskkill /f /im mariadbd.exe 2>nul
echo [*] Servidores detenidos correctamente.
pause
