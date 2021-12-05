<?php require APPROOT . '/views/inc/header.php'; ?>
    <a href="<?php echo URLROOT; ?>/posts" class="btn btn-dark">Back</a>
         <div class="card card-body bg-light mt-4">
              <h2>Add Post</h2>
            <p>Create a post </p>
            <form action="<?php echo URLROOT; ?>/posts/add" method="POST" >

                <div class="form-group" >
                    <label for="title">Title: <sup>*</sup> </label>
                    <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_error'])) ? 'is-invalid' : ''; ?> " value="<?php echo $data['title'];?>" > 
                    <span class="invalid-feedback"><?php echo $data['title_error']; ?></span>        
                </div>

                <div class="form-group" >
                    <label for="body">Body: <sup>*</sup> </label>
                    <textarea name="body" class="form-control form-control-lg <?php echo (!empty($data['body_error'])) ? 'is-invalid' : ''; ?> "  ><?php echo $data['body'] ?></textarea> 
                    <span class="invalid-feedback"><?php echo $data['body_error']; ?></span>      
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit post</button>
                <!-- <input type="submit" class="btn btn-info" value="Submit post"> -->
            </form>
         </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>