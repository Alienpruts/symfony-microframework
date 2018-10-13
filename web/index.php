<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 13/10/18
 * Time: 0:00
 */

use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);