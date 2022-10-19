<!DOCTYPE html>
<html>

<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js">
    </script>
    <link rel="stylesheet" href="style.css">
</head>

<?php

error_reporting(E_ERROR | E_PARSE);

class
Input
{
    public $name;
    public $gender;
    public $faculty;
    public $dob;
    public $address;
    public $picture;
}

$input = new Input;
$errors = array();

$genders = array(
    "0" => "Nam",
    "1" => "Nữ"
);

$faculties = array(
    "MAT" => "Khoa học máy tính",
    "KDL" => "Khoa học vật liệu"
);

function console_log($data)
{
    $output = json_encode($data);

    echo "<script>console.log('{$output}' );</script>";
}

function is_valid_date_format($date, $format = 'd/m/Y')
{
    $dt = DateTime::createFromFormat($format, $date);

    return $dt && $dt->format($format) === $date;
}

function is_valid_picture()
{
    $allowed_image_extension = array(
        "png",
        "jpg",
        "jpeg"
    );

    $file_extension = pathinfo($_FILES["picture"]["name"], PATHINFO_EXTENSION);

    if (
        file_exists($_FILES["picture"]["tmp_name"])
        && !in_array($file_extension, $allowed_image_extension)
    ) {
        return false;
    }

    return true;
}

function validate()
{
    global $errors;

    if (empty($_POST["name"])) {
        array_push($errors, "Hãy nhập tên.");
    }

    if (empty($_POST["gender"])) {
        array_push($errors, "Hãy chọn giới tính.");
    }

    if (empty($_POST["faculty"])) {
        array_push($errors, "Hãy chọn phân khoa.");
    }

    if (empty($_POST["dob"])) {
        array_push($errors, "Hãy nhập ngày sinh.");
    } else if (!is_valid_date_format($_POST["dob"])) {
        array_push($errors, "Hãy nhập ngày sinh đúng định dạng.");
    }

    if (!is_valid_picture()) {
        array_push($errors, "Chỉ chấp nhận ảnh .png, .jpg và .jpeg.");
    }
}

function handle_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

if (isset($_POST['submit'])) {
    do {
        validate();

        if (!empty($errors)) {
            break;
        }

        foreach ($input as $key => $value) {
            $input->$key = handle_input($_POST[$key]);
        }

        session_start();

        $from = $_FILES["picture"]["tmp_name"];

        $file_extension = pathinfo($_FILES["picture"]["name"], PATHINFO_EXTENSION);
        $file_name = pathinfo($_FILES["picture"]["name"], PATHINFO_FILENAME);
        $file_date = date('YmdHis');

        if (!file_exists($file_path)) {
            mkdir("upload", 0770, true);
        }

        $destination = "upload/" . $file_name . "_" . $file_date . "." . $file_extension;
        move_uploaded_file($from, $destination);

        $input->picture = $destination;
        $_SESSION['input'] = $input;

        header('Location: confir.php');
    } while (0);
}

?>

<body>
<div class="body">
    <div class='form'>
        <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <div class="validation-errors">
                <?php
                foreach ($errors as $value) {
                    echo "<span class='error'>$value</span><br> ";
                }
                ?>
            </div>

            <div class="flex-start">
                <div for="name" class="label">
                    Họ và tên
                    <span class="error">*</span>
                </div>
                <input id="name" name="name" type='text' />
            </div>

            <div class="flex-start">
                <div class="label">
                    Giới tính
                    <span class="error">*</span>
                </div>
                <?php
                for ($i = 0; $i < count($genders); $i++) {
                    echo "<input type='radio' value='$genders[$i]' name='gender' />
                              <label> $genders[$i] </label>";
                }
                ?>
            </div>

            <div class="flex-start">
                <div class="label">
                    Phân khoa
                    <span class="error">*</span>
                </div>
                <select name="faculty">
                    <option value=""></option>
                    <?php
                    foreach ($faculties as $key => $value) {
                        echo "<option value='$key'>$value</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="flex-start">
                <div class="label">
                    Ngày sinh
                    <span class="error">*</span>
                </div>
                <input name="dob" type="text" class="date" placeholder="dd/mm/yyyy" />
            </div>

            <div class="flex-start">
                <div class="label">
                    Địa chỉ
                </div>
                <input name="address" type='text' />
            </div>

            <div class="flex-start">
                <div class="label" for="picture">
                    Hình ảnh
                </div>
                <input type="file" name="picture" id="picture"><br>
            </div>

            <div class="center">
                <input type='submit' name="submit" value="Đăng ký">
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(".date").datepicker({
        format: "dd/mm/yyyy",
    });
</script>

</body>

</html>