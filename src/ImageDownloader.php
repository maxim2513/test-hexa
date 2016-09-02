<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxim
 * Date: 9/2/16
 * Time: 5:00 PM
 */

namespace Hexa;

use Exception;
use finfo;
use FilesystemIterator;

/**
 * Class ImageDownloader
 * @package Hexa
 */
class ImageDownloader
{
    /**
     * @var string
     */
    public $error = '';

    /**
     * @var mixed|string
     */
    private $save_folder = 'tmp/';

    /**
     * @var array
     */
    private $types = ['image/gif', 'image/jpeg', 'image/png'];


    /**
     * ImageDownloader constructor.
     * @param string $config   
     */
    public function __construct($config='')
    {
        if (!empty($config)) {
            $this->save_folder = $config;
        }
    }

    /**
     * @param $url
     * @return int|string url to image
     */
    public function downloadImage($url)
    {
        try {
            if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
                throw new Exception('Not a valid URL!!');
            }
            
            if (!is_dir($this->save_folder)) {
                mkdir($this->save_folder);
            }
            
            $image = file_get_contents($url);
            $this->checkType($image);
            
            $file_prefix = iterator_count(new FilesystemIterator($this->save_folder, FilesystemIterator::SKIP_DOTS)) + 1;
            $path_file = $this->save_folder . $file_prefix . '--' . basename(parse_url($url, PHP_URL_PATH));

            file_put_contents($path_file, $image);

            return 'File save to ' . $path_file;
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return 0;
        }
    }


    /**
     * check image type
     * @param $image
     * @throws Exception
     */
    private function checkType($image)
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $type = $finfo->buffer($image);
        if (!in_array($type, $this->types)) {
            throw new Exception('Wrong file type!!');
        }
    }

}