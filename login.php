<?php
session_start();
require_once 'init.php';
require_once 'login-handler.php';


$inputs = $_SESSION['inputs']?? [];
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['inputs'], $_SESSION['errors']);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.2/css/all.min.css">
    <title> ITTHINK-APP</title>
</head>

<body>
    <section class="vh-100">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black " style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Login </p>

                                    <!-- Form Start-->
                                    <form class="mx-1 mx-md-4" method="POST" action="login.php">

                                        <!-- User Email -->
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="email">Your Email</label>
                                                <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= htmlspecialchars($inputs['email'] ?? '') ?>">
                                                <?php if (isset($errors['email'])): ?>
                                                    <div class="invalid-feedback"><?= $errors['email'] ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <!-- User Email -->

                                        <!-- User Password -->
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="password">Password</label>
                                                <input type="password"
                                                    class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                                                    id="password"
                                                    name="password">
                                                <?php if (isset($errors['password'])): ?>
                                                    <div class="invalid-feedback"><?= $errors['password'] ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <!-- User Password -->
                                        <?php if (isset($errors['general'])): ?>
                                            <div class="alert alert-danger" role="alert" data-mdb-color="danger" data-mdb-alert-init="" data-mdb-alert-initialized="true">
                                                <i class="fas fa-times-circle me-3"></i>
                                                <?= $errors['general'] ?>
                                            </div>
                                        <?php endif; ?>
                                        <!--Register Button-->
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit"
                                                class="btn btn-primary btn-lg" name="login">Login</button>
                                        </div>
                                        <!--Register Button-->

                                        <!-- Login link -->
                                        <p class="text-center text-muted mt-5 mb-0">Don't Have an account?
                                            <a href="register.php" class="fw-bold text-body"><u>Register here</u></a>
                                        </p>
                                        <!-- Login link -->

                                    </form>
                                    <!-- Form END-->

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                                        class="img-fluid" alt="Sample image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>