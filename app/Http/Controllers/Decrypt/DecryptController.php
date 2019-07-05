<?php

namespace App\Http\Controllers\Decrypt;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DecryptController extends Controller
{
    public function index(Request $request)
    {
        if (empty($request->file)) {
            return back();
        }

        $file = $request->file;
        $key = $request->key;
        
        $data = $this->create($file, $key);
        
        // $path = Storage::put('public', $file);

        // return $url;
        // dd($data);
        return view('decrypted', $data);
    }

    public function create($file, $key)
    {
        $handle = fopen($file, "rb") or die("Could not open a file.");
        $contents = fread($handle, filesize($file));
        fclose($handle);

        $path = 'public/'.date('YmdHis', strtotime(Carbon::now())).'/'.$file->getClientOriginalName();
        Storage::put($path, $this->rc4($contents, $key));
        
        $data = [
            'path' => $path
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
}
