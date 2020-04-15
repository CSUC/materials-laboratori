<!DOCTYPE html>
<html>
 <head>
  <title>Catàleg CSUC</title>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->

  <link rel="stylesheet" type="text/css" href="../DataTables/datatables.css">
  <script type="text/javascript" language="javascript" src="../jquery-3.4.1/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" language="javascript" src="../bootstrap-4.3.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" charset="utf8" src="../DataTables/datatables.js"></script>

  <style>
  .card {
    background-color: #dc3545b0;
  }
  </style>


 </head>
 <body>

<h1>Catàleg CSUC</h1>
<br>
   <br>
   <br>


 <table id="articles" class="display table table-striped table-bordered" style="width:100%">
         <thead>
             <tr>
                 <th class="filtres">Nom empresa</th>
                 <th class="filtres">Num Lot</th>
                 <th class="filtres">Nom Lot</th>
                 <th class="filtres">Codi família</th>
                 <th class="filtres">Nom família</th>
                 <th class="filtres">Codi article</th>
                 <th class="filtres">Codi fabricant</th>
                 <th class="filtres">CPV</th>
                 <th class="filtres">Format venda</th>
                 <th class="filtres">Denominació article</th>
                 <th class="filtres">Marca</th>
                 <th class="filtres">Tipus IVA</th>
                 <th class="filtres">Preu catàleg</th>
                 <th class="filtres">Descompte</th>
                 <th class="filtres">Preu final</th>
             </tr>
             <tr>
                 <th>Nom empresa</th>
                 <th>Num Lot</th>
                 <th>Nom Lot</th>
                 <th>Codi família</th>
                 <th>Nom família</th>
                 <th>Codi article</th>
                 <th>Codi fabricant</th>
                 <th>CPV</th>
                 <th>Format venda</th>
                 <th>Denominació article</th>
                 <th>Marca</th>
                 <th>Tipus IVA</th>
                 <th>Preu catàleg</th>
                 <th>Descompte</th>
                 <th>Preu final</th>
             </tr>
         </thead>
<!--         <tfoot>
             <tr>
               <th>Nom empresa</th>
               <th>Num Lot</th>
               <th>Nom Lot</th>
               <th>Codi família</th>
               <th>Nom família</th>
               <th>Codi article</th>
               <th>Codi fabricant</th>
               <th>CPV</th>
               <th>Format venda</th>
               <th>Denominació article</th>
               <th>Marca</th>
               <th>Tipus IVA</th>
               <th>Pre catàleg</th>
               <th>Descompte</th>
               <th>Preu final</th>

             </tr>
         </tfoot> -->
     </table>
</body>




</html>

<script>
$(document).ready(function()  {

    var selInitd = new Array();


    function getOpcions(col){
//      console.log("getOpcions");
      var response = new Array();
            var returnArray = new Array();

      $.ajax({
        url: "filter.php",
        data: "columnaSeleccionada="+col,
        async: false,
        success: function(msg2){
//            console.log(msg2);
            msg = msg2.substring(2,msg2.length-2);
//            console.log(msg);
            response = msg.split('","');
            for(m = 0; m < response.length; m++){
              //need to take care of special characters for passing these values back to the page filter
              //response[m] = response[m].replace(/[^a-zA-Z0-9,. ]/g, "");

              var val = response[m];
//              console.log("val: " + val);
              returnArray.push(val);
            }
        }
      })
      return returnArray;
    };




    var table = $('#articles').DataTable({

       "processing": true,
       "serverSide": true,
       "ajax": "server_processing.php",
       "language": {
           "decimal": ",",
           "thousands": ".",
           "lengthMenu": "Mostrant _MENU_ registres per plana",
           "zeroRecords": "No hi ha registres, disculpeu",
           //"info": "Mostrant plana _PAGE_ de _PAGES_",
           "info": "Mostrant _START_ a _END_ de _TOTAL_ registres",
           "infoEmpty": "No hi ha registres disponibles",
           "infoFiltered": "(filtrats de un total de _MAX_ registres)",
           "search": "Cerca",
           "loadingRecords": "Carregant...",
           "processing":     "Processant...",
           "paginate": {
                 "first":      "Primer",
                 "last":       "Últim",
                 "next":       "Següent",
                 "previous":   "Anterior"
             },

             "aria": {
                  "sortAscending":  ": Activar per ordenar ascedentment",
                  "sortDescending": ": Activar per ordenar descedentment"
              }
         }
    });


    $(".filtres").each( function ( col ) {
            selInitd[col] = false;
            var column = this;
            var select = $('<select><option value=""></option></select>')
                .appendTo( $(this).empty() )
                .on( 'change', function () {
                   var term = $(this).val();
//                   console.log("term: " + term);
                    table.column( col ).search(term, true, false ).draw();
                } )

                .on( 'focus', function () {
                    // només inicialitzem una vegada els dropdown
                    if(!selInitd[col]){
                        var opcions = getOpcions(col).slice();
//                        console.log("slice: " + opcions);

                        for(d = 0; d < opcions.length; d++) {
                            select.append( '<option value="' + opcions[d] + '">' + opcions[d] + '</option>' )
                        }
                    }
                    selInitd[col] = true;

                });


        } );

});
</script>
