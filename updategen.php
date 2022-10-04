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
  $sql = "SELECT * FROM general  WHERE id_gen=?";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(1, $_GET["id_gen"]);  //นำค่า id ที่ส่งมากับ URL มากำหนดเป็นเงื่อนไข
  $stmt->execute();
  $publisher = $stmt->fetch();  //ดังผลลัพธ์ (จะได้ข้อมูลเพียง 1 แถว)
?>
<div class="container-fluid">
  <form action="updategen.php" method="post">
    <div class="container">
      <div class="row xl-3">
        <div class="text-center">
          <input type="hidden" class="form-control" name="id_gen" value="<?= $publisher["id_gen"] ?> ">
        </div>
      </div>
      <br>

      <div class="row xl-3">
        <div class="text-center">
          <input type="text" class="form-control" name="name_gen" placeholder="ชื่อพนักงาน" value="<?= $publisher["name_gen"]; ?>">
        </div>
      </div>
      <br>

      <div class="row xl-3">
        <div class="text-center">
          <input type="text" class="form-control" name="recommend_gen" placeholder="เงินเดือน" value="<?= $publisher["recommend_gen"]; ?>">
        </div>
      </div>
      <br>

      <div class="row xl-3">
        <div class="text-center">
          <input type="text" class="form-control" name="treatment_gen" placeholder="ที่อยู่" value="<?= $publisher["treatment_gen"]; ?>">
        </div>
      </div>
      <br>
      <div class="text-center">
          <input type='file' name='pic_gen' multiple  value="<?= $publisher["pic_gen"]; ?>">
        </div>
      <br>
      <div class="text-center">
        <button type="submit" class="btn btn-dark" value="Update">แก้ไขข้อมูล</button>
      </div>
      <br>
    </div>
  </form>
  <div class="text-center">
      <a href="genData.php" class="btn btn-dark">กลับหน้าหลัก</a>
  </div>
</div>
<?php
} catch (PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}
?>

<?php
$dir = "general_pic/".$_POST["pic_gen"]; //สร้างพาทที่ที่จะเอาภาพไปเก็บ
$fileImg = $dir . basename($_FILES["pic_gen"]["name"]); //เอาตัวเเปรที่เก็บพาท$dir ตามด้วย . คือการเชื่อมสตริงเหมือน + ตามด้วย  basename คือเอาเเต่ชื่อ [name ที่ใส่ในหน้าfrom]["name"คือเอาชื่อไฟล์ภาพ หยิบได้หลายเเบบเป็นคำสั่ง]
move_uploaded_file($_FILES["pic_gen"]["tmp_name"], $fileImg)
?>

<?php
try {
if(isset($_POST['id_gen'])){
//prepare
$sql = "UPDATE general SET name_gen=?, recommend_gen=?, treatment_gen=?, pic_gen=? WHERE id_gen=?";
$stmt = $conn->prepare($sql);
//bindParam
$stmt->bindParam(1,$_POST["name_gen"]);
$stmt->bindParam(2,$_POST["recommend_gen"]);
$stmt->bindParam(3,$_POST["treatment_gen"]);
$stmt->bindParam(4,$fileImg);
$stmt->bindParam(5,$_POST["id_gen"]);
//Execute
$stmt->execute();
if($stmt == true){
echo "แก้ไขข้อมูลเรียบร้อย";
header("location: genData.php");
}else{
echo "แก้ไขข้อมูลไม่ได้";
}
} //end if
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $conn = null;
?>