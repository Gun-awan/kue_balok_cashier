
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{

            background:#f4f4f4;

            min-height:100vh;

            display:flex;
            justify-content:center;
            align-items:center;

            font-family:Arial,sans-serif;

        }

        .card-login{

            width:100%;
            max-width:380px;

            background:white;

            border-radius:25px;

            padding:30px;

            box-shadow:0 5px 15px rgba(0,0,0,0.08);

        }

        .logo-login{

            width:80px;
            height:80px;

            border-radius:20px;

            /* background:#0d6efd; */

            color:white;

            display:flex;
            justify-content:center;
            align-items:center;

            margin:auto;
            /* margin-bottom:20px; */

            font-size:35px;

        }

        .form-control{

            height:50px;

            border-radius:15px;

        }

        .btn-login{

            height:50px;

            border-radius:15px;

            font-weight:bold;

        }

    </style>

</head>

<body>

<div class="card-login">

    <!-- LOGO -->
    <div class="logo-login">

    <img style="width: 100px; height:100px;" src="../assets/logo.png">

        <!-- <i class="bi bi-shop"></i> -->

    </div>

    <!-- TITLE -->
    <div class="text-center mb-5 mt-2">

        <h4 class="mb-0" style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
            Cashier Managemant System
        </h4>

        <small class="text-muted" style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-style:italic;">
            "Make it easy your transaction"
        </small>

    </div>

    <!-- ALERT -->
    <?php if(isset($_GET['error'])){ ?>

        <div class="alert alert-danger">

            Username atau password salah

        </div>

    <?php } ?>

    <!-- FORM -->
    <form action="proses/proses_login.php" method="POST">

        <!-- USERNAME -->
        <div class="mb-3">

            <label class="form-label">
                Username
            </label>

            <input
                type="text"
                name="username"
                class="form-control"
                required
            >

        </div>

        <!-- PASSWORD -->
        <div class="mb-4">

            <label class="form-label">
                Password
            </label>

            <input
                type="password"
                name="password"
                class="form-control"
                required
            >

        </div>

        <!-- BUTTON -->
        <button class="btn btn-primary btn-login w-100">

            Login

        </button>

    </form>

</div>

</body>
</html>