<?php
require 'conDB.php';
if(!$_SESSION['id']){
  header('location:logandreg.php');
}

try {
//prepare
$sql = "DELETE FROM electrical WHERE id_elect=?";
$stmt = $conn->prepare($sql);
//Bind
$stmt->bindParam(1,$_GET["id_elect"]);

if($stmt->execute())
    header("location: electData.php");

} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $conn = null;
?>