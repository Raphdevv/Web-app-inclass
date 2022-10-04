<?php
require 'conDB.php';
if(!$_SESSION['id']){
  header('location:logandreg.php');
}

try {
//prepare
$sql = "DELETE FROM general WHERE id_gen=?";
$stmt = $conn->prepare($sql);
//Bind
$stmt->bindParam(1,$_GET["id_gen"]);

if($stmt->execute())
    header("location: genData.php");

} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $conn = null;
?>