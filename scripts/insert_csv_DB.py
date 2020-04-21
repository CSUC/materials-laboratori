import csv 
import os 
import sys
import mysql.connector  
from getpass import getpass 

db_user = "csuc"
db_name = "csucdb"
db_host = "localhost"

def get_num_lines(csv_filepath): 
    with open(csv_filepath, 'r') as fl: 
        return sum(1 for line in fl)

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
    
    if len(sys.argv) != 2: 
        print("Usage: python3 insert_csv_DB.py csv_file")
        print("==> Check the script for the DBs variables")
        exit()
    
    csv_path = str(sys.argv[1])
    print("=== Starting inserting csv to DB protocol ===")
    print("[PARAMS] CSV file path:", csv_path)
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

    insert_query = """
        INSERT INTO articles (
            NOM_EMPRESA, NUM_LOT, 
            NOM_LOT, CODI_FAMILIA,
            NOM_FAMILIA, CODI_ARTICLE,
            CODI_FABRICANT, CPV,
            FORMAT_VENDA, DENOMINACIO_ARTICLE,
            MARCA, TIPUS_IVA,
            PREU_CATALEG, DESCOMPTE,
            PREU_FINAL
        ) VALUES (
            %s,%s,%s,%s,%s,
            %s,%s,%s,%s,%s,
            %s,%s,%s,%s,%s
        );"""

    num_lines = get_num_lines(csv_path)
    progress = 0 

    with open(csv_path, 'r') as csv_file: 
        reader = csv.reader(csv_file, delimiter='\t')
        
        for row in reader: 
            assert(len(row) == 15) 
            if row[0] != "Nom empresa":
                cursor.execute(insert_query, row)
                db_connection.commit()
            #if progress == 0 or progress == 1: 
            #    print(row) 
            
            printProgressBar(progress, num_lines, prefix = 'Progress:', suffix='Complete', length=50)
            progress += 1

    db_connection.close()
