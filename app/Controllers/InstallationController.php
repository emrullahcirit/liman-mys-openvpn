<?php
namespace App\Controllers;

use Liman\Toolkit\Shell\Command;

class InstallationController
{
	public function install()
	{

		Command::runSudo("echo ' ' > log.txt");
		Command::runSudo('wget https://git.io/vpn -O openvpn-ubuntu-install.sh');
		Command::runSudo('wget https://gist.githubusercontent.com/emrullahcirit/67bff3886f719407688abedbea44b16a/raw/bdfb579774014092b85b28f3a632859aa528efd9/openvpn-create-cert.sh');

		Command::runSudo('chmod +x openvpn-ubuntu-install.sh openvpn-create-cert.sh');
		Command::runSudo("~/./openvpn-ubuntu-install.sh < asd.txt > log.txt");
		return respond('Successfully installed', 200);
	}

	public function logger(){

		$fileContent = Command::runSudo("cat ~/log.txt");
		return respond($fileContent, 200);

	}

	public function check(){
		Command::run('rm ~/checkVPN.txt');
		Command::run('systemctl status openvpn-server@server.service > ~/checkVPN.txt');
		$status = Command::run('cat ~/checkVPN.txt');
		if($status != ""){
			return respond('Service is available', 200);
		}else{
			return respond('Service is not available', 404);	
		}

	}
	public function create(){
			Command::runSudo("~/./openvpn-create-cert.sh 1 ".request('cerfName')."< asd.txt");
			return respond(request('cerfName'), 200);	

	}
	public function remove(){
		Command::runSudo("rm -rf /root/*.ovpn");
		Command::runSudo("echo ' ' > remove.log");
		Command::runSudo("~/./openvpn-create-cert.sh 3 y < asd.txt > remove.log");
		return respond(request('cerfName'), 200);
	}

	public function rmLogger(){
		$rmLogContent = Command::runSudo("cat ~/remove.log");
		return respond($rmLogContent, 200);
	}
}
