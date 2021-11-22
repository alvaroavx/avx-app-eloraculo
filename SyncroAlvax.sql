/*

AJUSTES
HECHOS POR:  NJONG
POR APLICAR: ALVAX

*/

/* 2019.03.12 actualizar */
[spIns_Recurso_Categoria]
[spRec_Categoria_Categoria]
[spRec_Neodoc_Categoria]
[spDel_Recurso_Categoria]


EXEC sp_changedbowner 'SAITAMA\alvax'
EXEC sp_changedbowner 'ELRIC\elric'

EXEC sp_changedbowner 'RIOK\njong'

EXEC sp_changedbowner 'EXODIA\njong'

EXEC sp_change_users_login 'Report'

--FIX USERS
EXEC sp_change_users_login 'Auto_Fix', 'elOraculo'
EXEC sp_change_users_login 'Auto_Fix', 'Spotted'
EXEC sp_change_users_login 'Auto_Fix', 'Steins'

--NEW USERS
--CASO NUEVO USUARIO
--EXEC sp_change_users_login 'Auto_Fix', 'USUARIO', NULL, 'CLAVE'
--EXEC sp_change_users_login 'Auto_Fix', 'usr_local', NULL, 'local01.'


--CASO USUARIO EXISTENTE
--EXEC sp_change_users_login 'Auto_Fix', 'USUARIO', 'USUARIO', 'CLAVE'

EXEC sp_changedbowner 'SAITAMA\alvax'
EXEC sp_changedbowner 'ELRIC\elric'
EXEC sp_change_users_login 'Report'
EXEC sp_change_users_login 'Auto_Fix', 'elOraculo'
EXEC sp_change_users_login 'Auto_Fix', 'usr_local', NULL, 'local01.'

-- para arreglar error de dbo dont exist
use elOraculo EXEC sp_changedbowner 'sa'