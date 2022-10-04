<?php
require 'conDB.php';
if(!$_SESSION['id']){
  header('location:logandreg.php');
}

try {
//prepare
$sql = "DELETE FROM picture_cont WHERE id_cont=?";
$stmt = $conn->prepare($sql);
//Bind
$stmt->bindParam(1,$_GET["id_cont"]);

if($stmt->execute())
    header("location: contData.php");

} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $conn = null;
?>