<?php
ini_set('display_errors', '0');

$nosr = $_GET['nosr'];


$dirhost = "C://xampp/htdocs/";//"http://".$_SERVER["HTTP_HOST"];
$dirhost .= str_replace(basename($_SERVER["SCRIPT_NAME"]),"",$_SERVER["SCRIPT_NAME"]);
$target = 'C://xampp/htdocs/FotoRumah'; 

$dirWM = "../FotoWM/";


$tahun = date('Y');
$bulan = date('m');
$nbulan = date('F')."-".$tahun;

$tgl1  = mktime(0,0,0,$bulan-1,1,$tahun);
$tgl2  = mktime(0,0,0,$bulan-2,1,$tahun);


$bulan1 = date('m',$tgl1);
$bulan2 = date('m',$tgl2);
$nbulan1 = date('F',$tgl1)."-".$tahun;
$nbulan2 = date('F',$tgl2)."-".$tahun;

$fWM  = $dirWM."".$tahun."/".$bulan."/0/".$nosr.".jpg";
$fWM1 = $dirWM."".$tahun."/".$bulan1."/0/".$nosr.".jpg";
$fWM2 = $dirWM."".$tahun."/".$bulan2."/0/".$nosr.".jpg";


//sqlserver connection
$serverName = "192.168.1.15,6501"; //serverName\instanceName, portNumber (default is 1433)
$connectionInfo = array( "Database"=>"gdu_pdam", "UID"=>"sa", "PWD"=>"password.1");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn == false ) {
     echo '<div class="alert alert-danger" role="alert">Koneksi Ke Database Gagal!!</div>';
     die();
}


$sql = "SELECT * FROM Pelanggan2 where nosr='".$nosr."'";
//echo $sql;
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    echo '<div class="alert alert-danger" role="alert">Ada Kesalahan Query!!</div>';
    die();
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $nama =  $row['nama'];
      $tarif =  $row['tarif'];
      $alamat =  $row['alamat'];
}

sqlsrv_free_stmt( $stmt);



?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Detail Info Dari Pelanggan : <?php echo $nosr; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />

    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">

<div class="page-header text-center">
   <img class="img-responsive" style="margin: 4px auto; width : 282px; " alt="Bootstrap template" src="gdu.jpg" />
</div>

<div class="container">
      <div class="col-md-3 text-center">
        <div class="panel panel-primary">
          <div class="panel-heading">No. SR</div>
            <div class="panel-body">
              <?php echo $nosr; ?>
            </div>
        </div>
      </div>
      <div class="col-md-3 text-center">
        <div class="panel panel-primary">
          <div class="panel-heading">Nama</div>
            <div class="panel-body">
              <?php echo $nama; ?>
            </div>
        </div>
      </div>
      <div class="col-md-3 text-center">
        <div class="panel panel-primary">
          <div class="panel-heading">Tarif</div>
            <div class="panel-body">
              <?php echo $tarif; ?>
            </div>
        </div>
       </div>
       <div class="col-md-3 text-center">
        <div class="panel panel-primary">
          <div class="panel-heading">Alamat</div>
            <div class="panel-body">
              <?php echo $alamat; ?>
            </div>
        </div>
      </div>  
        
        
      
</div>

<!-- Responsive Gallery - START -->

<style>
img.thumbnail {
    filter: gray; /* IE6-9 */
    -webkit-filter: grayscale(1); /* Google Chrome, Safari 6+ & Opera 15+ */
    -webkit-box-shadow: 0px 2px 6px 2px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 2px 6px 2px rgba(0,0,0,0.75);
    box-shadow: 0px 2px 6px 2px rgba(0,0,0,0.75);
    margin-bottom: 20px;
}
img.thumbnail:hover {
    filter: none; /* IE6-9 */
    -webkit-filter: grayscale(0); /* Google Chrome, Safari 6+ & Opera 15+ */
}
</style>

<div class="container">
    <div class="row">
        <div class="text-center">
            <h1>Foto Rumah Pelanggan</h1>
        </div>
        <div class="row">
          <?php if (is_file("../FotoRumah/".$nosr.".jpg")) { ?>
            <div class="col-md-4">
                <div class="well">
                  <center>
                    <img class="thumbnail img-responsive" alt="Bootstrap template" src="../FotoRumah/<?php echo $nosr;?>.jpg" />
                  </center>
                </div>
            </div>
          <?php } ?>
          <?php if (is_file("../FotoRumah/".$nosr."_1.jpg")) { ?>
            <div class="col-md-4">
                <div class="well">
                  <center>
                    <img class="thumbnail img-responsive" alt="Bootstrap template" src="../FotoRumah/<?php echo $nosr;?>_1.jpg" />
                  </center>
                </div>
            </div>
          <?php } ?>
          <?php if (is_file("../FotoRumah/".$nosr."_2.jpg")) { ?>
            <div class="col-md-4">
                <div class="well">
                  <center>
                    <img class="thumbnail img-responsive" alt="Bootstrap template" src="../FotoRumah/<?php echo $nosr;?>_2.jpg" />
                  </center>
                </div>
            </div>
          <?php } ?>
        </div>
        <div class="text-center">
            <h1>Water Meter 3 Bulan Terakhir</h1>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="well">
                    <center><h3><?php echo $nbulan; ?></h3>
                    <?php if (is_file($fWM)) { ?>
                    <img class="thumbnail img-responsive" alt="<?php echo $fWM; ?>" src="<?php echo $fWM; ?>" />
                    <?php } else { ?>
                    <img class="thumbnail img-responsive" alt="<?php echo $fWM; ?>" src="no-photo.jpg" />
                    <?php } ?>
                    
                    </center>
                </div>
            </div>
            <div class="col-md-4">
                <div class="well">
                    <center><h3><?php echo $nbulan1; ?></h3>
                    <?php if (is_file($fWM1)) { ?>
                    <img class="thumbnail img-responsive" alt="<?php echo $fWM1; ?>" src="<?php echo $fWM1; ?>" />
                    <?php } else { ?>
                    <img class="thumbnail img-responsive" alt="<?php echo $fWM; ?>" src="no-photo.jpg" />
                    <?php } ?>
                    </center>
                </div>
            </div>
            <div class="col-md-4">
                <div class="well">
                    <center><h3><?php echo $nbulan2; ?></h3>
                    <?php if (is_file($fWM2)) { ?>
                    <img class="thumbnail img-responsive" alt="<?php echo $fWM2; ?>" src="<?php echo $fWM2; ?>" />
                    <?php } else { ?>
                    <img class="thumbnail img-responsive" alt="<?php echo $fWM; ?>" src="no-photo.jpg" />
                    <?php } ?>
                    </center>
                </div>
            </div>
        </div>
        
    </div>
</div>
<!-- Responsive Gallery - END -->

</div>

</body>
</html>