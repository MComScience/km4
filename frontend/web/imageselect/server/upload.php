<?php

session_start();

require 'ImgSelect.php';

$options = array(

    // Upload directory
    'upload_dir' => '../files/',

    // Accepted file types
    'accept_file_types' => 'png|jpg|jpeg|gif',

    // Directory mode
    'mkdir_mode' => 0777,

    // File max/min size in bytes
    'max_file_size' => null,
    'min_file_size' => 1,

    // Image size validation
    'max_width'  => null,
    'max_height' => null,
    'min_width'  => 1,
    'min_height' => 1,

    // If the image size < crop size then force the resize
    'force_crop' => true,
    // Crop max width
    'crop_max_width' => null,
    // Crop max height
    'crop_max_height' => null,

    /**
     * Before upload callback.
     *
     * @param stdClass $image Properties: name, type size
     */
    'before_upload' => function ($image) {
        // Set image name. By default the image will have the original name but
        // with a number at the end if already exits
        // You can set the name to the userID or something like that
        // $image->name = "my_image.".$image->type;
    },

    /**
     * Upload complete callback.
     *
     * @param stdClass $image Properties: name, type, size, path, url, width, height
     */
    'upload_complete' => function ($image) {
        // Here you can save the image to database
        // using $image->name to get the image name
    },

    /**
     * Before crop callback.
     *
     * @param stdClass $crop Properties: file_name, file_type, src_path, dst_path, src_h, src_w, src_y, src_x, dst_w, dst_h
     */
    'before_crop' => function ($crop) {
        // You can set the crop destionaton path so the original file will be keept
        // $filename = "my_image_cropped.".$crop->file_type;
        // $crop->dst_path = $instance->getUploadPath($filename);
    },

    /**
     * Crop complete callback
     *
     * @param stdClass $image Pproperties: name, type, path, url, width, height
     */
    'crop_complete' => function ($image) {
        // Here you can save the image to database,
        // using $image->name to get the image name
    }
);

new ImgSelect($options);

// $error_messages - array of error messages to be used instead of the default ones.
// See ImgSelect.php
// new ImgSelect($options, $error_messages);
