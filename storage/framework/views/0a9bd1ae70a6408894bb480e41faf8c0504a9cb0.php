<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
    <style>
        table td {
            padding: 10px;
            text-align: center;
        }
        .fa-trash-alt {
            color: red;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            background-color: #e0ffe0;
            color: green;
            border: 1px solid green;
        }
        .message.error {
            background-color: #ffe0e0;
            color: red;
            border: 1px solid red;
        }
        img {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.5/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<body>

    <form action="<?php echo e(url('upload')); ?>" method="POST" enctype="multipart/form-data" class="container mt-5">
    <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image">Choose an image to upload:</label>
                    <input type="file" name="image" id="image" class="form-control" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="image_url">Image URL:</label>
                    <input type="text" name="image_url" id="image_url" class="form-control" placeholder="Enter the image URL" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="key">Key:</label>
                    <input type="text" name="key" id="key" value="<?php echo e($randomKey); ?>" class="form-control" required readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="image_text">Image Text:</label>
                    <input type="text" name="image_text" id="image_text" class="form-control" placeholder="Enter the image text" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Upload</button>
    </form>


    <h1>Uploaded Images</h1>

    <table border="1" style="border-collapse:collapse; width: 100%; max-width: 80%; margin-top: 20px;">
        <thead>
            <tr>
                <th>S No.</th>
                <th>Key</th>
                <th>Image URL</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key + 1); ?></td>
                <td><?php echo e($value->key); ?></td>
                <td><?php echo e($value->image_url); ?></td>
                <td>
                    <form action="<?php echo e(route('image.delete', $value->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" style="border: none; background: none; cursor: pointer;">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fade out success message after 5 seconds
            setTimeout(function() {
                $('#success-message').fadeOut();
            }, 1000);

            // Fade out error message after 5 seconds
            setTimeout(function() {
                $('#error-message').fadeOut();
            }, 1000);
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Task\resources\views/view.blade.php ENDPATH**/ ?>