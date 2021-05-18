<?php
// Connect to Database
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'notes';
$insert = false;
$update = false;
$delete = false;
// Create a Conection
$conn = mysqli_connect($servername, $username, $password, $dbname);

//Die If connection was not successful
if (!$conn) {
  die("Sorry we failed to connect " . mysqli_connect_error());
}
if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `sro` = $sno";
  $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_POST['sroEdit'])) {
    // Update the Record
    $sro = $_POST["sroEdit"];
    $title = $_POST["titleEdit"];
    $description = $_POST["descEdit"];
    // SQL QUERY 
    $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sro` = $sro";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $update = true;
    } else {
      echo "We Could Not Update The Note Successfully...";
    }
  } else {
    $title = $_POST['title'];
    $description = $_POST['desc'];
    $sql = "INSERT INTO `notes`(`title`, `description`) VALUES ('$title','$description')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $insert = true;
      // echo "The Record Has Been Inserted Successfully.. 👍 ";
    } else {
      echo "The Record Was Not Inserted Successfully  of this Error -->" . mysqli_error($conn);
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

  <title>iNotes - PHP CURD Operation</title>
</head>

<body>
 
  <!--Edit  Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/crud/index.php" method="POST">
            <input type="hidden" name="sroEdit" id="sroEdit">
            <div class="mb-3">
              <label for="Title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp" />
              <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div>
            <div class="mb-3">
              <label for="desc" class="form-label">Not Description</label>
              <textarea class="form-control" id="descEdit" name="descEdit" rows="3"></textarea>
              <!-- <input type="password" class="form-control" id="exampleInputPassword1"> -->
            </div>
            <!-- <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div> -->
            <!-- <button type="submit" class="btn btn-primary">Update Note</button> -->
            <div class="modal-footer d-block mr-auto">
              <button type="submit" class="btn btn-primary">Save changes</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid"><img src="images (1).png" height="45px" width="87px" alt="Notes Logo">
      <a class="navbar-brand" href="#">&nbsp; Important Notes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
          <button class="btn btn-outline-success" type="submit">
            Search
          </button>
        </form>
      </div>
    </div>
  </nav>
  <?php
  if ($insert) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
     <strong>Success</strong> Your Note Has Been Successfully Inserted .
     <button type='button' class='btn-close' data-bs-dismiss'alert' aria-label='Close'></button>
   </div>";
  }
  ?>
  <?php
  if ($update) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
     <strong>Success</strong> Your Note Has Been Successfully Updated .
     <button type='button' class='btn-close' data-bs-dismiss'alert' aria-label='Close'></button>
   </div>";
  }
  ?>
  <?php
  if ($delete) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
     <strong>Success</strong> Your Note Has Been Successfully Deleted .
     <button type='button' class='btn-close' data-bs-dismiss'alert' aria-label='Close'></button>
   </div>";
  }
  ?>
  <div class="container my-2">
    <h3>Add A Note</h3>
    <form action="/crud/index.php" method="POST">
      <div class="mb-3">
        <label for="Title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" />
      </div>
      <div class="mb-3">
        <label for="desc" class="form-label">Not Description</label>
        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
      </div>
     
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>
  <div class="container my-4">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Sr No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $srno = 0;
        $sql = "SELECT * FROM `notes`";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
          $srno = $srno + 1;
          echo "<tr>
            <th scope='row'>" . $srno . "</th>
            <td>" . $row['title'] . "</td>
            <td>" . $row['description'] . "</td>
            <td> <button id=" . $row['sro'] . " class='edit btn btn-sm btn-primary'>Edit</button> 
            <button class='delete btn btn-sm btn-danger' id=d" . $row['sro'] . ">Delete</button></td>
            </tr>";
        }
        ?>
      </tbody>
    </table>

  </div>
  <hr>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit", );
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        decription = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, decription);
        titleEdit.value = title;
        descEdit.value = decription;
        sroEdit.value = e.target.id;
        console.log(e.target.id);
        $('#editModal').modal('toggle');

      })
    })
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("Delete", );

        sno = e.target.id.substr(1, );
        if (confirm("Are you Sure You Want To Delete This Note")) {
          console.log("yes");
          window.location = `/crud/index.php?delete=${sno}`;

          //  Create a Form and Use Post Request to Submit a Form

        } else {
          console.log("No");
        }
      })
    })
  </script>
  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
    -->
</body>

</html>