import mysql.connector 
from getpass import getpass 

db_user = "root"
db_name = "csucdb"
db_host = "localhost"

def get_distinct_lots(db_connection): 

    """
    Given a database connection, returns 
    the distinct values of the "NUM_LOT" column
    in "articles" table as a Python list
    """
    cursor = db_connection.cursor() 
    select_query = "SELECT DISTINCT NUM_LOT FROM articles;"
    cursor.execute(select_query)
    return [elem[0] for elem in cursor]

if __name__=="__main__":
    
    print("=== Updating Lot statistics tables ===")
    print("[PARAMS] Database user:", db_user)
    print("[PARAMS] Database name:", db_name)
    db_password = getpass("[INPUT] Type the database password for user " + db_user + ": ")

    db_connection = mysql.connector.connect(
        host=db_host,
        user=db_user,
        passwd=db_password,
        database=db_name
    )

    lot_list = get_distinct_lots(db_connection)
    cursor = db_connection.cursor() 
    general_count = "SELECT COUNT(*) FROM articles"
    single_count = "SELECT COUNT(*) FROM articles WHERE NUM_LOT = %s"
    statistic_exists = "SELECT * FROM statistics_lot WHERE num_lot = %s"
    insert_query = "INSERT INTO statistics_lot VALUES (%s, %s, %s)"
    update_query = "UPDATE statistics_lot SET num_records = %s, percent_of_total = %s WHERE num_lot = %s"

    cursor.execute(general_count)
    total_records = [elem[0] for elem in cursor][0]

    print("[INFO] Processing a total of " + str(len(lot_list)) + " Lots") 
    for lot_name in lot_list: 
        print("[INFO] Now updating lot " + str(lot_name))
        cursor.execute(single_count, (lot_name,))
        num_records = [elem[0] for elem in cursor][0]
        percent = round(100*int(num_records)/total_records, 2)

        cursor.execute(statistic_exists, (lot_name,))
        lot_stats = [elem for elem in cursor]
        if len(lot_stats) != 0:
            print("Updating") 
            cursor.execute(update_query, (num_records, percent, lot_name))
        else: 
            print("Inserting")
            cursor.execute(insert_query, (lot_name, num_records, percent))
        print("Commiting")
        db_connection.commit()
    

    db_connection.close()
