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

    public function __construct()
    {
//        $dir = $this->ff->generate_path;

        $this->ip = '192.168.22.2';
        $this->username = 'Contract';
        $this->password = '123QWer45';

//        $this->ip = 'ozharko.ftp.tools';
//        $this->username = 'ozharko_dir';
//        $this->password = '75vUtTYh9x3P';
    }
    public function create_directory($dir)
    {
        $dir = str_replace("Contract/", "", $dir);
        // підключення до сереверу
        $conn_id = ftp_connect($this->ip);

        // авторизація по FTP
        $login_result = ftp_login($conn_id, $this->username, $this->password);

        // створити папку для файлів
        $path = null;
        $path_part = explode("/", $dir);
        foreach ($path_part as $folder) {
            if ($path == null)
                $path = $folder;
            else
                $path = $path . "/" . $folder;

//            $path = str_replace(array('%82','%94','+'), array('&#233;','&#246;',' '), urlencode($path));
            $path = str_replace(array('%82','%94','+'), array('&#233;','&#246;',' '), urlencode("Тест"));

            // створити папку
//            @ftp_mkdir($conn_id, $path);
            ftp_mkdir($conn_id, $path);die; // without ignoring error
        }

        // завершити підключення
        ftp_close($conn_id);
    }

    public function upload_file($path, $localfile)
    {
        $path = str_replace("Contract/", "", $path);

        $file_name = explode("/", $localfile);
        $file_name = end($file_name);
        $remotefile = $path . "/" . $file_name;

//        $ch = curl_init();
//
//        $fp = fopen($localfile, 'r');
//        curl_setopt($ch, CURLOPT_URL, "ftp://$this->username:$this->password@$this->ip/".$remotefile);
//        curl_setopt($ch, CURLOPT_UPLOAD, 1);
//        curl_setopt($ch, CURLOPT_INFILE, $fp);
//        curl_setopt($ch, CURLOPT_INFILESIZE, filesize($localfile));
//        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
//
//        curl_exec ($ch);
//        $error_no = curl_errno($ch);
//        curl_close ($ch);
//
//        if ($error_no == 0) {
//            $error = 'Файли завантажено успішно';
//        } else {
//            $error = 'Помилка';
//        }

//        system("mkdir oleg|_|2");
//        $command = "/usr/bin/lftp -c 'open -u Contract,123QWer45 ftp://192.168.22.2; put -O / Нота.txt'";
        $command = "/usr/bin/lftp -c 'open -u $this->username,$this->password ftp://$this->ip; put -O / Нота.txt'";
        $command = "/usr/bin/lftp -c 'open -u $this->username,$this->password ftp://$this->ip; put -O $remotefile $localfile'";
        exec($command, $output);
//        shell_exec($command);
    }
}
