<?php
session_start();
require 'conDB.php';
error_reporting(E_ERROR | E_PARSE);
if(!$_SESSION['id']){
  header('location:logandreg.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #000;
            color: white;
            text-align: center;
        }
    </style>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <title>โปรแกรมจัดการร้านค้าปลีก: เพิ่มข้อมูลพนักงาน</title>
</head>
ิ<body>
<?php
try {
  $sql = "SELECT * FROM electronic  WHERE id_electro=?";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(1, $_GET["id_electro"]);  //นำค่า id ที่ส่งมากับ URL มากำหนดเป็นเงื่อนไข
  $stmt->execute();
  $publisher = $stmt->fetch();  //ดังผลลัพธ์ (จะได้ข้อมูลเพียง 1 แถว)
?>
<div class="container-fluid">
  <form action="updateElectro.php" method="post">
    <div class="container">
      <div class="row xl-3">
        <div class="text-center">
          <input type="hidden" class="form-control" name="id_electro" value="<?= $publisher["id_electro"] ?> ">
        </div>
      </div>
      <br>

      <div class="row xl-3">
        <div class="text-center">
          <input type="text" class="form-control" name="name_electro" placeholder="ชื่อพนักงาน" value="<?= $publisher["name_electro"]; ?>">
        </div>
      </div>
      <br>

      <div class="row xl-3">
        <div class="text-center">
          <input type="text" class="form-control" name="recommend_electro" placeholder="เงินเดือน" value="<?= $publisher["recommend_electro"]; ?>">
        </div>
      </div>
      <br>

      <div class="row xl-3">
        <div class="text-center">
          <input type="text" class="form-control" name="treatment_electro" placeholder="ที่อยู่" value="<?= $publisher["treatment_electro"]; ?>">
        </div>
      </div>
      <br>

      <div class="text-center">
          <input type='file' name='pic_electro' multiple  value="<?= $publisher["pic_electro"]; ?>">
        </div>
      <br>
      <div class="text-center">
        <button type="submit" class="btn btn-dark" value="Update">แก้ไขข้อมูล</button>
      </div>
      <br>
    </div>
  </form>
  <div class="text-center">
      <a href="electroData.php" class="btn btn-dark">กลับหน้าหลัก</a>
  </div>
</div>
<?php
} catch (PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}
?>

<?php
$dir = "electronic_pic/".$_POST["pic_electro"]; //สร้างพาทที่ที่จะเอาภาพไปเก็บ
$fileImg = $dir . basename($_FILES["pic_electro"]["name"]); //เอาตัวเเปรที่เก็บพาท$dir ตามด้วย . คือการเชื่อมสตริงเหมือน + ตามด้วย  basename คือเอาเเต่ชื่อ [name ที่ใส่ในหน้าfrom]["name"คือเอาชื่อไฟล์ภาพ หยิบได้หลายเเบบเป็นคำสั่ง]
move_uploaded_file($_FILES["pic_electro"]["tmp_name"], $fileImg)
?>

<?php
try {
if(isset($_POST['id_electro'])){
//prepare
$sql = "UPDATE electronic SET name_electro=?, recommend_electro=?, treatment_electro=?, pic_electro=? WHERE id_electro=?";
$stmt = $conn->prepare($sql);
//bindParam
$stmt->bindParam(1,$_POST["name_electro"]);
$stmt->bindParam(2,$_POST["recommend_electro"]);
$stmt->bindParam(3,$_POST["treatment_electro"]);
$stmt->bindParam(4,$fileImg);
$stmt->bindParam(5,$_POST["id_electro"]);
//Execute
$stmt->execute();
if($stmt == true){
echo "แก้ไขข้อมูลเรียบร้อย";
header("location: electroData.php");
}else{
echo "แก้ไขข้อมูลไม่ได้";
}
} //end if
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $conn = null;
?>