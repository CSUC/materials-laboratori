<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'articles';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'NOM_EMPRESA', 'dt' => 0 ),
    array( 'db' => 'NUM_LOT',  'dt' => 1 ),
    array( 'db' => 'NOM_LOT',   'dt' => 2 ),
    array( 'db' => 'CODI_FAMILIA',     'dt' => 3 ),
    array( 'db' => 'NOM_FAMILIA', 'dt' => 4 ),
    array( 'db' => 'CODI_ARTICLE',  'dt' => 5 ),
    array( 'db' => 'CODI_FABRICANT',   'dt' => 6 ),
    array( 'db' => 'CPV',     'dt' => 7 ),
    array( 'db' => 'FORMAT_VENDA', 'dt' => 8 ),
    array( 'db' => 'DENOMINACIO_ARTICLE',  'dt' => 9 ),
    array( 'db' => 'MARCA',   'dt' => 10 ),
    array( 'db' => 'TIPUS_IVA',     'dt' => 11 ),
    array( 'db' => 'PREU_CATALEG', 'dt' => 12 ),
    array( 'db' => 'DESCOMPTE',  'dt' => 13 ),
    array( 'db' => 'PREU_FINAL',   'dt' => 14 )

/*    array(
        'db'        => 'start_date',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {
            return date( 'jS M y', strtotime($d));
        }
    ),
    array(
        'db'        => 'salary',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
            return '$'.number_format($d);
        }
    )*/
);

// SQL server connection information
$sql_details = array(
    'user' => 'csuc',
    'pass' => 'sergio2020',
    'db'   => 'csucdb',
    'host' => 'localhost'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( 'ssp.class.php' );

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);
