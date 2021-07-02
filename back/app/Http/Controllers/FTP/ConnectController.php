<?php

namespace App\Http\Controllers\FTP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConnectController extends Controller
{
    public $dir;
    public $ip;
    public $username;
    public $password;

    public function __construct($root_path = null)
    {

//        $dir = $this->ff->generate_path;
        $this->dir = $root_path;

//        $this->ip = '192.168.22.2';
//        $this->username = 'Contract';
//        $this->password = '123QWer45';

        $this->ip = 'ozharko.ftp.tools';
        $this->username = 'ozharko_dir';
        $this->password = '75vUtTYh9x3P';
    }
    public function create_directory()
    {
        $ip = 'ozharko.ftp.tools';
        $username = 'ozharko_dir';
        $password = '75vUtTYh9x3P';

        // set up basic connection
        $conn_id = ftp_connect($ip);

        // login with username and password
        $login_result = ftp_login($conn_id, $username, $password);


        // створити папку для файлів
        $path = null;
        $path_part = explode("/", $dir);
        foreach ($path_part as $folder) {
            if ($path == null)
                $path = $folder;
            else
                $path = $path . "/" . $folder;

            // try to create the directory $dir
            @ftp_mkdir($conn_id, $path);
        }
    }

    public function ftp($localfile)
    {
        $ch = curl_init();
//        $localfile = $this->contract_generate_file;
        $file_name = explode("/", $localfile);
        $file_name = end($file_name);
        $remotefile = $path . "/" . $file_name;

        $fp = fopen($localfile, 'r');
        curl_setopt($ch, CURLOPT_URL, "ftp://$this->username:$this->password@$this->ip/".$remotefile);
        curl_setopt($ch, CURLOPT_UPLOAD, 1);
        curl_setopt($ch, CURLOPT_INFILE, $fp);
        curl_setopt($ch, CURLOPT_INFILESIZE, filesize($localfile));
        curl_exec ($ch);
        $error_no = curl_errno($ch);
        curl_close ($ch);
        if ($error_no == 0) {
            $error = 'File uploaded succesfully.';
        } else {
            $error = 'File upload error.';
        }

        // close the connection
        ftp_close($conn_id);
    }
}
