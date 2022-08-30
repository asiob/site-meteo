<?php

$pdo = require 'connexion.php';


// require 'config.php';

//recuperer information csv
// $row = 1;
// if (($handle = fopen("data-meteo.csv", "r")) !== FALSE) {
//     while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
//         $num = count($data);
//         echo "<p> $num fields in line $row: <br /></p>\n";
//         $row++;
//         for ($c=0; $c < $num; $c++) {
//             echo $data[$c] . "<br />\n";
//         }
//     }
//     fclose($handle);
// }

//entrer dans chaque ligne pour recuperer chaque information
//tester ça



$file = new SplFileObject("data-meteo.csv");
$file->setFlags(SplFileObject::READ_CSV);
$file->setCsvControl(';', '"', '\\'); // this is the default anyway though
foreach ($file as $row) {
  $datas[] = $row;
    list ($dateDuJr, $ville, $periode, $info, $idResume, $tempMin, $tempMax, $com) = $row;
    // Do something with values
    // echo $date, $ville, $periode, $resume, $ident, $tempMin, $tempMax, $com;
    // for ($i=0; $i < count($row); $i++) { 
    //     echo $row[$i];
    // }
    
    // $sql = 'INSERT INTO meteo(dateDuJr, ville, periode, info, idResume, tempMin, tempMax, commentaire) VALUES(:dateDuJr, :ville, :periode, :info, :idResume, :tempMin, :tempMax, :commentaire)';

    // $statement = $pdo->prepare($sql);

    // $statement->execute([
    //     ':dateDuJr' => $dateDuJr,
    //     ':ville' => $ville,
    //     ':periode' => $periode,
    //     ':info' => $info,
    //     ':idResume' => $idResume,
    //     ':tempMin' => $tempMin,
    //     ':tempMax' => $tempMax,
    //     ':commentaire' => $com,
        
    // ]);
}

?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meteo du jour</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>
<body>

<div class="container">
            <!-- <div class="card card-1">
                <div id="demo" class="carousel slide" data-ride="carousel"> -->

                    <!-- Indicators -->
                    <!-- <ul class="carousel-indicators">
                      <li data-target="#demo" data-slide-to="0" class="active"></li>
                      <li data-target="#demo" data-slide-to="1"></li>
                      <li data-target="#demo" data-slide-to="2"></li>
                    </ul> -->
                  
                    <!-- The slideshow -->
                    <!-- <div class="carousel-inner">
                      <div class="carousel-item active">
                          <div class="row">
                            <div class="col-6">
                              <div class="temp">23&deg;</div> 
                              <div class="location">Coimbra, Portugal</div>
                            </div>
                            <div class="col-6 justify-content-right">
                              <img class="img-fluid" src="https://img.icons8.com/plasticine/100/000000/sun.png">
                            </div>
                          </div>
                         
                      </div>
                    </div>
                  
                  </div>
            </div> -->
            <?php 
              $sql = "SELECT DISTINCT `dateDuJr` FROM `meteo`";
              $dateJour = $pdo->query($sql);

             
                $dateSelected = $_GET["dateJr"];
               
           
            ?>
            <!-- formulaire pour choix de jour -->
            <form action="">
              <label for="">Choisissez une date</label>
              <select name="dateJr" id="">


            
                <?php foreach($dateJour as $date) : ?>
                  <option  value="<?= $date["dateDuJr"] ?>"><?= $date["dateDuJr"] ?></option>
                <?php endforeach; ?>
              </select>
              <input type="submit" value="Envoyer">
            </form>
            
            <div class="card card-2">
              <div id="demo" class="carousel slide" data-ride="carousel">

                <p><?php echo "$dateSelected" ;
                
                

                $sql= "SELECT * FROM meteo WHERE dateDuJr = '$dateSelected'" ;

                $select = $pdo->query($sql);
                
                $res = $select->fetchAll(PDO::FETCH_OBJ);

                

                ?></p>
                <!-- Indicators -->
                <ul class="carousel-indicators">
                  <li data-target="#demo" data-slide-to="0"></li>
                  <li data-target="#demo" data-slide-to="1" class="active"></li>
                  <li data-target="#demo" data-slide-to="2"></li>
                  
                </ul>
              
                <!-- The slideshow -->
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <div class="row">
                      <!-- foreach pour récupérer les données dans la base-->
                      <?php foreach($res as $value) :  ?>
                      <div class="col">
                        <div class="row row1"> <?php echo $value->tempMin ?> - <?php echo $value->tempMax ?>&deg;</div>
                        <div class="row row2"><img class="img-fluid" src=
                        <?php 

                        if($value->info == "ensoleillé") {
                          echo "https://img.icons8.com/ios/100/000000/sun.png";
                         }
                         else 
                         if($value->info == "pluvieux") {
                          echo "https://img.icons8.com/cotton/64/000000/rain--v3.png";
                        }
                      else 
                      if ($value->info == "nuageux"){
                        echo "https://img.icons8.com/windows/100/000000/cloud.png";
                      }
                      else {
                        echo "https://img.icons8.com/carbon-copy/344/foggy-night-1.png";
                      }

                      
                        
                        
                        ?>
                        /></div>
                        <div class="row row3"><?php echo $value->periode ?></div>
                        <div class="row row4"><?php echo $value->info ?></div>
                      </div>
                      <?php endforeach ?>
                      <!-- <div class="col">
                        <div class="row row1"><?php echo $tempMin ?> - <?php echo "$tempMax" ?>&deg;</div>
                        <div class="row row2"><img class="img-fluid" src="https://img.icons8.com/ios/100/000000/sun.png"/></div>
                        <div class="row row3"><?php echo "$periode" ?></div>
                        <div class="row row4"><?php echo "$info" ?></div>
                      </div>
                      <div class="col">
                        <div class="row row1"><?php echo "$tempMin" ?> - <?php echo "$tempMax" ?>&deg;</div>
                        <div class="row row2"><img class="img-fluid" src="https://img.icons8.com/windows/100/000000/cloud.png"/></div>
                        <div class="row row3"><?php echo "$periode" ?></div>
                        <div class="row row4"><?php echo "$info" ?></div>
                      </div> -->
                      <!-- <div class="col">
                        <div class="row row1">19&deg;</div>
                        <div class="row row2"><img class="img-fluid" src="https://img.icons8.com/windows/100/000000/cloud.png"/></div>
                        <div class="row row3">3:00</div>
                        <div class="row row4"><?php echo "$info" ?></div>
                      </div> -->
                      <!-- <div class="col">
                        <div class="row row1">18&deg;</div>
                        <div class="row row2"><img class="img-fluid" src="https://img.icons8.com/cotton/64/000000/rain--v3.png"/></div>
                        <div class="row row3">4:00</div>
                        <div class="row row4"><?php echo "$info" ?></div>
                      </div> -->
                    </div>
                     
                  </div>
                  <p><?php echo $value->ville ?></p>
                </div>
              
              </div>
              
              
            </div>
              </div>
            </div>
        </div>








<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>




<!-- https://www.web-dev-qa-db-fra.com/fr/php/comment-extraire-les-donnees-du-fichier-csv-dans-php/970081851/ -->