<?php

class ImgSelect
{
    protected $options;

    protected $errorMessages = array(
        // http://www.php.net/manual/en/features.file-upload.errors.php
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk',
        8 => 'A PHP extension stopped the file upload',
        'post_max_size' => 'The uploaded file exceeds the post_max_size directive in php.ini',
        'max_file_size' => 'File is too big',
        'min_file_size' => 'File is too small',
        'accept_file_types' => 'Filetype not allowed',
        'max_width'  => 'Image exceeds maximum width of ',
        'min_width'  => 'Image requires a minimum width of ',
        'max_height' => 'Image exceeds maximum height of ',
        'min_height' => 'Image requires a minimum height of ',
        'upload_failed' => 'Failed to upload the file',
        'move_failed' => 'Failed to upload the file',
        'invalid_image' => 'Invalid image',
        'image_resize' => 'Failed to resize image',
        'not_exists' => 'Failed to load the image'
    );

    /**
     * Create a new instance.
     *
     * @param  array|null $options
     * @param  array|null $errorMessages
     * @return void
     */
    function __construct($options = null, $errorMessages = null)
    {
        $this->options = array(
            // Upload directory
            'upload_dir' => 'files/',

            // Accepted file types
            'accept_file_types' => 'png|jpg|jpeg|gif',

            // Directory mode
            'mkdir_mode' => 0755,

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
        );

        if ($options) {
            $this->options = $options + $this->options;
        }

        if ($errorMessages) {
            $this->errorMessages = $errorMessages + $this->errorMessages;
        }

        $this->initialize();
    }

    /**
     * Initialize upload and crop actions.
     *
     * @return void
     */
    protected function initialize()
    {
        switch (@$_POST['action']) {
            case 'upload':
                $this->upload();
                break;
            case 'crop':
                $this->crop();
                break;
        }

        if (isset($this->error)) {
            $this->generateResponse($this->error, false);
        }
    }

    /**
     * Upload action.
     *
     * @return void
     */
    protected function upload()
    {
        $upload = null;

        if (isset($_FILES['file'])) {
            $upload = $_FILES['file'];
        } elseif (isset($_POST['file'])) {
            $upload['tmp_name'] = base64_decode($_POST['file']);
            $upload['name'] = mt_rand().'.png';
        }

        $file = $this->handleFileUpload(
            $upload['tmp_name'],
            $upload['name'],
            isset($upload['size']) ? $upload['size'] : strlen(@$upload['tmp_name']),
            isset($upload['error']) ? $upload['error'] : null
        );

        if ($file) {
            $this->generateResponse($file);
        }
    }

    /**
     * Handle file upload.
     *
     * @param  string  $uploadedFile
     * @param  string  $name
     * @param  integer $size
     * @param  string  $error
     * @return stdClass
     */
    protected function handleFileUpload($uploadedFile, $name, $size, $error)
    {
        $file = new stdClass();
        $file->name = $this->getFilename($name);
        $file->type = $this->getFileExtension($file->name);
        $file->size = $this->fixIntOverflow(intval($size));

        // Before upload callback.
        if (isset($this->options['before_upload'])) {
            call_user_func($this->options['before_upload'], $file, $this);
        }

        $uploadPath = $this->getUploadPath($file->name);
        $uploadDir = $this->getUploadPath();

        if (! $this->validate($uploadedFile, $file, $error)) {
            return false;
        }

        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, $this->options['mkdir_mode'], true);
        }

        if (is_uploaded_file($uploadedFile)) {
            if (! move_uploaded_file($uploadedFile, $uploadPath)) {
                $this->error = $this->getErrorMessage('move_failed');
                return false;
            }
        } else {
            if (! $handle = fopen($uploadPath , 'wb')) {
                $this->error = $this->getErrorMessage('upload_failed');
                return false;
            }

            if (! fwrite($handle, $uploadedFile)) {
                $this->error = $this->getErrorMessage('upload_failed');
                return false;
            }

            fclose($handle);
        }

        $this->orientImage($uploadPath);

        list($imgWidth, $imgHeight) = getimagesize($uploadPath);

        $file->path   = $uploadPath;
        $file->url    = $this->getFullUrl() .'/'. $uploadPath;
        $file->width  = $imgWidth;
        $file->height = $imgHeight;

        // Upload complete callback.
        if (isset($this->options['upload_complete'])) {
            call_user_func($this->options['upload_complete'], $file, $this);
        }

        unset($file->path);

        return $file;
    }

    /**
     * Validate image.
     *
     * @param  string   $uploadedFile
     * @param  stdClass $name
     * @param  string   $error
     * @return boolean
     */
    protected function validate($uploadedFile, $file, $error)
    {
        if (! $uploadedFile) {
            $this->error = $this->getErrorMessage(4);
            return false;
        }

        if ($error) {
            $this->error = $this->getErrorMessage($error);
            return false;
        }

        $contentLength = $this->fixIntOverflow(intval($_SERVER['CONTENT_LENGTH']));
        $postMaxSize  = $this->getConfigBytes(ini_get('post_max_size'));

        if ($postMaxSize && $contentLength > $postMaxSize) {
            $this->error = $this->getErrorMessage('post_max_size');
            return false;
        }

        if ($this->options['max_file_size'] && $file->size > $this->options['max_file_size']) {
            $this->error = $this->getErrorMessage('max_file_size');
            return false;
        }

        if ($this->options['min_file_size'] && $file->size < $this->options['min_file_size']) {
            $this->error = $this->getErrorMessage('min_file_size');
            return false;
        }

        if (! preg_match('/.('.$this->options['accept_file_types'].')+$/i', $file->name)) {
            $this->error = $this->getErrorMessage('accept_file_types');
            return false;
        }

        $maxWidth  = @$this->options['max_width'];
        $maxHeight = @$this->options['max_height'];
        $minWidth  = @$this->options['min_width'];
        $minHeight = @$this->options['min_height'];

        if ($maxWidth || $maxHeight || $minWidth || $minHeight) {
            if (is_uploaded_file($uploadedFile)) {
                list($imgWidth, $imgHeight) = getimagesize($uploadedFile);
            } else {
                $img = @imagecreatefromstring($uploadedFile);
                $imgWidth  = @imagesx($img);
                $imgHeight = @imagesy($img);
            }
        }

        if (! empty($imgWidth)) {
            if ($maxWidth && $imgWidth > $maxWidth) {
                $this->error = $this->getErrorMessage('max_width').$maxWidth.'px';
                return false;
            }
            if ($maxHeight && $imgHeight > $maxHeight) {
                $this->error = $this->getErrorMessage('max_height').$maxHeight.'px';
                return false;
            }
            if ($minWidth && $imgWidth < $minWidth) {
                $this->error = $this->getErrorMessage('min_width').$minWidth.'px';
                return false;
            }
            if ($minHeight && $imgHeight < $minHeight) {
                $this->error = $this->getErrorMessage('min_height').$minHeight.'px';
                return false;
            }
        } else {
            $this->error = $this->getErrorMessage('invalid_image');
            return false;
        }

        return true;
    }

    /**
     * Crop action.
     *
     * @return void
     */
    protected function crop()
    {
        $crop = new stdClass();

        $crop->file_name = basename(@$_POST['image']);
        $crop->file_type = $this->getFileExtension($crop->file_name);

        $crop->src_path = $this->getUploadPath($crop->file_name);
        $crop->dst_path = $crop->src_path;

        if (! file_exists($crop->src_path)) {
            $this->error = $this->getErrorMessage('not_exists');
            return false;
        }

        if (! preg_match('/.('.$this->options['accept_file_types'].')+$/i', $crop->file_name)) {
            $this->error = $this->getErrorMessage('accept_file_types');
            return false;
        }

        @list($crop->src_x, $crop->src_y, $x2, $y2, $crop->src_w, $crop->src_h) = @array_values(@$_POST['coords']);

        if (empty($crop->src_w) || empty($crop->src_h)) {
            list($crop->src_w, $crop->src_h) = getimagesize($crop->src_path);
            $min = min($crop->src_w, $crop->src_h);

            if (empty($crop->src_x) && empty($crop->src_y)) {
                $crop->src_x = ($crop->src_w - $min)/2;
                $crop->src_y = ($crop->src_h - $min)/2;
            }

            $crop->src_w = $crop->src_h = $min;
        }

        $crop->dst_w = $crop->src_w;
        $crop->dst_h = $crop->src_h;

        $maxWidth  = $this->options['crop_max_width'];
        $maxHeight = $this->options['crop_max_height'];

        if (! empty($maxWidth)) {
            if ( ($crop->src_w > $maxWidth) || ($crop->src_w < $maxWidth && $this->options['force_crop']) ) {
                $crop->dst_w = $maxWidth;
                $crop->dst_h = $crop->src_h / $crop->src_w * $maxWidth;
            }
        }

        if (! empty($maxHeight)) {
            if ( ($crop->src_h > $maxHeight) || ($crop->src_h < $maxHeight && $this->options['force_crop']) ) {
                $crop->dst_h = $maxHeight;
                $crop->dst_w = $crop->src_w / $crop->src_h * $maxHeight;
            }
        }

        // Before crop callback.
        if (isset($this->options['before_crop'])) {
            call_user_func($this->options['before_crop'], $crop, $this);
        }

        $this->resizeImage($crop->src_path, $crop->dst_path, $crop->src_x, $crop->src_y,
                    $crop->dst_w, $crop->dst_h, $crop->src_w, $crop->src_h);

        $image = new stdClass();
        $image->name = $crop->file_name;
        $image->url  = $this->getFullUrl() .'/'. $crop->dst_path;
        $image->path = $crop->dst_path;
        $image->type = $crop->file_type;
        $image->width  = ceil($crop->dst_w);
        $image->height = ceil($crop->dst_h);

        // Crop complete callback.
        if (isset($this->options['crop_complete'])) {
            call_user_func($this->options['crop_complete'], $image, $this);
        }

        unset($image->path);

        // Generate json response.
        $this->generateResponse($image);
    }

    /**
     * Resize image.
     *
     * @param  string      $srcPath Source image path
     * @param  string|null $dstPath Destination image path
     * @param  integer     $srcX    x-coordinate of source point
     * @param  integer     $srcY    y-coordinate of source point
     * @param  integer     $dstW    Destination width
     * @param  integer     $dstH    Destination height
     * @param  integer     $srcW    Source width
     * @param  integer     $srcH    Source height
     * @return void
     */
    public function resizeImage($srcPath, $dstPath = null, $srcX, $srcY, $dstW, $dstH, $srcW, $srcH)
    {
        $srcX = ceil($srcX);
        $srcY = ceil($srcY);
        $dstW = ceil($dstW);
        $dstH = ceil($dstH);
        $srcW = ceil($srcW);
        $srcH = ceil($srcH);

        $dstPath  = ($dstPath) ? $dstPath : $srcPath;
        $dstImage = imagecreatetruecolor($dstW, $dstH);
        $extension = $this->getFileExtension($srcPath);

        switch ($extension) {
            case 'gif':
                $srcImage = imagecreatefromgif($srcPath);
                break;
            case 'jpeg':
            case 'jpg':
                $srcImage = imagecreatefromjpeg($srcPath);
                break;
            case 'png':
                imagealphablending($dstImage, false);
                imagesavealpha($dstImage, true);
                $srcImage = imagecreatefrompng($srcPath);
                imagealphablending($srcImage, true);
                break;
        }

        imagecopyresampled($dstImage, $srcImage, 0, 0, $srcX, $srcY, $dstW, $dstH, $srcW, $srcH);

        switch ($extension) {
             case 'gif':
                imagegif($dstImage, $dstPath);
                break;
            case 'jpeg':
            case 'jpg':
                imagejpeg($dstImage, $dstPath);
                break;
            case 'png':
                imagepng($dstImage, $dstPath);
                break;
        }
    }

    /**
     * Rotate image based on EXIF orientation data.
     *
     * @param  string $filepath
     * @return void
     */
    protected function orientImage($filepath)
    {
        if (! function_exists('exif_read_data')) return;
        if (! preg_match('/\.(jpe?g)$/i', $filepath)) return;

        $exif = @exif_read_data($filepath);

        if (! empty($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 3: $degrees = 180; break;
                case 6: $degrees = -90; break;
                case 8: $degrees = 90;  break;
            }

            if (isset($degrees)) {
                $source = imagecreatefromjpeg($filepath);
                $image = imagerotate($source, $degrees, 0);
                imagejpeg($image, $filepath, 90);
                imagedestroy($image);
            }
        }
    }

    /**
     * Get upload directory path.
     *
     * @param  string $filename
     * @return string
     */
    public function getUploadPath($filename = '')
    {
        return $this->options['upload_dir'].$filename;
    }

    /**
     * Get upload directory url.
     *
     * @return string
     */
    public function getFullUrl()
    {
        $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        return
            ($https ? 'https://' : 'http://').
            (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
            (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
            ($https && $_SERVER['SERVER_PORT'] === 443 ||
            $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
            substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }

    /**
     * Get file name.
     *
     * @return string
     */
    public function getFilename($name)
    {
        return $this->getUniqueFilename($name);
    }

    /**
     * Get unique file name.
     *
     * @param  string
     * @return string
     */
    public function getUniqueFilename($name)
    {
        while (is_dir($this->getUploadPath($name))) {
            $name = $this->upcountName($name);
        }

        while (is_file($this->getUploadPath($name))) {
            $name = $this->upcountName($name);
        }

        return $name;
    }

    public function upcountName($name)
    {
        return preg_replace_callback(
            '/(?:(?: \(([\d]+)\))?(\.[^.]+))?$/',
            array($this, 'upcountNameCallback'),
            $name,
            1
        );
    }

    public function upcountNameCallback($matches)
    {
        $index = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
        $ext = isset($matches[2]) ? $matches[2] : '';
        return ' ('.$index.')'.$ext;
    }

    public function getFileExtension($filename)
    {
        return pathinfo(strtolower($filename), PATHINFO_EXTENSION);
    }

    public function generateResponse($data = array(), $success = true)
    {
        echo json_encode(array('success' => $success, 'data' => $data));
    }

    public function getErrorMessage($error)
    {
        return array_key_exists($error, $this->errorMessages) ?
            $this->errorMessages[$error] : $error;
    }

    public function getConfigBytes($val)
    {
        $val  = trim($val);
        $last = strtolower($val[strlen($val)-1]);

        switch($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $this->fixIntOverflow($val);
    }

    public function fixIntOverflow($size)
    {
        if ($size < 0) {
            $size += 2.0 * (PHP_INT_MAX + 1);
        }

        return $size;
    }
}
