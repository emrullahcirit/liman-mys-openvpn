<?php
namespace App\Controllers;

use Liman\Toolkit\Shell\Command;

class CertificateController
{
	public function list(){
        $list = Command::runSudo('ls /root | grep ovpn');
        // create regex for *.ovpn


        return respond($list, 200);

    }
    public function getCertificate(){
        $content = Command::runSudo('cat /root/'.request('cerfName'));
        return respond($content, 200);
    }
}
