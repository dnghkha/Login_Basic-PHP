<?php
session_start();
//check cookie login
if (isset($_COOKIE['auto_login']) && $_COOKIE['auto_login']) {
    $_SESSION['status_login'] = true;
}
//check session login
if (isset($_SESSION['status_login']) && $_SESSION['status_login']){
    header('location: home.php');
    exit;
}

//check form login
if (isset($_POST['user_name'], $_POST['password'])) {
    if ($_POST['user_name'] && $_POST['password']) {
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=users;', 'root', '');
        $resource = $pdo->prepare('select information.user_name, information.password 
                                from information 
                                where information.user_name =:user_name');
        $resource->execute(['user_name' => $_POST['user_name']]);
        $result = $resource->fetch(PDO::FETCH_ASSOC);
        $user_name = $result['user_name'] ?? '';
        $user_password = $result['password'] ?? '';
        if ($user_name == $_POST['user_name'] && $user_password == $_POST['password']) {
            if ($_POST['save_password'] == 1) {
                $time = time() + 60 * 15;
                setcookie('auto_login', true, $time);
                $_SESSION['status_login'] = true;
                header('location: home.php');
                exit();
            } else {
                $_SESSION['status_login'] = true;
                header('location: home.php');
                exit();
            }
        } else {
            $warning = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Tên đăng nhập hoặc mật khẩu không chính xác!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div><?= $warning ?? '' ?></div>
        <div class="row mt-5">
            <div class="col-3"></div>
            <div class="col-6 border bg-light mt-5">
                <div class="text-center mt-5">
                    <h1 class="font-weight-bold text-danger ">Đăng nhập</h1>
                </div>
                <div class="mt-5">
                    <form action="" method="POST">
                        <div class="form-group">
                            <input type="text" name="user_name" id="" class="form-control" placeholder="Tên đăng nhập" aria-describedby="helpId" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="" class="form-control" placeholder="Mật khẩu" aria-describedby="helpId" required>
                        </div>
                        <div class="form-check ml-1">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="save_password" id="" value="1">
                                Nhớ mật khẩu
                            </label>
                        </div>
                        <div class="text-center mt-2 mb-2">
                            <button type="submit" class="btn btn-primary">Đăng nhập</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <h6>hoặc</h3>
                    </div>
                    <div class="text-center mb-3">
                        <a class="btn btn-success" href="sign_up.php">Đăng ký</a>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>