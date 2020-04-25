<?php
$filepath = 'temp.json';

if (isset($_POST['SubmitBtn'])) { //check if form was submitted
  $emp_count_open = fopen($filepath, "r");
  $emp_count = fread($emp_count_open, filesize($filepath));
  fclose($emp_count_open);
  $all_array123 = json_decode($emp_count, true);

  $current_array = array();
  $data['user_name'] = $_POST['name'];
  $data['mobile_no'] = $_POST['mobile'];
  $data['address'] = $_POST['address'];
  foreach ($all_array123 as $array_details) {
    array_push($current_array, $array_details);
  }
  array_push($current_array, $data);
  $data_string = json_encode($current_array);
  $myfile = fopen($filepath, "w") or die("Unable to open file!");
  fwrite($myfile, $data_string);
  $all_array = $current_array;
} else if (isset($_POST['editBtn'])) {
  $emp_count_open = fopen($filepath, "r");
  $emp_count = fread($emp_count_open, filesize($filepath));
  fclose($emp_count_open);
  $all_array123 = json_decode($emp_count, true);

  $current_array = array();
  $data['user_name'] = $_POST['name'];
  $data['mobile_no'] = $_POST['mobile'];
  $data['address'] = $_POST['address'];
  $location_id = $_POST['location_id'];
  $all_array123[$location_id] = $data;
  $data_string = json_encode($all_array123);
  $myfile = fopen($filepath, "w") or die("Unable to open file!");
  fwrite($myfile, $data_string);
  $all_array = $all_array123;
} else if (isset($_POST['Delete'])) {
  $emp_count_open = fopen($filepath, "r");
  $emp_count = fread($emp_count_open, filesize($filepath));
  fclose($emp_count_open);
  $all_array123 = json_decode($emp_count, true);

  $location_id = $_POST['location_delete'];
  unset($all_array123[$location_id]);
  $data_string = json_encode($all_array123);
  $myfile = fopen($filepath, "w") or die("Unable to open file!");
  fwrite($myfile, $data_string);
  $all_array = $all_array123;
} else {
  $emp_count_open = fopen('temp.json', "r");
  $emp_count = fread($emp_count_open, filesize('temp.json'));
  fclose($emp_count_open);
  $all_array = json_decode($emp_count, true);
}

function test($location)
{
  return  $location;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>

  <div class="container">
    <h2>Detail Table</h2>
    <div class="row">
      <div class="col-md-12 pull-right">
        <button type="button" class="pull-right btn btn-info" style="float: right;" data-toggle="modal" data-target="#myModal">Add</button>
      </div>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>address</th>
          <th>Mobile</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($all_array != NULL || $all_array != '') {
          foreach ($all_array as $key => $array_detail) {
        ?>
            <tr>
              <td><?php echo $array_detail['user_name']; ?></td>
              <td><?php echo $array_detail['address']; ?></td>
              <td><?php echo $array_detail['mobile_no']; ?></td>
              <td><button type="button" class="btn btn-info" onclick="show_record('<?php echo $key; ?>','<?php echo $array_detail['user_name']; ?>','<?php echo $array_detail['address']; ?>','<?php echo $array_detail['mobile_no']; ?>')">Edit</button>
                <form action="index.php" method="post" style="float:left;">
                  <input type="hidden" id="location_delete" name="location_delete" value="<?php echo $key; ?>">
                  <input type="submit" class="btn btn-danger" name="Delete" value="Delete">
                </form>
                <?php //echo $array_detail['mobile_no']; 
                ?>
              </td>
            </tr>
        <?php }
        } ?>
      </tbody>
    </table>
  </div>
  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="index.php" method="post">
          <!-- Modal body -->
          <div class="modal-body">

            <div class="form-group">
              <label for="email">Name:</label>
              <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name">
            </div>
            <div class="form-group">
              <label for="email">Mobile:</label>
              <input type="text" class="form-control" id="mobile" placeholder="Enter Mobile" name="mobile">
            </div>
            <div class="form-group">
              <label for="pwd">Address:</label>
              <input type="text" class="form-control" id="address" placeholder="Enter Address" name="address">
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <input type="submit" name="SubmitBtn" class="btn btn-success">
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- The Modal edit -->
  <div class="modal fade" id="editModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="index.php" method="post">
          <!-- Modal body -->
          <div class="modal-body">

            <div class="form-group">
              <label for="email">Name:</label>
              <input type="hidden" id="location_id" name="location_id">
              <input type="text" class="form-control" id="name_edit" placeholder="Enter Name" name="name">
            </div>
            <div class="form-group">
              <label for="email">Mobile:</label>
              <input type="text" class="form-control" id="mobile_edit" placeholder="Enter Mobile" name="mobile">
            </div>
            <div class="form-group">
              <label for="pwd">Address:</label>
              <input type="text" class="form-control" id="address_edit" placeholder="Enter Address" name="address">
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <input type="submit" name="editBtn" class="btn btn-success">
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    function show_record(key, name, address, mobile) {
      $('#location_id').val(key);
      $('#name_edit').val(name);
      $('#address_edit').val(address);
      $('#mobile_edit').val(mobile);
      $('#editModal').modal();
    }
  </script>
</body>

</html>