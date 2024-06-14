<?php
require_once 'MatchService.php';

$server = new SoapServer("http://localhost/football-scores/wsdl/service.wsdl");
$server->setClass("MatchService");
$server->handle();

