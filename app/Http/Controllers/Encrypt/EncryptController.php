<?php

namespace App\Http\Controllers\Encrypt;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EncryptController extends Controller
{
    public function index(Request $request)
    {
        if (empty($request->file)) {
            return back();
        }

        $file = $request->file;
        $key = str_random(32);
        
        $data = $this->create($file, $key);
        
        // $path = Storage::put('public', $file);

        // return $url;
        // dd($data);
        return view('encrypted', $data);
    }

    public function create($file, $key)
    {
        $handle = fopen($file, "rb") or die("Could not open a file.");
        $contents = fread($handle, filesize($file));
        fclose($handle);

        // dd($contents);

        // dd($contents);
        // return;

        $path = 'public/'.date('YmdHis', strtotime(Carbon::now())).'/'.$file->getClientOriginalName();
        Storage::put($path, $this->rc4($contents, $key));
        
        $data = [
            'path' => $path,
            'key' => $key
        ];

        return $data;
        // $type = $file->getClientMimeType();
        // $file = $file->getClientOriginalName();
        // $txt = fopen($file, "w") or die("Unable to open file.");
        // fwrite($txt, $this->rc4($contents, 'zakyd'));
        // fclose($txt);

        // header('Content-Description: File Transfer');
        // header('Content-Disposition: attachment; filename='.basename($file));
        // header('Expires: 0');
        // header('Cache-Control: must-revalidate');
        // header('Pragma: public');
        // header('Content-Length: '.filesize($file));
        // header("Content-Type: ".$type);
    }

    public function rc4($str, $key)
    {
        $s = array();
        for ($i = 0; $i < 256; $i++) {
            $s[$i] = $i;
        }

        $j = 0;
        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
            $x = $s[$i];
            $s[$i] = $s[$j];
            $s[$j] = $x;
        }

        $i = 0;
        $j = 0;
        $res = '';

        for ($y = 0; $y < strlen($str); $y++) {
            $i = ($i + 1) % 256;
            $j = ($j + $s[$i]) % 256;
            $x = $s[$i];
            $s[$i] = $s[$j];
            $s[$j] = $x;
            $res .= $str[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
        }

        return $res;
    }
    
    // function encrypt_file($file, $destination, $passphrase) {
    //     // Open the file and returns a file pointer resource. 
    //     $handle = fopen($file, "rb") or die("Could not open a file."); 
    //     // Returns the read string.
    //     $contents = fread($handle, filesize($file));
    //     // Close the opened file pointer.
    //     fclose($handle); 
 
    //     $iv = substr(md5("\x1B\x3C\x58".$passphrase, true), 0, 8);
    //     $key = substr(md5("\x2D\xFC\xD8".$passphrase, true) . md5("\x2D\xFC\xD9".$passphrase, true), 0, 24);
    //     $opts = array('iv'=>$iv, 'key'=>$key);
    //     $fp = fopen($destination, 'wb') or die("Could not open file for writing.");
    //     // Add the Mcrypt stream filter with Triple DES
    //     stream_filter_append($fp, 'mcrypt.tripledes', STREAM_FILTER_WRITE, $opts); 
    //     // Write content in the destination file.
    //     fwrite($fp, $contents) or die("Could not write to file."); 
    //     // Close the opened file pointer.
    //     fclose($fp); 
    // }
    
    // function decrypt_file($file,$passphrase) {
    //     $iv = substr(md5("\x1B\x3C\x58".$passphrase, true), 0, 8);
    //     $key = substr(md5("\x2D\xFC\xD8".$passphrase, true) .
    //     md5("\x2D\xFC\xD9".$passphrase, true), 0, 24);
    //     $opts = array('iv'=>$iv, 'key'=>$key);
    //     $fp = fopen($file, 'rb');
    //     stream_filter_append($fp, 'mdecrypt.tripledes', STREAM_FILTER_READ, $opts);
    //     return $fp;
    // }
}
