<?php


$column = $_GET['columnaSeleccionada'];
//$column = 0;


error_log("column:" . $column);

$table = array(
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
);
//conection:
$config = parse_ini_file('../config.ini');

$link = mysqli_connect($config['host'], $config['username'], $config['password'], $config['database']) or die("Error " . mysqli_error($link));
$link->set_charset("utf8");
//error_log("MySQL connection: " . mysqli_get_host_info($link)); 
/* change character set to utf8 */
/*  if (!$link->set_charset("utf8")) {
      error_log( printf("Error loading character set utf8: %s\n", $link->error) );
  } else {
      error_log( printf("Current character set: %s\n", $link->character_set_name()) );
  } */
//$link->set_charset("utf8");
//consultation:

$query = "SELECT DISTINCT ".$table[$column]['db']." FROM articles ORDER BY ".$table[$column]['db']." ASC" or die("Error in the consult.." . mysqli_error($link));
//error_log("query: " . $query);

//execute the query.

$result = $link->query($query);
//error_log($result->num_rows); 
//display information:

$rows = array();
$rIdx = 0;

while($row = mysqli_fetch_array($result)) {
/*  error_log("row:" . $row[0]);
  error_log("row encode:" . utf8_encode($row[0]));
  error_log("row decode:" . utf8_decode($row[0]));*/

/*  echo "row:" . $row[0] . "<br>";
  $a = number_format($row[0], 2, ',', '.');
  echo "a: " . $a . "<br>";*/
/*  $nou = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
}, $row[0]);*/
//  error_log("nou: " . $nou);
  // format només per columnes numèriques
/*  if (($column >= 11) and ($column <=14)){
    $rows[$rIdx] = number_format($row[0], 2, ',', '.');
  }else{*/
    $rows[$rIdx] = $row[0];
//  }
//  $rows[$rIdx] = number_format($row[0], 2, ',', '.');
  $rIdx++;
}

//error_log(print_r($rows,true));


if($rows){
//  print_r( $rows );
//  error_log("rows:" . $rows);
//  error_log("rows:" . json_encode($rows,JSON_UNESCAPED_UNICODE));
//  error_log("rows:2" . json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
//  echo json_encode($rows, JSON_UNESCAPED_SLASHES);
  //error_log("json_encode: " . json_encode($rows) );
//  $prova = "paràmetres";

//  echo $prova;
//  echo json_encode( $prova );

//  echo json_encode( $prova, JSON_UNESCAPED_UNICODE );


  echo json_encode( $rows,  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
}
mysqli_close($con);
?>
