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
  <script>
    function confirmDelete(id_cont) { //ฟังก์ชันจะถูกเรียกใช้ถ้าผู้ใช้คลิกที่ลิงค์ Delete
      var ans = confirm("ต้องการลบหรือไม่"); //แสดงกล่องถามผู้ใช้
      if (ans == true) //ถ้าผู้ใช้กด OK จะเข้าเงื่อนไขนี้
        document.location = "deletecont.php?id_cont=" + id_cont; //ส่งรหัสสินค้า               
    }
  </script>
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
  <title>Form Input</title>
</head>

<body>
  <!-- navbar -->
  <nav class="navbar sticky-top navbar-expand-sm navbar-light bg-light">
    <div class="container">
      <a href="home.html" class="navbar-brand">
        <img src="img\E.png" height="35" />
        <img src="img\EASY THINGs55.png" alt="LOGO" />
      </a>
      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navbar1" class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="electData.php" class="nav-link">ฟอร์มข้อมูลเครื่องใช้ไฟฟ้า</a>
          </li>
          <li class="nav-item">
            <a href="electroData.php" class="nav-link">ฟอร์มข้อมูลเครื่องใช้อิเล็กทรอนิกส์</a>
          </li>
          <li class="nav-item">
            <a href="genData.php" class="nav-link">ฟอร์มข้อมูลของใช้ทั่วไป</a>
          </li>
          <li class="nav-item">
            <a href="contData.php" class="nav-link active">ฟอร์มข้อมูลผู้จัดทำ</a>
          </li>
          <li class="nav-item">
            <a href="logOut.php" class="nav-link">Log Out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <table class="table table-dark table-striped">
      <thead>
        <tr>
          <th scope="col">รหัสนักศึกษา</th>
          <th scope="col">ชื่อ</th>
          <th scope="col">นามสกุล</th>
          <th scope="col">รูปภาพ</th>
          <th scope="col">แก้ไขข้อมูล</th>
          <th scope="col">ลบข้อมูล</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM picture_cont";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        while ($publisher = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
          <tr>
            <td><?php echo $publisher["std_cont"] ?></td>
            <td><?php echo $publisher["fristname"] ?></td>
            <td><?php echo $publisher["lastname"] ?></td>
            <td><img src="<?php echo $publisher["pic_cont"] ?>" class="img-responsive" width="50px" /></td>
            <td><?php echo "<a class='btn btn-warning' href='updatecont.php?id_cont=" . $publisher["id_cont"] . "'>Update</a>" ?></td>
            <td><?php echo "<a class='btn btn-danger' onclick='confirmDelete(" . $publisher["id_cont"] . ")'>Delete</a>" ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <div class="text-center">
      <a data-bs-toggle="modal" data-bs-target="#b1" class="btn btn-dark">Insert</a>
    </div>
  </div>

  <div class="modal fade" id="b1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">เพิ่มข้อมูลผู้จัดทำ</h3>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form action="insertcont.php" method="post" enctype='multipart/form-data'>
              <div class="container">
                <div class="row xl-3">
                  <div class="text-center">
                    <input type="text" class="form-control" id="inputstd_cont" name="std_cont" placeholder="รหัสนักศึกษา">
                  </div>
                </div>
                <br>

                <div class="row xl-3">
                  <div class="text-center">
                    <input type="text" class="form-control" id="inputfristname" name="fristname" placeholder="ชื่อ">
                  </div>
                </div>
                <br>

                <div class="row xl-3">
                  <div class="text-center">
                    <input type="text" class="form-control" id="inputlastname" name="lastname" placeholder="นามสกุล">
                  </div>
                </div>
                <br>
                <div class="text-center">
                  <input type='file' name='pic_cont' multiple />
                </div>
                <br>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">เพิ่มข้อมูล</button>
                </div>
                <br>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">
              ปิด
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

