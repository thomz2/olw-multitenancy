@echo off

:: Verifique se o diretório do projeto Laravel está configurado corretamente
if not exist "C:\Users\danys\Documents\www\olw\olw-2" (
    echo O diretório do projeto Laravel não foi encontrado.
    exit /b
)

:: Altere o diretório para o diretório do projeto Laravel
cd /d "C:\Users\danys\Documents\www\olw\olw-2"

:: Execute os comandos do Sail
vendor\bin\sail %*
