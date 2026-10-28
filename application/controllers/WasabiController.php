<?php
use Aws\S3\S3Client;

class WasabiController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('wasabi');  // Load Wasabi config

//echo FCPATH;
  //       die;
        // Include the AWS SDK manually
        require_once APPPATH . 'third_party/aws-sdk-php/aws-autoloader.php';
        
    
    }

    public function upload()
    {
        
                
        ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

        $wasabiConfig = $this->config->item('wasabi');

        // Initialize the S3 client with Wasabi's endpoint
        $s3Client = new S3Client([
            'version'     => 'latest',
            'region'      => $wasabiConfig['region'],
            'endpoint'    => $wasabiConfig['endpoint'],
            'credentials' => [
                'key'    => $wasabiConfig['key'],
                'secret' => $wasabiConfig['secret'],
            ],
        ]);
        
        /*if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
                $image = $this->upload_media($_FILES,$path,'image');
                if(is_array($image)){
                    $arr = array(
                        'status'=>'false',
                        'msg' => $image['msg'],
                    );
                }else{
                    $data_arr['image'] = $image;
                    $pimage = $image;
                }
        }*/
            
            

        // Your file upload logic here
        $filePath = FCPATH.'uploads/students/16912465932371.jpg';
        $bucket = $wasabiConfig['bucket'];
        $key = 'file.png';  

        try {
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => $key,
                'SourceFile' => $filePath,
                'ACL'    => 'public-read',  
            ]);

            echo "File uploaded successfully. File URL: " . $result['ObjectURL'];
        } catch (Aws\S3\Exception\S3Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

?>
