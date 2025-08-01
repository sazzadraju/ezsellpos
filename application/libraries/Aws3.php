<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include("./vendor/autoload.php");

use Aws\S3\S3Client;

class Aws3 {

    private $obj, $S3;

    public function __construct() {
        $this->obj = & get_instance();

        $this->obj->config->load('s3');

        $this->S3 = S3Client::factory([
                'version' => $this->obj->config->item('version'),
                'region' => $this->obj->config->item('region'),
                'credentials' => [
                    'key' => $this->obj->config->item('key'),
                    'secret' => $this->obj->config->item('secret'),
                ]
        ]);
    }
    
    public function chkBucketExists($bucket){
        
        return $this->S3->doesBucketExist($bucket);
    }

    public function addBucket($bucket) {
        if(!$this->chkBucketExists($bucket)){
            $result = $this->S3->createBucket(
                array(
                    'Bucket' => $bucket,
                    'endpoint' => 's3.amazonaws.com',
                )
            );

            return $result;
        }
        
        return false;
    }

    public function sendFile($bucket, $filepath, $filename) {
        $object = array(
            'Bucket'        => $bucket,
            'Key'           => $filepath,
            'SourceFile'    => $filename,
            'ContentType'   => 'image/png',
            'StorageClass'  => 'STANDARD',
            'ACL'           => 'public-read'
        );
        
        $result = $this->S3->putObject($object);
        return $result['ObjectURL'];
    }

    public function deleteFile($bucket, $filepath, $filename) {
        $result = $this->S3->deleteObject(array(
            'Bucket' => $bucket,
            'Key'    => $filepath.'/'.$filename
        ));
        
        return $result;
    }
    

    public function getFolderSize($bucket, $folder = '') {
        
        $objects = $this->S3->getIterator('ListObjects', array(
            "Bucket" => $bucket,
            "Prefix" => $folder
        ));

        $size = 0;
        foreach ($objects as $object) {
            $size += $object['Size'];
        }

        return format_size_units($size);  // from common_helper
    }

}
