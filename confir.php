<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<?php

error_reporting(E_ERROR | E_PARSE);

class Input
{
    public $name;
    public $gender;
    public $faculty;
    public $dob;
    public $address;
    public $picture;
}

function console_log($data)
{
    $output = json_encode($data);

    echo "<script>console.log('{$output}' );</script>";
}

session_start();
$input = new Input;
if (isset($_SESSION['input'])) {
    $input = $_SESSION['input'];
}

if (isset($_POST['confirm'])) {
    header('Location: 
    
    index.php');
}

?>

<body>
    <div class="body">
        <div class='form'>
            <form method="post">
                <div class="flex-start">
                    <div for="name" class="label">
                        Họ và tên
                    </div>
                    <div class="text ml-20">
                        <?= $input->name ?>
                    </div>
                </div>

                <div class="flex-start">
                    <div class="label">
                        Giới tính
                    </div>
                    <div class="text ml-20">
                        <?= $input->gender ?>
                    </div>
                </div>

                <div class="flex-start">
                    <div class="label">
                        Phân khoa
                    </div>
                    <div class="text ml-20">
                        <?= $input->faculty ?>
                    </div>
                </div>

                <div class="flex-start">
                    <div class="label">
                        Ngày sinh
                    </div>
                    <div class="text ml-20">
                        <?= $input->dob ?>
                    </div>
                </div>

                <div class="flex-start">
                    <div class="label">
                        Địa chỉ
                    </div>
                    <div class="text ml-20">
                        <?= $input->address ?>
                    </div>
                </div>

                <div class="flex-start">
                    <div class="label mh-25">
                        Hình ảnh
                    </div>
                    <img class="ml-20" src="<?php echo $input->picture ?>" alt="picture" />
                </div>

                <div class="center mt-50">
                    <input type='submit' name="confirm" value="Xác nhận">
                </div>
            </form>
        </div>
    </div>
</body>

</html>