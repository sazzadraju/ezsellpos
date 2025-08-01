<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include("./vendor/autoload.php");

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class DigitalOcean {

    private $obj, $S3;

    public function __construct() {
        $this->obj = & get_instance();

        $this->obj->config->load('digitalocean');

        $this->S3 = S3Client::factory([
                'version' => $this->obj->config->item('digitalocean_version'),
                'region' => $this->obj->config->item('digitalocean_region'),
                'endpoint' => $this->obj->config->item('digitalocean_endpoint'), // DigitalOcean Spaces endpoint
                'credentials' => [
                    'key' => $this->obj->config->item('digitalocean_key'),
                    'secret' => $this->obj->config->item('digitalocean_secret'),
                ]
        ]);
    }
    
    public function chkBucketExists($bucket) {
        try {
            return $this->S3->doesBucketExist($bucket);
        } catch (AwsException $e) {
            echo 'Error checking bucket existence: ' . $e->getMessage();
            exit;
            return false;
        } catch (\Guzzle\Common\Exception\InvalidArgumentException $e) {
            echo 'Error checking bucket existence: ' . $e->getMessage();
            exit;
            return false;
        }
    }

    public function addBucket($bucket) {
        try {
            if (!$this->chkBucketExists($bucket)) {
                $result = $this->S3->createBucket([
                    'Bucket' => $bucket
                ]);

                return $result;
            }
            return false;
        } catch (AwsException $e) {
            echo 'Error creating bucket: ' . $e->getMessage();
            return false;
        } catch (\Guzzle\Common\Exception\InvalidArgumentException $e) {
            echo 'Error checking bucket existence: ' . $e->getMessage();
            return false;
        }
    }

    public function sendFile($bucket, $filepath, $filename, $contentType = 'image/png') {
        try {
            $object = [
                'Bucket'      => $bucket,
                'Key'         => $filepath,
                'SourceFile'  => $filename,
                'ContentType' => $contentType,
                'ACL'         => 'public-read'
            ];

            $result = $this->S3->putObject($object);
            return $result['ObjectURL'];
        } catch (AwsException $e) {
            echo 'Error uploading file: ' . $e->getMessage();
            return false;
        }
    }

    public function deleteFile($bucket, $filepath, $filename) {
        try {
            $result = $this->S3->deleteObject([
                'Bucket' => $bucket,
                'Key'    => $filepath . '/' . $filename
            ]);

            return $result;
        } catch (AwsException $e) {
            echo 'Error deleting file: ' . $e->getMessage();
            return false;
        }
    }
    

    public function getFolderSize($bucket, $folder = '') {
        try {
            $objects = $this->S3->getIterator('ListObjects', [
                "Bucket" => $bucket,
                "Prefix" => $folder
            ]);

            $size = 0;
            foreach ($objects as $object) {
                $size += $object['Size'];
            }

            return format_size_units($size);  // from common_helper
        } catch (AwsException $e) {
            log_message('error', 'Error retrieving folder size: ' . $e->getMessage());
            return false;
        }
    }
}