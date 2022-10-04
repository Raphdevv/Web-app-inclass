<?php
require 'conDB.php';
if(!$_SESSION['id']){
  header('location:logandreg.php');
}

try {
//prepare
$sql = "DELETE FROM electronic WHERE id_electro=?";
$stmt = $conn->prepare($sql);
//Bind
$stmt->bindParam(1,$_GET["id_electro"]);

if($stmt->execute())
    header("location: electroData.php");

} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $conn = null;
?>