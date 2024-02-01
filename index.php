<?php 
// INSERT INTO `notes` (`sno`, `Name`, `title`, `description`, `timestamp`) VALUES ('1', 'shivani', 'go to buy fruits', 'hey shivani,\r\ni want to go to buy fruits.and delete this note once you done with this task', current_timestamp());
$insert = false;
$update = false;
$delete = false;
//connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

//create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

//die if connection wa not successful
if(!$conn){
  die("Sorry we failed to connect: ". mysqli_connect_error());
}

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql ="DELETE FROM `notes` WHERE `sno` =$sno";
  $result = mysqli_query($conn,$sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['snoEdit'])){
    //update the record
      $sno =$_POST["snoEdit"];
      $name =$_POST["nameEdit"];
      $title =$_POST["titleEdit"];
      $description =$_POST["descriptionEdit"];


    //sql query to be executed
    $sql = "UPDATE `notes` SET `description` = '$description' ,`title` ='$title',`name` ='$name' WHERE `notes`.`sno` = $sno;";
    $result =mysqli_query($conn, $sql);
    if($result){
      $update=true;
    }
    else{
      echo "we could not update the record successfully";
    }
  }
  else{
      $name =$_POST["name"];
      $title =$_POST["title"];
      $description =$_POST["description"];


    //sql query to be executed
    $sql = "INSERT INTO `notes`(`name`,`title`,`description`) VALUES ('$name','$title','$description')";
    $result =mysqli_query($conn, $sql);

    //add a new note to the notes table in the database
    if($result){
        
        $insert = true;
}
else{
  echo"the record was not inserted successfully because of this error --> ". mysqli_error($conn);
}
}
}



?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    
    
    <title>STUDENT NOTES</title>
    
  </head>
  <body>
   

<!--edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit this Note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="/crud/index.php" method="post">
      <div class="modal-body">
        <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="studentname" class="form-label">Student Name</label>
              <input type="text" class="form-control" id="studentnameEdit" name="nameEdit" aria-describedby="emailHelp">
              
            </div>
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit">
            </div>
            
              <div class="mb-3">
                <label for="desc" class="form-label">Note Description</label>
                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
              </div>
            <button type="submit" class="btn btn-primary">Update Note</button>
           
      </div>
      <div class="modal-footer d-block mr-auto">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><img src="/crud/logo.jpg" height="30px" alt="" srcset=""></a>
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
                <a class="nav-link" href="#">Contact US</a>
              </li>
              
              
            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>


      <?php
      if($insert){
      echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Success!</strong> Your note has been inserted successfully.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
      }

      ?>
      <?php
      if($delete){
      echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Success!</strong> Your note has been deleted successfully.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
      }

      ?>
      <?php
      if($update){
      echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Success!</strong> Your note has been updated successfully.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
      }

      ?>




      <div class="container my-4">
        <h2>Add a Student Data notes</h2>
        <form action="/crud/index.php" method="post">
            <div class="mb-3">
              <label for="studentname" class="form-label">Student Name</label>
              <input type="text" class="form-control" id="studentname" name="name" aria-describedby="emailHelp">
              
            </div>
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="title" name="title">
            </div>
            
              <div class="mb-3">
                <label for="desc" class="form-label">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
              </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
          </form>
      </div>

      <div class="container my-4">
      
 <table class="table" id ="myTable">
   <thead>
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">Name</th>
      <th scope="col">Title</th>
      <th scope="col">Desc</th>
      <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php 
        $sql ="SELECT * FROM `notes`";
        $result = mysqli_query($conn, $sql);
        $sno = 0;
        while($row = mysqli_fetch_assoc($result)){
          $sno = $sno +1;
          echo "<tr>
          <th scope='row'>". $sno . "</th>
          <td>". $row['Name'] . "</td>
          <td>". $row['title'] . "</td>
          <td>". $row['description'] . "</td>
          <td> <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button></td>
        </tr>";
        
      } 
      
      
    ?>
    
    
     </tbody>
    </table>
      </div>
      <hr>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
     $(document).ready(function() {
          $('#myTable').DataTable();
     } );
    </script>
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          console.log("edit",);
          tr = e.target.parentNode.parentNode;
          name = tr.getElementsByTagName("td")[0].innerText;
          title = tr.getElementsByTagName("td")[1].innerText;
          description = tr.getElementsByTagName("td")[2].innerText;
          console.log(name,title, description);
          document.getElementById('studentnameEdit').value = name;
          titleEdit.value = title;
          descriptionEdit.value = description;
          snoEdit.value =e.target.id;
          console.log(e.target.id);
          $('#editModal').modal('toggle');

        })
      });

      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          console.log("edit",);
          sno = e.target.id.substr(1,);
          
         if(confirm("Are you sure you want to delete this note!")){
          console.log("yes");
          window.location = `/crud/index.php?delete=${sno}`;
          // TODO: create a form and use post request to submit a form
         }
         else{
          console.log("no");
         }

        })
      });
    </script>
  </body>
</html>