<?php
session_start();
require 'conDB.php';
error_reporting(E_ERROR | E_PARSE);
if(!$_SESSION['id']){
    header('location:logandreg.php');
}
$dir = "electronic_pic/"; //สร้างพาทที่ที่จะเอาภาพไปเก็บ
$fileImg = $dir . basename($_FILES["pic_electro"]["name"]); //เอาตัวเเปรที่เก็บพาท$dir ตามด้วย . คือการเชื่อมสตริงเหมือน + ตามด้วย  basename คือเอาเเต่ชื่อ [name ที่ใส่ในหน้าfrom]["name"คือเอาชื่อไฟล์ภาพ หยิบได้หลายเเบบเป็นคำสั่ง]
move_uploaded_file($_FILES["pic_electro"]["tmp_name"], $fileImg)
?> 

<?php
if (isset($_POST['name_electro']) && isset($_POST['recommend_electro'])) {

    try {
        $stmt = $conn->prepare("INSERT INTO electronic (name_electro, recommend_electro, treatment_electro, pic_electro)
  VALUES (:name_electro, :recommend_electro, :treatment_electro, :pic_electro)");
        $stmt->bindParam(':name_electro', $name_electro);
        $stmt->bindParam(':recommend_electro', $recommend_electro);
        $stmt->bindParam(':treatment_electro', $treatment_electro);
        $stmt->bindParam(':pic_electro', $fileImg);

        $name_electro = $_POST['name_electro'];
        $recommend_electro = $_POST['recommend_electro'];
        $treatment_electro =  $_POST['treatment_electro'];
        $stmt->execute();
        header("location: electroData.php");
        echo "New records created successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
$conn = null;
exit;
?>