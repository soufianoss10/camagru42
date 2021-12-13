
<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="col-md-6 mx-auto">
    <div class="card card-body p-3 mb-5 bg-white rounded mt-5 text-center">
		<?php flash('rest_success'); ?>
        <?php flash('rest_error'); ?>
            <h1><a class="blog-header-logo text-dark" href="<?php echo URLROOT ?>"></a></h1>
            <p><strong>Enter your email to reset password</strong></p>
            <form action="<?php echo URLROOT; ?>/users/forgetpassword" method="post">
                <div class="form-group mb-3 w-75 m-auto">
                    <input type="email" name="email" class="form-control form-control-lg 
                        <?php echo (!empty($data['email_error'])) ? 'is-invalid' : ''; ?>" placeholder="Email" value="<?php echo $data['email']; ?>">
                    <span class="invalid-feedback"><?php if (!empty($data['email_error'])) echo $data['email_error'] ?></span>
                </div>
                <div class="row mb-4 w-50 ml-5 m-auto">
                    <input type="submit" value="Reset password" class="btn btn-success btn-block">
                </div>
            </form>
        </div>
    </div>

	<?php require APPROOT . '/views/inc/footer.php'; ?>