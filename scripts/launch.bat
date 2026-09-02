@echo off
setlocal

title OdaKira Blog - All-in-One Launcher
echo ============================================================
echo           Launching OdaKira Blog Server (Standalone)        
echo ============================================================
echo.

REM 1. Locate PHP executable in PATH or standard directories
set "PHP_CMD="
where php >nul 2>nul
if %ERRORLEVEL% equ 0 (
    for /f "tokens=*" %%i in ('where php') do if not defined PHP_CMD set "PHP_CMD=%%i"
)

if not defined PHP_CMD if exist "C:\tools\php\php.exe" set "PHP_CMD=C:\tools\php\php.exe"
if not defined PHP_CMD if exist "C:\Program Files\PHP\php.exe" set "PHP_CMD=C:\Program Files\PHP\php.exe"
if not defined PHP_CMD if exist "C:\Program Files\PHP\v8.3\php.exe" set "PHP_CMD=C:\Program Files\PHP\v8.3\php.exe"
if not defined PHP_CMD if exist "C:\php\php.exe" set "PHP_CMD=C:\php\php.exe"

if defined PHP_CMD goto :php_found

echo [*] Standalone PHP was not found. Downloading official PHP 8.3 runtime...
if not exist "C:\tools\php" mkdir "C:\tools\php"
powershell -NoProfile -ExecutionPolicy Bypass -Command "$ErrorActionPreference='Stop'; try { $releases = Invoke-RestMethod -Uri 'https://windows.php.net/downloads/releases/releases.json' -UseBasicParsing; $zip = $releases.'8.3'.'ts-vs16-x64'.zip.path; if (-not $zip) { $zip = 'php-8.3.33-Win32-vs16-x64.zip' }; $url = 'https://windows.php.net/downloads/releases/' + $zip; $dest = $env:TEMP + '\' + $zip; Write-Host '  [*] Downloading ' $url; Invoke-WebRequest -Uri $url -OutFile $dest -UseBasicParsing; Write-Host '  [*] Extracting to C:\tools\php...'; Expand-Archive -Path $dest -DestinationPath 'C:\tools\php' -Force; Remove-Item $dest -Force -ErrorAction SilentlyContinue; Write-Host '[+] PHP installed successfully.' } catch { Write-Host '[-] Download error: ' $_; exit 1 }"
if exist "C:\tools\php\php.exe" set "PHP_CMD=C:\tools\php\php.exe"

if not defined PHP_CMD (
    echo [!] Failed to download PHP. Please install PHP 8.x manually and re-run.
    pause
    exit /b 1
)

:php_found
echo [+] Using PHP runtime: %PHP_CMD%

REM 2. Prepare php.ini
for %%F in ("%PHP_CMD%") do set "PHP_DIR=%%~dpF"
set "PHP_DIR=%PHP_DIR:~0,-1%"
set "INI_FILE=%PHP_DIR%\php.ini"

if exist "%PHP_DIR%\php.ini-development" if not exist "%INI_FILE%" copy "%PHP_DIR%\php.ini-development" "%INI_FILE%" >nul

REM 3. Ensure uploads folder exists in new src structure
set "SCRIPT_DIR=%~dp0"
set "PROJECT_ROOT=%SCRIPT_DIR%.."
if not exist "%PROJECT_ROOT%\src\uploads" mkdir "%PROJECT_ROOT%\src\uploads"

REM 4. Auto-detect, start database engine, and provision schema
if exist "%SCRIPT_DIR%init_db.php" "%PHP_CMD%" -c "%INI_FILE%" "%SCRIPT_DIR%init_db.php"

REM 5. Launch development server and browser
set "SERVER_URL=http://localhost:8000/home"
echo.
echo ============================================================
echo  [OK] OdaKira Blog is running at: %SERVER_URL%
echo      Document Root : src
echo      Router Script : scripts\router.php
echo ============================================================
echo.
echo Press Ctrl+C in this window to stop the server.
echo.

start "" "%SERVER_URL%"
"%PHP_CMD%" -c "%INI_FILE%" -S localhost:8000 -t "%PROJECT_ROOT%\src" "%SCRIPT_DIR%router.php"
