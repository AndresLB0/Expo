<!doctype html>

<?php
	// including FusionCharts PHP wrapper
	include("fusioncharts/fusioncharts.php");

	// establishing DB connection
	$host= "host=localhost";
	// add values for below variables according to your system
	$port= "port=5432";
	$dbname="dbname=fatyssa";
	$dbuser="user=postgres";
	$dbpwd="password=123";

	// connection string (pg_connect() is native PHP method for Postgres)
  $dbconn=pg_connect("$host $port $dbname $dbuser $dbpwd");

	// validating DB connection
  if(!$dbconn) {
		exit("There was an error establishing database connection");
	}

  $combo = pg_query($dbconn, "select id_linea, nombre_linea from linea");

?>

<html>
   <head>
      <title>productos por linea</title>
      
      <!-- including style and font css -->
      <link href='https://fonts.googleapis.com/css?family=Merriweather:300' rel='stylesheet' type='text/css'>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">    
      <style>
      	* {
      		margin: 0;
      		padding: 0;
      		background-color: #FAF6F3;
      	}
      </style>

      <!-- FusionCharts core package JS files -->
      <script src="https://static.fusioncharts.com/code/latest/fusioncharts.js"></script>
      <script src="https://static.fusioncharts.com/code/latest/fusioncharts.charts.js"></script>
      <script src="https://static.fusioncharts.com/code/latest/themes/fusioncharts.theme.fint.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>
   <body>
   <form name="frmAgregar" method="post" action="productoslineagraph.php">
   <div >				
   <select class="form-control" name = "slect" id="selctc" required>
        <option value = "0" selected>-- seleccione una linea --</option>
        <?php
          while ($fila = pg_fetch_array($combo)){
            echo "<option value =".$fila['id_linea'].">".$fila['nombre_linea']."</option>";
          }
          ?>
          </select>
          <input class="btn btn-primary" type="submit" name="btnAgregar" value="Consultar productos de esta linea">
				</div>
<?php
		if (isset($_POST["btnAgregar"])) {
			$espec=$_POST["slect"];
    }else{
      $espec=0;
    }
    $result = pg_query($dbconn, "select nombre_producto, precio_fact from producto where id_linea=".$espec.";") or exit("Error with quering database");
    $result2 = pg_query($dbconn, "select max(precio_fact) from producto where id_linea = ".$espec.";");    
  



  if ($result) {

  // creating an associative array to store the chart attributes
	$arrData = array(
        "chart" => array(
          	// caption and sub-caption customization
            "caption"=> "prodcutos por linea",
          	"captionFontSize"=> "24",
            "captionFontColor"=> "#4D394B",
            "captionPadding"=> "20",

            // font and text size customization
            "baseFont"=> "Merriweather, sans-serif",
            "baseFontColor"=> "#ABA39D",
            "outCnvBaseColor"=> "#ABA39D",
            "baseFontSize"=> "15",
            "outCnvBaseFontSize"=> "15",

            // div line customization
            "divLineColor"=> "#ABA39D",
            "divLineAlpha"=> "22",
            "numDivLines"=> "5",

            // y-axis scale customization
            "yAxisMinValue"=> "0",
            "yAxisMaxValue"=> pg_fetch_array($result2),

            // tool-tip customization
            "toolTipBorderColor"=> "#ABA8B7",
            "toolTipBgColor"=> "#F5F3F1",
            "toolTipPadding"=> "13",
            "toolTipAlpha"=> "50",
            "toolTipBorderThickness"=> "2",
            "toolTipBorderAlpha"=> "30",
            "toolTipColor"=> "#4D394B",
            "plotToolText"=> "<div style='text-align: center; line-height: 1.5;'>\$label<br>$ \$value   <div>",


            // other customizations
            "theme"=> "fint",
            "paletteColors"=> "#7B5A85",
            "showBorder"=> "0",
      			"bgColor"=> "#FAF6F3",
            "canvasBgColor"=> "#FAF6F3",
            "bgAlpha"=> "100",
            "showValues"=> "0",
            "formatNumberScale"=> "0",
            "plotSpacePercent"=> "33",
            "showcanvasborder"=> "0",
            "showPlotBorder"=> "0"
          )
    );

	$arrData["data"] = array();

	// iterating over each data and pushing it into $arrData array
	while($row = pg_fetch_array($result)) {
		array_push($arrData["data"], array(
			"label" => $row["nombre_producto"],
			"value" => $row["precio_fact"]
			)
		);
	}

  $jsonEncodedData = json_encode($arrData);

	// creating FusionCharts instance
	$postgresChart = new FusionCharts("column2d", "topMedalChart" , '100%', '450', "postgres-chart", "json", $jsonEncodedData);

  // FusionCharts render method
  $postgresChart->render();

	// closing database connection
  pg_close($dbconn);

  }

?>

 	<!-- creating chart container -->
 	<center><div id="postgres-chart">A beautiful chart is on its way!</div></center>
   
			</form>
  
   </body>
</html>
