import csv 
import os 
import sys
import mysql.connector  
from getpass import getpass 

db_user = "root"
db_name = "csucdb"
db_host = "localhost"

def printProgressBar (iteration, total, prefix = '', suffix = '', decimals = 1, length = 100, fill = '█', printEnd = "\r"):
    """
    Call in a loop to create terminal progress bar
    """
    percent = ("{0:." + str(decimals) + "f}").format(100 * (iteration / float(total)))
    filledLength = int(length * iteration // total)
    bar = fill * filledLength + '-' * (length - filledLength)
    print('\r%s |%s| %s%% %s' % (prefix, bar, percent, suffix), end = printEnd)
    # Print New Line on Complete
    if iteration == total: 
        print()

if __name__=='__main__':
    
    if len(sys.argv) != 1: 
        print("Usage: python3 load_big_data_DB")
        print("==> CSV files must be inside '/var/lib/mysql-files/'")
        print("==> Check the script for the DBs variables")
        exit()
    
    mysql_load_path = '/var/lib/mysql-files/'

    print("=== Starting load directory to DB protocol ===")
    print("[PARAMS] All files in folder:", mysql_load_path, "will be loaded in the DBs")
    print("[PARAMS] Database user:", db_user)
    print("[PARAMS] Database name:", db_name)
    db_password = getpass("[INPUT] Type the database password for user " + db_user + ": ")

    db_connection = mysql.connector.connect(
        host=db_host, 
        user=db_user, 
        passwd=db_password, 
        database=db_name
    )
    cursor = db_connection.cursor() 

    load_query = "LOAD DATA INFILE %s INTO TABLE articles FIELDS TERMINATED BY '\\t' LINES TERMINATED BY '\\n' IGNORE 1 ROWS (NOM_EMPRESA, NUM_LOT, NOM_LOT, CODI_FAMILIA,NOM_FAMILIA, CODI_ARTICLE,CODI_FABRICANT, CPV,FORMAT_VENDA, DENOMINACIO_ARTICLE,MARCA,TIPUS_IVA,PREU_CATALEG, DESCOMPTE,PREU_FINAL);"

    error_list = []
    csv_files = os.listdir(mysql_load_path)
    num_files = len(csv_files)
    progress = 1 
    for fl in csv_files: 
        print("(" + str(progress) + "/" + str(num_files) +") Processing: " + mysql_load_path + fl )
        try:
            new_path = mysql_load_path + fl 
            cursor.execute(load_query, [new_path])
            db_connection.commit()

        except mysql.connector.Error as err:
            print(err)
            error_list.append(err)
        progress += 1

    print("Error list:")
    for error in error_list: 
        print(error) 

    db_connection.close()
