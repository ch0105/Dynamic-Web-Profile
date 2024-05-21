<?php
include 'config.php';

// Directory to upload images
$target_dir = __DIR__ . "/uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $errorMessage = '';

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $errorMessage .= "File is not an image. ";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $errorMessage .= "Sorry, file already exists. ";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        $errorMessage .= "Sorry, your file is too large. ";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $errorMessage .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>alert('$errorMessage');</script>";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $conn->real_escape_string("uploads/" . basename($_FILES["image"]["name"]));
            $title = $conn->real_escape_string($_POST['title']);
            $description = $conn->real_escape_string($_POST['description']);

            $sql = "INSERT INTO gallery (image, title, description) VALUES ('$image', '$title', '$description')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('New record created successfully');</script>";
            } else {
                echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
        }
    }
}

// Handle form submission to edit gallery item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $image = $_POST['current_image']; // Default to current image

    // If a new image is uploaded
    if (!empty($_FILES["image"]["name"])) {
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $errorMessage = '';

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $errorMessage .= "File is not an image. ";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $errorMessage .= "Sorry, file already exists. ";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            $errorMessage .= "Sorry, your file is too large. ";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $errorMessage .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "<script>alert('$errorMessage');</script>";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = $conn->real_escape_string("uploads/" . basename($_FILES["image"]["name"]));
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            }
        }
    }

    $sql = "UPDATE gallery SET image='$image', title='$title', description='$description' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Update success');</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM gallery WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Deleted success');</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Gallery</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/skins/color-1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div>
        <div class="aside">
            <div class="logo">
                <a href="#"><span>P</span>rofile</a>
            </div>
            <div class="nav-toggler">
                <span></span>
            </div>
            <ul class="nav">
                <li><a href="index.html" class="active"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="gallery.php"><i class="fa fa-image"></i> Gallery</a></li>
                <li><a href="blog.php"><i class="fa fa-briefcase"></i> Blog</a></li>
                <li><a href="contact.html"><i class="fa fa-comments"></i> Contact</a></li>
            </ul>
        </div>
    </div>
    <div class="main-content">
        <div class="gallery-main-content section"> 
            <div class="container">
                <div class="row">
                    <div class="section-title padd-15">
                        <a href="#" id="hamburger-menu" class="fa fa-bars"></a>
                        <h2>My Gallery</h2>
                    </div>
                </div>  
                <div class="gallery">
                    <?php
                    $sql = "SELECT * FROM gallery";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<div class="card">';
                            echo '<img src="' . $row["image"] . '" alt="' . $row["title"] . '">';
                            echo '<div class="container2">';
                            echo '<h4><b>' . $row["title"] . '</b></h4>';
                            echo '<p>' . $row["description"] . '</p>';
                            echo '<a href="gallery.php?edit=' . $row["id"] . '">Edit</a> | ';
                            echo '<a href="gallery.php?delete=' . $row["id"] . '">Delete</a>';
                            echo '</div></div>';
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </div>
                
                <div class="row">
                    <div class="contact-form padd-15">
                        <form method="post" action="gallery.php" enctype="multipart/form-data">
                            <div class="form-item col-12 padd-15">
                                <label for="image">Image:</label><br>
                                <input type="file" id="image" class="form-control" name="image"><br>
                            </div>
                            <div class="form-item col-6 padd-15">
                                <label for="title">Title:</label><br>
                                <input type="text" id="title" class="form-control" name="title"><br>
                            </div>
                            <div class="form-item col-6 padd-15">
                                <label for="description">Description:</label><br>
                                <input type="text" id="description" class="form-control" name="description"><br>
                            </div>
                            <div class="form-item col-12 padd-15">
                                <input type="submit" class="btn" name="add" value="Add">
                            </div>
                        </form>
                    </div>
                </div>

                <?php
                if (isset($_GET['edit'])) {
                    $id = $_GET['edit'];
                    $sql = "SELECT * FROM gallery WHERE id=$id";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    ?>
                    <h2>Edit Item</h2>
                    <form method="post" action="gallery.php" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $row['image']; ?>">
                        <label for="image">Image:</label><br>
                        <input type="file" id="image" name="image"><br>
                        <label for="title">Title:</label><br>
                        <input type="text" id="title" name="title" value="<?php echo $row['title']; ?>"><br>
                        <label for="description">Description:</label><br>
                        <input type="text" id="description" name="description" value="<?php echo $row['description']; ?>"><br>
                        <input type="submit" name="edit" value="Update">
                    </form>
                <?php
                }
                ?>

            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>

<?php
$conn->close();
?>
