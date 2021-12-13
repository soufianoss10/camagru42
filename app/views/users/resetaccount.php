<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="col-md-6 mx-auto">
        <div class="card card-body shadow p-3 mb-5 bg-white rounded mt-5 text-center">
            <h1><a class="blog-header-logo text-dark" href="<?php echo URLROOT ?>"></a></h1>
            <p><strong>Enter your new password</strong></p>
            <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="post">
                <div class="form-group mb-3 w-75 m-auto">
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="New password">
                </div>
                <div class="row mb-4 w-75 ml-5 m-auto">
                    <input type="submit" value="Reset" class="btn btn-primary btn-block bg-dark">
                </div>
            </form>
        </div>
    </div>

	<?php require APPROOT . '/views/inc/footer.php'; ?>