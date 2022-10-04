<?php
session_start();
require 'conDB.php';
error_reporting(E_ERROR | E_PARSE);
if(!$_SESSION['id']){
  header('location:logandreg.php');
}
$dir = "general_pic/"; //สร้างพาทที่ที่จะเอาภาพไปเก็บ
$fileImg = $dir . basename($_FILES["pic_gen"]["name"]); //เอาตัวเเปรที่เก็บพาท$dir ตามด้วย . คือการเชื่อมสตริงเหมือน + ตามด้วย  basename คือเอาเเต่ชื่อ [name ที่ใส่ในหน้าfrom]["name"คือเอาชื่อไฟล์ภาพ หยิบได้หลายเเบบเป็นคำสั่ง]
move_uploaded_file($_FILES["pic_gen"]["tmp_name"], $fileImg)

?>

<?php
if (isset($_POST['name_gen']) && isset($_POST['recommend_gen'])) {

  try {
    $stmt = $conn->prepare("INSERT INTO general (name_gen, recommend_gen, treatment_gen, pic_gen)
  VALUES (:name_gen, :recommend_gen, :treatment_gen, :pic_gen)");
    $stmt->bindParam(':name_gen', $name_gen);
    $stmt->bindParam(':recommend_gen', $recommend_gen);
    $stmt->bindParam(':treatment_gen', $treatment_gen);
    $stmt->bindParam(':pic_gen', $fileImg);

    $name_gen = $_POST['name_gen'];
    $recommend_gen = $_POST['recommend_gen'];
    $treatment_gen =  $_POST['treatment_gen'];
    $stmt->execute();
    header("location: genData.php");
    echo "New records created successfully";
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
$conn = null;
exit;
?>