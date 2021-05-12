<?php
$insert = false;
$update = false;
$delete = false;
//connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$databse = "notes";

//creates the connection
$con = mysqli_connect($servername, $username, $password, $databse);

//Die if connection is not Successful
if(!$con){
  die("Sorry we failed to connect: ".mysqli_connect_error());
}

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $delete_sql = "DELETE FROM notes WHERE sno = '$sno'";
  $result_delete = mysqli_query($con, $delete_sql);
}


if($_SERVER['REQUEST_METHOD'] == "POST"){
  if(isset($_POST['snoEdit'])){
    //update the record
    $sno = $_POST['snoEdit'];
    $title = $_POST['titleEdit'];
    $description = $_POST['descEdit'];

    //insert the data in table
    $sql = "UPDATE notes SET title = '$title', `description` = '$description' WHERE notes.sno = $sno";
    $result = mysqli_query($con, $sql);
      if($result){
        $update = true;
      }else{
          echo "We could not update the records successfully<br>";
      }
  }else{
    $title = $_POST['title'];
    $description = $_POST['desc'];

    //insert the data in table
    $sql = "INSERT INTO notes (title,`description`) VALUES ('$title','$description')";
    $result = mysqli_query($con, $sql);
    //check for the database insertion success
    if($result)
    {
        $insert = true;
    }
    else{
      echo " The record has not been inserted into table successfully beacuse of this error  ". mysqli_error($con);
    }  
  } 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  
  <title>Take Notes Easily</title>
  
</head>

<body>
  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/Crud/index.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label for="title">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>

            <div class="form-group">
              <label for="desc">Note Description</label>
              <textarea class="form-control" id="descEdit" name="descEdit" rows="3"></textarea>
            </div> 
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#"><img src="/crud/logo.svg" alt="logo" height="28px"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contacts Us</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" />
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
          Search
        </button>
      </form>
    </div>
  </nav>

<?php
if($insert == true){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          <strong>Success!</strong> You note has been  inserted successfully.
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
          </button>
</div>";
}
if($update == true){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          <strong>Success!</strong> You note has been updated successfully.
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
          </button>
</div>";
}
if($delete == true){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          <strong>Success!</strong> You note has been deleted successfully.
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
          </button>
</div>";
}
?>

  <div class="container my-4">
    <h2>Add a Note</h2>
    <form action="/Crud/index.php" method="POST">
      <div class="form-group">
        <label for="title">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" />
      </div>
      <div class="form-group">
        <label for="desc">Note Description</label>
        <textarea class="form-control" id="desc" name="desc" rows="5"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>

  <div class="container my-4">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Title</th>
          <th scope="col">Desciption</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
            //fetch the data
            $sql_select = "SELECT * FROM notes";
            $result_select = mysqli_query($con, $sql_select);
            $sno = 0;
            while($rows = mysqli_fetch_assoc($result_select))
            {
              $sno = $sno + 1;
                echo "<tr>
                        <th scope='row'>". $sno ."</th>
                        <td>". $rows['title'] ."</td>
                        <td>". $rows['description'] ."</td>
                        <td><button class='edit btn btn-sm btn-primary' id = ". $rows['sno'] .">Edit</button> 
                            <button class='delete btn btn-sm btn-primary' id = d". $rows['sno'] .">Delete</button> </td>
                      </tr>"; 
            }
            //actions to be added
            

        ?>

      </tbody>
    </table>
  </div>
<hr>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
  </script>
  <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script>
      $(document).ready( function () {
          $('#myTable').DataTable();
      } );
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element)=>{
      element.addEventListener("click", (e)=>{
        console.log("edit ", );
        tr =  e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        $('#editModal').modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element)=>{
      element.addEventListener("click", (e)=>{
        console.log("edit ", );
        sno = e.target.id.substr(1,);
        if(confirm("Are you sure want to delete this note?")){
          console.log("yes");
          window.location = `/Crud/index.php?delete=${sno}`;  
          // Create a form  and use post request to submit the form
        }else{
          console.log("no");
        }

      })
    })

  </script>
</body>

</html>