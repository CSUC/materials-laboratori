import csv 
import xlrd 
import os 
import gc 
import re
import lot_csuc_names as names 

def process_empty_cells(row_list):
    """
    Given a python list representing a CSV row, returns
    (False, input_list) if the column 8 (Denominació 
    article) is empty, otherwise (True, processed_row).
    Processed_row is row_list but swapping empty cells
    for "-"
    """
    processed_row = []

    if row_list[8] == "": 
        return (False, row_list)
    
    for cell in row_list:
        if str(cell) == "" or str(cell) == 'N/a':
            processed_row.append("-")
        else: 
            processed_row.append(cell)
    
    return (True, processed_row)

def insert_right_names(row_list): 
    """
    Given a python list representing a CSV row, assigns 
    values for columns 1 and 3 (Nom lot and Nom familia
    CSUC) acording to the values on columns 0 and 2 (Lot
    and Codi familia CSUC)
    """
    # Define the dictionaries with the right names for 
    # each value (defined in another file due to their length) 
    lot_names = names.get_lot_names() 
    csuc_names = names.get_csuc_names() 

    lot_num = row_list[0]
    csuc_num = row_list[2]
    amended_row_list = row_list

    if lot_num in lot_names: 
        amended_row_list[1] = lot_names[lot_num]
    else: 
        if type(lot_num) == 'str': 
            print("[WARNING] Found row whose 'Número de Lot' is not registered")

    if csuc_num in csuc_names: 
        amended_row_list[3] = csuc_names[csuc_num]
    else: 
        if type(csuc_num) == 'str':
            print("[WARNING] Found row whose 'Codi familia CSUC' is not registered")
    
    return amended_row_list

def process_cells(row_list): 
    """
    Given a python list representing a CSV row, applies 
    the filters described below
    """
    clean_row_list = []

    for index, cell in enumerate(row_list): 
        if type(cell) == str: 
            # Remove endlines inside cells 
            processed_cell = re.sub('\n', '', cell)
            # Remove tabulations (substitute them for spaces)
            processed_cell = re.sub('\t', ' ', processed_cell)
            # Remove starting spaces and trailing spaces 
            processed_cell = re.sub(' +$', '' , re.sub('^ +', '', processed_cell))
            # Remove double (or more) spaces 
            processed_cell = re.sub('  +', ' ', processed_cell)
            # Remove backslash(s) at the end of the cells
            processed_cell = re.sub(r'\\+$', '', processed_cell)
            # Capitalise first letter of cell and lowercase the rest 
            if len(processed_cell) > 2: 
                processed_cell = processed_cell[0].upper() + processed_cell[1:].lower()

        else:
            processed_cell = cell  

            # Transform column 0 (Num lot) and column 2 (Codi familia CSUC) 
            # to integer (instead of float)
            if index == 0 or index == 2: 
                processed_cell = int(processed_cell) 
            # Transform columns 10 and 12 (Tipus IVA and Descompte) to 
            # percentage notation 
            if index == 10 or index == 12:
                processed_cell = str(round(processed_cell*100, 2)) + "%" 
            # Limit the decimal digits on columns 11 and 13 (Preu cataleg and
            # Preu final) to two and add "€" symbol        
            if index == 11 or index == 13: 
                processed_cell = str(round(processed_cell, 2)) + "€"
                
        clean_row_list.append(processed_cell)

    return clean_row_list 

def excel_to_csvfile(input_file, output_file, doc_name, correct_num_cols=14): 
    """
    Transforms "input_file" Excel to CSV "output_file" attaching 
    "doc_name" as the first element of each row. 
    """
    wb = xlrd.open_workbook(input_file)
    sheet_names = wb.sheet_names()
    assert(len(sheet_names) == 1)
    sh = wb.sheet_by_name(sheet_names[0])
    csv_file = open(output_file, 'w+')
    wr = csv.writer(csv_file, delimiter="\t")
    remove_number_re = re.compile(r" \d+$")

    for rownum in range(sh.nrows):
        row_val_unfiltered = sh.row_values(rownum) 
        row_val = process_cells(row_val_unfiltered)
        amended_row = insert_right_names(row_val)
        (article_bool, final_row) = process_empty_cells(amended_row)
        if article_bool: 
            wr.writerow([remove_number_re.sub("", doc_name)] + final_row)
        assert(correct_num_cols == len(sh.row_values(rownum)))
    
    csv_file.close()
    
    # Free memory when a document has been processed 
    del sh, wb, csv_file, wr
    gc.collect()

if __name__=="__main__": 

    dir_name = 'Excel'
    output_dir = 'CSV'
    excel_files = os.listdir(dir_name)
    num_files = len(excel_files)

    current_file = 1 
    for xls_file in excel_files: 
        print("(" + str(current_file) + "/" + str(num_files) + ") " + xls_file)
        input_path = dir_name + '/' + xls_file
        output_path = output_dir + '/' + xls_file[0:-5] + '.csv'
        excel_to_csvfile(input_path, output_path, xls_file[0:-5])
        current_file += 1

    