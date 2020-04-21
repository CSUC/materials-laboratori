import csv
import os
import gc
import re 

def import_csv_as_list(filepath): 
    
    contents = [] 

    with open(filepath, 'r') as csv_file: 
        csv_reader = csv.reader(csv_file, delimiter='\t')
        for row in csv_reader: 
            contents += [row]

    return contents 

def export_list_as_csv(python_list, filepath): 

    with open(filepath, 'w+') as csv_file: 
        csv_writer = csv.writer(csv_file, delimiter='\t')
        remove_number_re = re.compile(r" \d+$")
        for row in python_list: 
            row[0] = remove_number_re.sub("", row[0])
            csv_writer.writerow(row)

    return 

if __name__=='__main__': 

    csv_dir = 'CSV'
    csv_files = os.listdir(csv_dir)
    num_files = len(csv_files)

    joined_list = [] 
    current_file = 1
    current_slice = 1 
    first = True
    first_row = True

    for csv_file in csv_files:
        print("(" + str(current_file) + "/" + str(num_files) + ") " + csv_file) 
        csv_list = import_csv_as_list(csv_dir + "/" + csv_file)
        
        assert(len(csv_list[0]) == 15)
        if first_row: 
            csv_list[0][0] = "Nom empresa"
            first_row = False 

        if first: 
            joined_list = csv_list
            first = False 
        else: 
            joined_list += csv_list[1:]

        current_file += 1 
        if current_file % 10 == 0: 
            export_list_as_csv(joined_list, 'Aggregated_' + str(current_slice) + '.csv')
            del joined_list, csv_list
            gc.collect()
            #first = True
            #first_row = True 
            joined_list = []
            current_slice += 1 

