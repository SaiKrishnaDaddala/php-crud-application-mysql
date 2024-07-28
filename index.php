<?php
session_start();
include 'autoload.php';

$configFile = 'config.php';

if (file_exists($configFile)) {
    include $configFile;
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['db_details'])) {
        $db_host = $_POST['db_host'];
        $db_name = $_POST['db_name'];
        $db_user = $_POST['db_user'];
        $db_pass = $_POST['db_pass'];

        $configContent = "<?php\n";
        $configContent .= "\$db_host = '$db_host';\n";
        $configContent .= "\$db_name = '$db_name';\n";
        $configContent .= "\$db_user = '$db_user';\n";
        $configContent .= "\$db_pass = '$db_pass';\n";

        file_put_contents($configFile, $configContent);

        header("Location: index.php");
        exit;
    } else {
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Configuration</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 500px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Database Configuration</h2>
        <form method="post">
            <div class="mb-3">
                <label for="db_host" class="form-label">Database Host</label>
                <input type="text" class="form-control" id="db_host" name="db_host" required>
            </div>
            <div class="mb-3">
                <label for="db_name" class="form-label">Database Name</label>
                <input type="text" class="form-control" id="db_name" name="db_name" required>
            </div>
            <div class="mb-3">
                <label for="db_user" class="form-label">Database User</label>
                <input type="text" class="form-control" id="db_user" name="db_user" required>
            </div>
            <div class="mb-3">
                <label for="db_pass" class="form-label">Database Password</label>
                <input type="password" class="form-control" id="db_pass" name="db_pass" required>
            </div>
            <input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
            <button type="submit" name="db_details" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>';
        exit;
    }
}

$db = new Database($db_host, $db_name, $db_user, $db_pass);
$conn = $db->dbConnection();
$db->createTable();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD Application</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Manage <b>Users</b></h2></div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-primary add-new" data-bs-toggle="modal" data-bs-target="#addEmployeeModal"><i class="fa fa-plus"></i> Add New</button>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>Address</th>
                        <th>Job Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $conn->prepare("SELECT id, name, email, phone, city, address, job_title FROM users");
                    $stmt->execute();
                    $stmt->bind_result($id, $name, $email, $phone, $city, $address, $job_title);
                    while ($stmt->fetch()) {
                        echo "
                        <tr>
                            <td>{$id}</td>
                            <td>{$name}</td>
                            <td>{$email}</td>
                            <td>{$phone}</td>
                            <td>{$city}</td>
                            <td>{$address}</td>
                            <td>{$job_title}</td>
                            <td>
                                <a href='#' class='edit' data-bs-toggle='modal' data-bs-target='#editEmployeeModal' data-id='{$id}' data-name='{$name}' data-email='{$email}' data-phone='{$phone}' data-city='{$city}' data-address='{$address}' data-job_title='{$job_title}'><i class='fa fa-pencil' aria-hidden='true'></i></a>
                                <a href='#' class='delete' data-bs-toggle='modal' data-bs-target='#deleteEmployeeModal' data-id='{$id}'><i class='fa fa-trash' aria-hidden='true'></i></a>
                            </td>
                        </tr>
                        ";
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'components/add_modal.php'; ?>
    <?php include 'components/edit_modal.php'; ?>
    <?php include 'components/delete_modal.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="assets/ajax.js"></script>
</body>
</html>
