<?php

/**
 * @file images.php
 * This file is part of MOVIM.
 * 
 * @brief The movim's images handler.
 *
 * @author Edhelas <edhelas@gmail.com>
 *
 * @version 1.0
 * @date  22 November 2011
 *
 * Copyright (C)2010 MOVIM team
 * 
 * See the file `COPYING' for licensing information.
 */

ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL ^ E_DEPRECATED ^ E_NOTICE);
ini_set('error_log', 'log/php.log');

require("init.php");

global $sdb;

function display_image($hash, $type) {
    ob_clean();
    ob_start();
    header("ETag: \"{$hash}\"");
    header("Accept-Ranges: bytes");
    header("Content-type: ".$type);
    header("Cache-Control: max-age=".rand(1, 5)*3600);
    header('Date: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
    header('Expires: ' . gmdate('D, d M Y H:i:s', time()+24*60*60) . ' GMT');
}

// We load the avatar from the database and we display it
if(isset($_GET['c'])) {
    $hash = md5($_GET['c'].$_GET['size']);
    $headers = getallheaders();
    
    ob_clean();
    ob_start();
    if (ereg($hash, $headers['If-None-Match']))
    {
        header('HTTP/1.1 304 Not Modified');
        exit;
    } elseif($_GET['c'] == 'default') {
            ob_clean();
            ob_start();
            $content = file_get_contents('themes/movim/img/default.svg');
            
            display_image($hash, "image/svg+xml");
            echo $content;
            exit;

     }
    
     else {
        $user = new User();
        $contact = $sdb->select('Contact', array('key' => $user->getLogin(), 'jid' => $_GET['c']));
        
        if($contact[0]->phototype != '' && $contact[0]->photobin != '' && $contact[0]->phototype != 'f' && $contact[0]->photobin != 'f') {
            if(isset($_GET['size']) && $_GET['size'] != 'normal') {
                switch ($_GET['size']) {
                    case 'm':
                        $size = 120;
                        break;
                    case 's':
                        $size = 50;
                        break;
                    case 'xs':
                        $size = 24;
                        break;
                }
                $thumb = imagecreatetruecolor($size, $size);
                $white = imagecolorallocate($thumb, 255, 255, 255);
                imagefill($thumb, 0, 0, $white);
                $source = imagecreatefromstring(base64_decode($contact[0]->photobin));
                if($source) {
                    $width = imagesx($source);
                    $height = imagesy($source);
                    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $size, $size, $width, $height);
                    
                    display_image($hash, "image/jpeg");
                    imagejpeg($thumb, NULL, 95);
                }
                
            } elseif(isset($_GET['size']) && $_GET['size'] == 'normal') { // The original picture
                display_image($hash, $contact[0]->phototype);
                echo base64_decode($contact[0]->photobin);
            }
        }
    }
}
