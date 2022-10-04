<?php
session_start();
require 'conDB.php';
error_reporting(E_ERROR | E_PARSE);
if(!$_SESSION['id']){
  header('location:logandreg.php');
}
$dir = "electrical_pic/"; //สร้างพาทที่ที่จะเอาภาพไปเก็บ
$fileImg = $dir . basename($_FILES["pic_elect"]["name"]); //เอาตัวเเปรที่เก็บพาท$dir ตามด้วย . คือการเชื่อมสตริงเหมือน + ตามด้วย  basename คือเอาเเต่ชื่อ [name ที่ใส่ในหน้าfrom]["name"คือเอาชื่อไฟล์ภาพ หยิบได้หลายเเบบเป็นคำสั่ง]
move_uploaded_file($_FILES["pic_elect"]["tmp_name"], $fileImg)
?>

<?php
if (isset($_POST['name_elect']) && isset($_POST['recommend_elect'])) {

  try {
    $stmt = $conn->prepare("INSERT INTO electrical (name_elect, recommend_elect, treatment_elect, pic_elect)
  VALUES (:name_elect, :recommend_elect, :treatment_elect, :pic_elect)");
    $stmt->bindParam(':name_elect', $name_elect);
    $stmt->bindParam(':recommend_elect', $recommend_elect);
    $stmt->bindParam(':treatment_elect', $treatment_elect);
    $stmt->bindParam(':pic_elect', $fileImg);

    $name_elect = $_POST['name_elect'];
    $recommend_elect = $_POST['recommend_elect'];
    $treatment_elect =  $_POST['treatment_elect'];
    $stmt->execute();
    header("location: electData.php");
    echo "New records created successfully";
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
$conn = null;
exit;
?>