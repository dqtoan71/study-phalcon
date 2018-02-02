@ECHO OFF

SET FILENAME=phing.phar

IF NOT EXIST %FILENAME% (
  echo "[downloading...] %FILENAME%
  php -r "copy('http://www.phing.info/get/phing-latest.phar', '%FILENAME%');"
)
php %FILENAME% %*
