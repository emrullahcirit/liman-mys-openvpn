<?php
namespace App\Controllers;

use Liman\Toolkit\Shell\Command;

class HostnameController
{
	public function get()
	{
		return respond(Command::run('hostname'), 200);
	}

	public function set()
	{
		validate([
			'hostname' => 'required|string'
		]);
	
		$status = (bool) Command::runSudo('hostnamectl set-hostname @{:hostname} 2>/dev/null 1>/dev/null && echo 1 || echo 0', [
			'hostname' => request('hostname')
		]);
	
		if ($status) {
			return respond(__('Hostname değiştirildi.'), 200);
		} else {
			return respond(__('Hostname değiştirilirken bir hata oluştu!'), 201);
		}
	}
}
