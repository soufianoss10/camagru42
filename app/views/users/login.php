<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row" >
    <div class="col-md-6 mx-auto">
         <div class="card card-body bg-light mt-4"> <h2>Login</h2>
         <?php flash('register_success'); ?>
         <?php flash('register_error'); ?>
            <p>Please fill in your infos to log in! </p>
            <form action="<?php echo URLROOT; ?>/users/login" method="POST">

                <div class="form-group" >
                    <label for="username">Username: <sup>*</sup> </label>
                    <input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($data['username_error'])) ? 'is-invalid' : ''; ?> " value="<?php echo $data['username'];?>" required> 
                    <span class="invalid-feedback"><?php echo $data['username_error']; ?></span>        
                </div>

                <div class="form-group mt-3" >
                    <label for="password">Password: <sup>*</sup> </label>
                    <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_error'])) ? 'is-invalid' : ''; ?> " value="<?php echo $data['password'];?>" required> 
                    <span class="invalid-feedback"><?php echo $data['password_error']; ?></span>      
                </div>

                <div class="row mt-3">
                    <div class= "col">
                        <input type="submit" value="Login" class="btn btn-success btn-block" >
                    </div>
                    <div class="col">
                    <a href="<?php echo URLROOT; ?>/users/forgetpassword" class="btn btn-light btn-block">Forget password? Resit it now</a>
                    </div>
                </div>
            </form>
         </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>