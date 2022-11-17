<?php
if (isset($_POST['name'], $_POST['user_name'], $_POST['password'], $_POST['password_confirm'], $_POST['email'], $_POST['phone'])) {
    if ($_POST['name'] && $_POST['user_name'] && $_POST['password'] && $_POST['password_confirm'] && $_POST['email'] && $_POST['phone']) {
        if ($_POST['password'] == $_POST['password_confirm']) {
            try {
                $pdo = new PDO('mysql:host=localhost;port=3306;dbname=users;', 'root', '');
                $sql = 'select information.user_name
                        from information
                        where information.user_name =:user_name';
                $resource = $pdo->prepare($sql);
                $resource->execute(['user_name' => $_POST['user_name']]);
                $result = $resource->fetch(PDO::FETCH_ASSOC);
                $user_exist = $result['user_name'] ?? '';
                if ($user_exist == $_POST['user_name']) {
                    $warning = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Tài khoản đã tồn tại!</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                } else {
                    $user_id = 'user' . time();
                    $pdo->exec("
                                insert into information(user_id, name, user_name, password, email, phone) 
                                values('$user_id', '$_POST[name]', '$_POST[user_name]','$_POST[password]','$_POST[email]','$_POST[phone]')
                                ");
                    echo 'success!';
                }
                $pdo = null;
            } catch (PDOException $e) {
                echo 'server error: ';
            }
        }
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Sign Up</title>
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
                    <h1 class="font-weight-bold text-danger ">Đăng ký</h1>
                </div>
                <div class="mt-5">
                    <form action="" method="POST">
                        <div class="form-group">
                            <input type="text" name="name" id="" class="form-control" placeholder="Họ và tên" aria-describedby="helpId" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="user_name" id="" class="form-control" placeholder="Tên đăng nhập" aria-describedby="helpId" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="" class="form-control" placeholder="Mật khẩu" aria-describedby="helpId" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password_confirm" id="" class="form-control" placeholder="Nhập lại mật khẩu" aria-describedby="helpId" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" id="" class="form-control" placeholder="Email" aria-describedby="helpId" required>
                        </div>
                        <div class="form-group">
                            <input type="number" name="phone" id="" class="form-control" placeholder="Số điện thoại" aria-describedby="helpId" required>
                        </div>
                        <div class="text-center mt-2 mb-3">
                            <button type="submit" class="btn btn-primary">Đăng ký</button>
                        </div>
                    </form>
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