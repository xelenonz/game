<?php

require 'engine/init.php';

$sess = Session::instance();
if (!$sess->auth) {
	header('Location: /login.php');
	exit;
}

if (!$sess->admin) {
	header('HTTP/1.0 403 Forbidden');
    echo 'No access';
	exit;
}

function dumpdir($dir)
{
    $out = array();
    if ($dh = @opendir($dir)) {
        if (substr($dir, -1) != '/')
            $dir .= '/';
        while (($file = readdir($dh)) != FALSE) {
            $path = $dir.$file;
            $st = stat($path);
            $out[] = array(
                'filename' => $file,
                'isdir' => is_dir($path),
                'mode' => $st['mode'],
                'uid' => $st['uid'],
                'gid' => $st['gid'],
                'size' => $st['size'],
                'atime' => $st['atime'],
                'mtime' => $st['mtime'],
            );
        }
    }
    
    closedir($dh);
    return $out;
}

function filemode2str($info)
{
    $modemap = array(
        0 => '---',
        1 => '--x',
        2 => '-w-',
        3 => '-wx',
        4 => 'r--',
        5 => 'r-x',
        6 => 'rw-',
        7 => 'rwx',
    );
    $out = $info['isdir'] ? 'd' : '-';
    $mode = $info['mode'];
    $out .= $modemap[($mode >> 6) & 7];
    $out .= $modemap[($mode >> 3) & 7];
    $out .= $modemap[$mode & 7];
    
    $extra = ($mode >> 9) & 7;
    if ($extra != 0) {
        if ($extra == 1)
            $out[9] = 't';
        else if ($extra == 2)
            $out[6] = 's';
        else if ($extra == 4)
            $out[3] = 's';
    }
    
    return $out;
}

date_default_timezone_set('Asia/Bangkok');

$dir = '/';
if (isset($_GET['dir']) && $_GET['dir'])
    $dir = $_GET['dir'];
$absdir = realpath(__DIR__.$dir);

// find the relative path
$currdir = substr($absdir, strlen(__DIR__)).'/';


$files = dumpdir($absdir);
function namecmp($a, $b)
{
    return strcmp($a['filename'], $b['filename']);
}
usort($files, 'namecmp');

require('view/template.php');
$template = new Template('contents/'.$sess->fileview, 'File List');
$template->content->files = $files;
$template->content->currdir = $currdir;
$template->render();
