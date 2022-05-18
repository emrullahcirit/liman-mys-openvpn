<?php

return [
    "index" => "HomeController@index",
    "openvpn_install" => "InstallationController@install",
    "openvpn_remove" => "InstallationController@remove",
    "openvpn_check" => "InstallationController@check",
    "openvpn_create" => "InstallationController@create",
    "openvpn_cerf_list" => "CertificateController@list",
    "openvpn_cerf_get" => "CertificateController@getCertificate",
    "openvpn_logger" => "InstallationController@logger",
    "openvpn_rmlogger" => "InstallationController@rmLogger",


];