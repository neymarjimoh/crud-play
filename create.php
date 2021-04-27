<?php
// Include config file
require_once "connection.php";
 
// Define variables and initialize with empty values
$title = $course_code = "";
$title_err = $course_code_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Please enter a title.";
    } elseif (!filter_var($input_title, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $title_err = "Please enter a valid title.";
    } else {
        $title = $input_title;
    }
    
    // Validate course code
    $input_course_code = trim($_POST["course_code"]);
    if(empty($input_course_code)){
        $course_code_err = "Please enter the course code.";     
    } else{
        $course_code = $input_course_code;
    }
    
    if(empty($title_err) && empty($address_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO courses (title, course_code) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            $param_title = $title;
            $param_course_code = $course_code;
            mysqli_stmt_bind_param($stmt, "ss", $param_title, $param_course_code);            
            
            if(mysqli_stmt_execute($stmt)){
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Add A Course</h2>
                    <p>Please fill this form and submit to add a course to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                            <span class="invalid-feedback"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Course Code</label>
                            <textarea name="course_code" class="form-control <?php echo (!empty($course_code_err)) ? 'is-invalid' : ''; ?>"><?php echo $course_code; ?></textarea>
                            <span class="invalid-feedback"><?php echo $course_code_err;?></span>
                        </div>
                        
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
