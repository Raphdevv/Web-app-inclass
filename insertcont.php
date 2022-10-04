<?php
session_start();
require 'conDB.php';
error_reporting(E_ERROR | E_PARSE);
if(!$_SESSION['id']){
  header('location:logandreg.php');
}
$dir = "cpnt_pic/"; //สร้างพาทที่ที่จะเอาภาพไปเก็บ
$fileImg = $dir . basename($_FILES["pic_cont"]["name"]); //เอาตัวเเปรที่เก็บพาท$dir ตามด้วย . คือการเชื่อมสตริงเหมือน + ตามด้วย  basename คือเอาเเต่ชื่อ [name ที่ใส่ในหน้าfrom]["name"คือเอาชื่อไฟล์ภาพ หยิบได้หลายเเบบเป็นคำสั่ง]
move_uploaded_file($_FILES["pic_cont"]["tmp_name"], $fileImg)

?>

<?php
if (isset($_POST['fristname']) && isset($_POST['lastname'])) {

  try {
    $stmt = $conn->prepare("INSERT INTO picture_cont (std_cont, fristname, lastname, pic_cont)
  VALUES (:std_cont, :fristname, :lastname, :pic_cont)");
    $stmt->bindParam(':std_cont', $std_cont);
    $stmt->bindParam(':fristname', $fristname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':pic_cont', $fileImg);

    $std_cont = $_POST['std_cont'];
    $fristname = $_POST['fristname'];
    $lastname =  $_POST['lastname'];
    $stmt->execute();
    header("location: contData.php");
    echo "New records created successfully";
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
$conn = null;
exit;
?>