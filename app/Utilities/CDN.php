<?php

namespace App\Utilities;
use Aws\S3\S3Client;
use Aws\CloudFront\CloudFrontClient;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class CDN {

    private static $config = [
        's3' => [
            'credentials' => [
                'key' => 'AKIAJ7O27JBG635GBE3Q',
                'secret' => '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',
            ],
            'bucket' => 'fans.reecemathieson.dev',
            'region' => 'eu-west-2',
            'version' => 'latest'
        ],
        'cloudfront' => [
            'url' => 'https://d29pnlzhhoeh4z.cloudfront.net',
            'key_pair_id' => 'APKAJ5R6B4IDB3V7P6FQ',
            'private_key' => '../config/pk-APKAJ5R6B4IDB3V7P6FQ.pem'
        ]
    ];

    public static function get_media($user, $file){
        $cloudfront = new CloudFrontClient([
            'region' => CDN::$config['s3']['region'],
            'version' => CDN::$config['s3']['version']
        ]);

        $object = $user.'/'.$file;
        if(is_null($user) || $user == ''){
            $object = $file;
        }
        $expiry = new Carbon('+10 minutes');

        $url = $cloudfront->getSignedUrl([
            'url' => CDN::$config['cloudfront']['url']."/{$object}",
            'expires' => $expiry->getTimestamp(),
            'key_pair_id' => CDN::$config['cloudfront']['key_pair_id'],
            'private_key' => CDN::$config['cloudfront']['private_key']
        ]);

        return $url;

        //ToDo; Return error message if media was not found.
    }


    public static function upload_media($user, UploadedFile $file){

        //ToDo; There is an S3 Storage driver for laravel.  Research this.

        $s3 = new S3Client([
            'credentials' => CDN::$config['s3']['credentials'],
            'region' => CDN::$config['s3']['region'],
            'version' => CDN::$config['s3']['version']
        ]);

        //File details
        $name = $file->getClientOriginalName();
        $tmp_path = $file->getRealPath();
        $extension = $file->getClientOriginalExtension();

        //Temp details
        $key = md5(uniqid());
        $tmp_file_name = "{$key}.{$extension}";
        $tmp_file_path = "storage/uploads/{$tmp_file_name}";

        //Move the file
        move_uploaded_file($tmp_path, $tmp_file_path);

        try {
            $s3->putObject([
                'Bucket' => CDN::$config['s3']['bucket'],
                'Key' => "{$user}/{$name}",
                'Body' => fopen($tmp_file_path, 'rb')
            ]);
            //Remove the file from temp storage
            unlink($tmp_file_path);
            return "{$user}/{$name}";

        } catch(S3Exception $e){
            // write to error log $e->getMessage();
            return false;
        }
    }


}
