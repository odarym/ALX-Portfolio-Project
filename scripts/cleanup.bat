@echo off
setlocal enabledelayedexpansion

title OdaKira Blog - System Cleanup Utility
echo ============================================================
echo          OdaKira Project System Cleanup Utility             
echo ============================================================
echo.
echo This utility will stop running development servers, clean
echo temporary download caches, and restore your system to normal.
echo.

REM 1. Stop PHP development server processes
echo [*] Stopping active PHP development servers...
taskkill /F /IM php.exe >nul 2>nul
if %ERRORLEVEL% equ 0 (
    echo   [+] Stopped PHP development server processes.
) else (
    echo   [+] No active PHP server processes found.
)

REM 2. Stop standalone mysqld / mariadb processes
echo [*] Stopping background database engines...
taskkill /F /IM mysqld.exe >nul 2>nul
taskkill /F /IM mariadbd.exe >nul 2>nul
echo   [+] Stopped background database processes.

REM 3. Stop Docker container if running
where docker >nul 2>nul
if %ERRORLEVEL% equ 0 (
    echo [*] Checking for Docker container 'odakira-db'...
    docker stop odakira-db >nul 2>nul
    docker rm odakira-db >nul 2>nul
)

REM 4. Clean temporary download caches
echo [*] Cleaning temporary download caches...
del /F /Q "%TEMP%\php-*.zip" 2>nul
del /F /Q "%TEMP%\VC_redist*.exe" 2>nul
if exist "%TEMP%\WinGet" rmdir /S /Q "%TEMP%\WinGet" 2>nul
echo   [+] Cleaned temporary files.

REM 5. Optional: Remove C:\tools\php
if exist "C:\tools\php" (
    echo.
    set /p "DEL_PHP=Would you like to remove portable C:\tools\php? (y/N): "
    if /i "!DEL_PHP!"=="y" (
        rmdir /S /Q "C:\tools\php" 2>nul
        echo   [+] Removed C:\tools\php
    )
)

REM 6. Optional: Clean test uploads
set "SCRIPT_DIR=%~dp0"
set "UPLOADS_DIR=%SCRIPT_DIR%..\src\uploads"
if exist "%UPLOADS_DIR%" (
    echo.
    set /p "DEL_UPLOADS=Would you like to clean uploaded test files in src\uploads? (y/N): "
    if /i "!DEL_UPLOADS!"=="y" (
        del /F /Q "%UPLOADS_DIR%\*" 2>nul
        echo   [+] Cleaned test uploads.
    )
)

echo.
echo ============================================================
echo  [OK] System cleanup complete! System restored to normal.
echo ============================================================
echo.
pause
