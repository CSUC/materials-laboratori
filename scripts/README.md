# Funcionament i utilitat dels scripts
Per facilitar diverses tasques relacionades amb aquest projecte s'han creat els següents scripts: 
* *insert_csv_DB.py:* permet insertar arxius CSV petits a la taula "articles" sempre i quan tinguin el format correcte. 
* *load_big_data_DB.py:* permet insertar arxius CSV grans a la taula "articles" sempre i quan tinguin el format correcte. 
* *excel_to_csv.py:* permet transformar arxius EXCEL (xlsm) [ben formatejats] a CSV i preprocessa els camps per evitar problemes al inserir-los a la base de dades.
* *lot_csuc_names.py:* diccionari de noms necessari per executar l'script anterior.  
* *join_csv.py:* permet agrupar fitxers CSV de 10 en 10. Es pot utilitzar per crear un agregats de diferents fitxers CSV.  

També s'ha creat un script que s'ha d'utilitzar per actualitzar les dades de la taula "statistics\_lot" cada cop que es modifica la taula "articles": *update_statistics.py*.

## Execucució dels scripts 
Per executar els scripts és necessari tenir Python a la versió 3.6 o superior i instal·lar els paquets següents: xlrd, mysql.connector, getpass. 
