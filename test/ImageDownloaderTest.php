<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxim
 * Date: 9/2/16
 * Time: 5:13 PM
 */
use Hexa\ImageDownloader;

class ImageDownloaderTest extends PHPUnit_Framework_TestCase
{
    public function testDownloadFile()
    {
        $downloader = new ImageDownloader('./tmp/');

        $result = $downloader->downloadImage('http://a.disquscdn.com/uploads/users/6459/1637/avatar92.jpg');
        if ($result) {
            print_r($result);
        } else {
            echo $downloader->error;
            $this->assertInternalType('string', $downloader->error);
        }

        array_map('unlink', glob("./tmp/*.*"));
        rmdir('./tmp/');
    }
}
