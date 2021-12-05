<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-6">
    <h1>Posts</h1>
    </div>
    <div class="col-md-6">
        <a href="<?php echo URLROOT; ?>/posts/add" class="btn btn-primary pull-right">
        <i class="fa fa-pencil"> you</i>
        <!-- <button style="font-size:24px">Add post <i class="fa fa-pencil"></i></button> -->

    </a>
    </div>
</div>
 <?php foreach($data['posts'] as $post) : ?>
    <div class="card card-body mb-3">
        <h4 class="card-title"> <?php echo $post->title; ?></h4>
        <div class="bg-light p-2 mb-3">
            posted by <?php echo $post->name; ?> on  <?php echo $post->postCreated; ?>
        </div>
    </div>
<?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php';?>
