@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../ubnt/ucrm-plugin-sdk/bin/pack-plugin
php "%BIN_TARGET%" %*
