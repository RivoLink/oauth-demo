
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>OAuth Demo - Sign In</title>

        <link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="/assets/css/style.css" />
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card border-0 shadow rounded-3 my-5">
                        <div class="card-body p-4 p-sm-5">
                            <div class="loader d-none">
                                <div class="spinner-border text-dark" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <h5 class="card-title text-center mb-5 fw-bold fs-5">OAuth Demo - Sign In</h5>
                            <form method="POST" autocomplete="off">
                                <div class="form-floating mb-3">
                                    <input type="email" name="email" class="form-control" id="si-email" placeholder="name@example.com" />
                                    <label for="si-email">Email</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" autocomplete="new-password" name="password" class="form-control" id="si-password" placeholder="Password" />
                                    <label for="si-password">Password</label>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-dark btn-login fw-bold" type="submit">Sign in</button>
                                </div>
                                <hr class="my-4" />
                                <div class="d-grid mb-2">
                                    <button class="btn btn-google btn-login fw-bold" type="submit"><i class="fab fa-google me-2"></i> Sign in with Google</button>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-facebook btn-login fw-bold" type="submit"><i class="fab fa-facebook-f me-2"></i> Sign in with Facebook</button>
                                </div>
                                <div class="d-grid text-center mt-2">
                                    <small>New on OAuth Demo, <a href="/sign-up">Sign up</a></small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="/assets/plugins/jquery/jquery.min.js"></script>
        <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="https://connect.facebook.net/en_US/sdk.js" crossorigin="anonymous" async defer></script>

        <script src="/assets/js/script.js"></script>
        <script src="/assets/js/sign-in.js"></script>

        <script>
            window.fbAsyncInit = function () {
                FB.init({
                    appId: "<?=$app_id?>",
                    version: "<?=$app_version?>",
                    cookie: true,
                    xfbml: true,
                });
            };
        </script>
    </body>
</html>
