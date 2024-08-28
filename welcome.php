<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    exit;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Welcome - <?php $_SESSION['username']?></title>
  </head>
  <body>
    <?php require 'partials/_nav.php' ?>
    Welcome - <?php echo $_SESSION['username']?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>

<?php
    $servername = "localhost:3307";
    $username = "root"; // replace with your MySQL username
    $password = ""; // replace with your MySQL password
    $dbname = "Company"; // replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Add Employee
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $sql = "INSERT INTO employees (name, email, phone, address) VALUES ('$name', '$email', '$phone', '$address')";
        $conn->query($sql);
    }

    // Edit Employee
    if (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $sql = "UPDATE employees SET name='$name', email='$email', phone='$phone', address='$address' WHERE id=$id";
        $conn->query($sql);
    }

    // Delete Employee
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM employees WHERE id=$id";
        $conn->query($sql);
    }

    // Fetch Employees
    $sql = "SELECT * FROM employees";
    $result = $conn->query($sql);

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Employee Management</h2>

    <!-- Add Employee Form -->
    <form method="POST" class="mb-4">
        <div class="form-row">
            <div class="col">
                <input type="text" class="form-control" name="name" placeholder="Name" required>
            </div>
            <div class="col">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="col">
                <input type="text" class="form-control" name="phone" placeholder="Phone" required>
            </div>
            <div class="col">
                <input type="text" class="form-control" name="address" placeholder="Address" required>
            </div>
            <div class="col">
                <button type="submit" name="add" class="btn btn-primary">Add Employee</button>
            </div>
        </div>
    </form>

    <!-- Employee Table -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <form method="POST">
                    <td><input type="text" name="name" value="<?php echo $row['name']; ?>" class="form-control"></td>
                    <td><input type="email" name="email" value="<?php echo $row['email']; ?>" class="form-control"></td>
                    <td><input type="text" name="phone" value="<?php echo $row['phone']; ?>" class="form-control"></td>
                    <td><input type="text" name="address" value="<?php echo $row['address']; ?>" class="form-control"></td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="edit" class="btn btn-success">Edit</button>
                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>

