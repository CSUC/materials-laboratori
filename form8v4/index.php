<!DOCTYPE html>
<html>
 <head>
  <title>Catàleg CSUC</title>
  <script src="https://kit.fontawesome.com/5936c56d00.js" crossorigin="anonymous"></script>  
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
  td.dt-body-right {
    text-align: right; 
  }

  #stats-table td {
    text-align: right; 
  }
  
  #stats-table th {
    text-align: center; 
  }
  .dropdown:hover>.dropdown-menu {
    display: block;
  }
  .navbar-custom {
     background-color:#004356;
  }
  .navbar-custom > a,  
  .navbar-custom > li > a {
     color: white; 
  }
  .navbar-custom > a:hover,
  .navbar-custom > li > a {
     color: lightgrey; 
  }
  .dropdown {
     list-style: none; 
  }

  //Navbar styles
  .navbar .nav-item:not(:last-child) {
    margin-right: 35px;
  }
 
  .dropdown-toggle::after {
    transition: transform 0.15s linear; 
  }
 
  .show.dropdown .dropdown-toggle::after {
    transform: translateY(3px);
  }

  .dropdown-menu {
    margin-top: 0;
  }
  </style>

 </head>
 <body class="bg-light">
	<nav class="navbar navbar-custom"> 
		<a class="navbar-brand" href="#">
    			<img src="csuc_logo_blanc.png" width="50" height="30" class="d-inline-block align-top" alt="Logo del CSUC">&nbsp;
    			Catàleg CSUC
  		</a>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        			Enllaços rellevants
      			</a>
			<div class="dropdown-menu">
        			<a class="dropdown-item" href="https://unidisc.csuc.cat/index.php/s/juTRJwz3kCv9wBI">Catàlegs per proveïdor</a>
      				<a class="dropdown-item" href="https://www.csuc.cat/es/compras-conjuntas/material-de-laboratorio">Anunci acord marc</a>
			</div>
		</li>
	</nav>
	<div class="container">
		<div class="py-5 text-center">
			<h1>Aplicació Materials de Laboratori CSUC</h1>
		</div>
	</div>
	
<div style="padding-left:20px">	 
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
</div>
<br>
<div class="container">
                <div class="py-5 text-center">
                        <h1>Número de registres per lot</h1>
                </div>
</div>
<table id="stats-table" class="table table-striped table-bordered" style="margin: 0 auto; width: 30%"> 
	<tr>
		<th>Núm. lot</th>
		<th>Número de registres</th>
		<th>Percentatge del total</th>
	</tr>
	<?php
		$config = parse_ini_file('../config.ini');
		$conn = mysqli_connect($config['host'], $config['username'], $config['password'], $config['database']) or die("Error ". mysqli_error($conn)); 
		$query = "SELECT * FROM statistics_lot;"; 
		$result = $conn->query($query); 
		
		while($row = mysqli_fetch_array($result)) {
	?>
			<tr>
				<td><?php echo $row[0]; ?></td>
				<td><?php echo number_format(intval($row[1]), 0, ",", "."); ?></td>
				<td><?php echo $row[2]; ?>%</td>				
			</tr>
	<?php 
		}
		mysqli_close($conn);            		
	?>
</table>
<br>
</body>




</html>

<script>
$(document).ready(function()  {

    var selInitd = new Array();


    function getOpcions(col){
      console.log("getOpcions");
      var response = new Array();
            var returnArray = new Array();

      $.ajax({
        url: "filter.php",
        data: "columnaSeleccionada="+col,
        async: false,
        success: function(msg2){
            console.log(msg2);
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


    var website_dict = {
        "ABCR GMBH": ["http://www.abcr.de","order@abcr.de"],
        "AGILENT TECHNOLOGIES SPAIN, S.L.": ["http://www.agilent.com","pedidosmaterial@agilent.com"],
        "ALBERTO SOLER, S.A.": ["http://www.albertsoler.com","ferreteria@albertsoler.com"],
        "ALCO, SUBMINISTRES PER A LABORATORI, S.A.": ["http://www.alco.es","pedidos@alco.es"],
        "ANAME, S.L.": ["http://www.aname.eu","pedidos@aname.es"],
        "ANTONIO MATACHANA, S.A.": ["http://www.matachana.com","lifescience@matachana.com"],
        "APARATOS NORMALIZADOS, S.A.": ["http://www.anorsa.com","xlamarca@anorsa.com"],
        "ASECOS SEGURIDAD Y PROTECCIÓN DEL MEDIOAMBIENTE, S.L.": ["http://www.asecos.com","m.piedrafita@asecos.es"],
        "AZBIL TELSTA TECHNOLOGIES, S.L.U.": ["http://www.telstar.com","sales.orders@telstar.com"],
        "B.BRAUN VETCARE, S.A.": ["https://shop.bbraun-vetcare.es","veterinaria.area@bbraun.com"],
        "BECKMAN COULTER, S.L.U.": ["http://www.beckman.es","lseuropeorders@beckman.com"],
        "BECTON DICKINSON, S.A.": ["https://www.bdbiosciences.com","orders.es@bd.com"],
        "BELLÉS DIAGNÒSTIC I INVESTIGACIÓ, S.L.": ["http://www.comercialbelles.com","jbelles@comercialbelles.com"],
        "BIOGEN CIENTIFICA, S.L.": ["http://www.biogen.es","pedidos@biogen.es"],
        "BIOMETA TECNOLOGIA Y SISTEMAS, S.A.": ["https://www.biometa.es","pedidos@biometa.es"],
        "BIONOVA CIENTIFICA, S.L.": ["http://www.bionova.es","pedidos@bionova.es"],
        "BIO-RAD LABORATORIES, S.A.": ["https://www.bio-rad.com","sales_admin_spain@bio-rad.com"],
        "BIOSIS BIOLOGIC SYSTEMS, S.L.": ["http://www.tecniplast.it","biosis@telefonica.net"],
        "BIOTOOLS BIOTECHNOLOGICAL AND MEDICAL LABORATORIES, S.A.": ["http://biotools.eu","orders@biotools.eu"],
        "CARL ZEISS IBERIA, S.L.": ["http://www.zeis.es","hector.lena@zeiss.com"],
        "CASA ALVAREZ MATERIAL CIENTÍFICO, S.A.": ["http://www.casaalvarez.com","atencionalcliente@casaalvarez.com"],
        "CONTROLTECNICA INSTRUMENTACION CIENTIFICA, S.L.": ["http://www.cic-controltecnica.com","pedidos@controltecnica.com"],
        "CROMLAB, S.L.": ["http://www.cromlab.es","gestioncomercial@cromlab.es"],
        "CULTEK, S.L.": ["http://www.cultek.com","cultekbarna@cultek.com"],
        "CYMIT QUIMICA, S.L.": ["http://www.cymitquimica.com","ventas@cymitquimica.com"], 
        "DDBIOLAB, S.L.": ["http://www.ddbiolab.com","sibanez@ddbiolab.com"],
        "DELTACLON, S.L.": ["http://www.deltaclon.com","pedidos@deltaclon.com"],
        "DISPROMERGI, S.L.": ["http://www.dispromergi.com","ismael@dispromegi.com"],
        "ENVIGO RMS SPAIN, S.L.": ["http://www.envigo.com","envigoclientes@envigo.com"],
        "EPPENDORF IBÉRICA, S.L.U.": ["http://www.eppendorf.com","eppendorf@eppendorf.es"],
        "FERRETERIA CONDAL, S.A.": ["", "ferreteriacondal@gmail.com"],
        "FISHER SCIENTIFIC, S.L.": ["http://www.thermofisher.com","pedidosinternet@lifetech.com"],
        "GE HEALTHCARE EUROPE GMBH SUCURSAL EN ESPAÑA": ["http://www.gelifesciences.com","pedidos.es@ge.com"],
        "GILSON INTERNATIONAL BV SUCURSAL EN ESPAÑA": ["https://es.gilson.com","sales-es@gilson.com"],
        "GREINER BIO-ONE ESPAÑA, S.A.U.": ["http://www.gbo.com","pedidos@es.gbo.com"],
        "GRUP GEPORK, S.A.": ["http://www.gepork.es","notificaciones@gepork.es"],
        "HALECO IBERIA, S.L.": ["http://www.haleco.es","cliente@haleco.es"],
        "IBERFLUID INSTRUMENTS, S.A.": ["http://www.iberfluid.com","intec@iberfluid.com"],
        "ILLUMINA PRODUCTOS DE ESPAÑA, S.L.": ["https://www.illumina.com","customerservice@illumina.com"],
        "IMMUNOSTEP, S.L.": ["https://www.immunostep.com","order@immunostep.com"],
        "INGENIERIA ANALITICA, S.L.": ["http://www.ingenieria-analitica.com","pedidos@ingenieria-analitica.com"],
        "INNOVATIVE TECHNOLOGIES IN BIOLOGICAL SYSTEMS, S.L.": ["http://www.innoprot.com","orders@innoprot.com"],
        "INQUALAB DISTRIBUCIONES, S.L.": ["http://www.inqualab.es","info@inqualab.es"],
        "INSTRUMENTACION ANALITICA, S.A.": ["http://www.instru.es","barcelona@instru.es"],
        "INSTRUMENTACIÓN Y COMPONENTES, S.A .": ["http://www.inycom.es","esteban.gallego@inycom.es"],
        "INTEGRATED DNA TECHNOLOGIES SPAIN, S.L.": ["http://www.idtdna.com","euorders@idtdna.com"],
        "ISOGEN LIFE SCIENCE BV": ["http://www.isogen-lifescience.com","orders@isogen-lifescience.com"],
        "IZASA SCIENTIFIC, S.L.U.": ["http://www.izasascientific.com","izasatenders@izasascientifics.com"],
        "JANVIER LABS": ["http://www.janvier-labs.com","espana@janvier-labs.com"],
        "LABCLINICS, S.A.": ["http://www.labclinics.com","pedidos@labclinics.com"],
        "LABNET BIOTECNICA, S.L.": ["http://www.labnet.es","labnet@labnet.es"],
        "LABORATORIOS CONDA, S.A.": ["https://www.condalab.com","comercial@condalab.com"],
        "LEYBOLD HISPÁNICA, S.A.": ["https://www.leyboldproducts.com","sales.ba@leybold.com"],
        "LIFETECHNOLOGIES, S.A.": ["http://www.thermofisher.com","csiberia@thermofisher.com"],
        "LINEALAB, S.L.": ["http://www.linealab.es","pedidos1@linealab.com"],
        "MARIA MIRÓ PÀMIES": ["","miroproteccio@gmail.com"],
        "MERCK LIFE SCIENCE, S.L.U.": ["http://www.sigmaaldrich.com","spcustomerraltions@merckgroup.com"],
        "MONLAB, S.L.": ["http://www.monlab.es","mn.pedidos@monlab.es"],
        "NIRCO, S.L.": ["http://www.nirco.com","pedidos@nirco.com"],
        "PALEX MEDICAL, S.A.": ["http://www.palexmedical.com","pedidos.norte@palex.es"],
        "PANLAB, S.L.U.":["http://www.panlab.com","info@panlab.com"], 
        "PHENOMENEX ESPAÑA, S.L.U.":["http://www.phenomenex.com","marquezm@phenomenex.com"], 
        "PROMEGA BIOTECH IBÉRICA, S.L.":["https://www.promega.es","esp_custserv@promega.com"], 
        "PROQUINORTE, S.A.":["http://www.proquinorte.com","pedidos@proquinorte.com"], 
        "QUIMEGA, S.L.":["http://www.quimega.com","jm.gaya@quimega.com"],
        "QUIMIGEN, S.L.":["http://www.quimigen.com","pedidos@quimigen.com"],
        "REACTIVA, S.A.":["http://www.tpp.ch","inforeactivasa@gmail.com"],
        "ROCHE DIAGNOSTICS, S.L.":["https://www.roche.es","sant_cugat.rede_pedidos@roche.com"],
        "SANGÜESA, S.A.": ["", "comandes@sanguesa.net"],
        "SARSTEDT, S.A.U.":["http://www.sarstedt.com","info.es@sarstedt.com"],
        "SCHARLAB, S.L.":["http://www.scharlab.com","salesmanager03@scharlab.com"],
        "SERVIQUIMIA, S.L.":["http://serviquimia.com","pedidos@serviquimia.com"],
        "SG SERVICIOS HOSPITALARIOS, S.L.":["http://www.sgsh.es","pedidos@sgsh.es"],
        "SISTEMAS DIDÁCTICOS DE LABORATORIO, S.L.":["http://www.sidilab.com","sidilab@sidilab.com"],
        "SUDELAB, S.L.":["http://sudelab.com","sudelab@sudelab.com"],
        "SUMINISTROS GENERALES PARA LABORATORIO, S.L.":["http://sglab.net","mlopez@sglab.net"],
        "SUMINISTROS NESSLAB, S.L.":["http://www.nesslab.es","compras@nesslab.es"],
        "TACKLEN MEDICAL TECHNOLOGY, S.L.":["http://tacklen.com","pedidos@tacklen.com"],
        "TEBU-BIO SPAIN, S.L.":["https://www.tebu-bio.com","spain@tebu-bio.com"],
        "TEKNOKROMA ANALÍTICA, S.A.":["http://www.teknokroma.es","mdfarnos@teknokroma.es"],
        "THERMO FISHER SCIENTIFIC, S.L.U.":["https://www.thermofisher.com","cs.spain@thermofisher.com"],
        "TOLL ANDREU, S.L.":["http://www.tollandreu.com","tollandreu@tollandreu.cim"],
        "UNIDIX MEDICA, S.L.":["http://www.unidixmedica.com","pedidos@unidixmedica.com"],
        "VERTEX TECHNICS, S.L.":["https://www.vertex.es","ventas@vertex.es"],
        "VIDRA FOC, S.A.":["http://www.vidrafoc.com","info@vidrafoc.com"],
        "VITRO, S.A.":["http://www.vitro.bio","pedidos@vitro.bio"],
        "VWR INTERNATIONAL EUROLAB, S.L.":["http://es.vwr.com","pedidos@vwr.com"],
        "WATERS CROMATOGRAFÍA, S.A.":["http://www.waters.com","consumibles@waters.com"],
        "WERFEN ESPAÑA, S.A.U.":["http://www.werfen.com", "customerservice-es@werfen.com"] 
    };             

    var table = $('#articles').DataTable({

       "processing": true,
       "serverSide": true,
       "ajax": "server_processing.php",
       "columnDefs": [
           {
               "targets": [1, 3, 6, 7, 8, 11, 12, 13, 14], 
               "className": "dt-body-right"
           }, 
           {
               "targets": [0], 
               "render": function (data) {
                   if (!(data in website_dict)) {
                        return data; 
                   } 
                   if (website_dict[data][0] == "") {
                        return data + ' <a href="mailto:'+website_dict[data][1]+'" data-toggle="tooltip" title="Email"><i class="far fa-envelope"></i></a>';
                   }
                   return '<a href='+website_dict[data][0]+'>'+data+'</a>' + ' <a href="mailto:'+website_dict[data][1]+'" data-toggle="tooltip" title="Email"><i class="far fa-envelope"></i></a>'; 
               }
           }
       ],  
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
         }, 
         "pageLength": 25 
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
