<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 26/11/2015
 * Time: 7:41 PM
 */

echo 'hello world';

$server   = $_SERVER;
$response = file_get_contents( 'php://input' );

file_put_contents( 'ok.txt', json_encode( $response ) );