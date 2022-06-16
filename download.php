<?php

require_once 'include/config.inc.php';

header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
header('Pragma: no-cache');

function partial_download($range_header, $request_file, $mime) {
	$file_size = filesize($request_file);
	list($b, $range) = explode('=', $range_header);
	list($first_range) = explode(',', $range);
	list($part_start,$part_end) = explode('-', $first_range);
	$start = intval($part_start);
	if ($part_end)
		$end = intval($part_end);
	else
		$end = $file_size - 1;
	$chunksize = ($end-$start)+1;

	header('HTTP/1.1 206 Partial Content');
	header("Content-Type: $mime");
        header('Content-Transfer-Encoding: binary');
	header("Content-Range: bytes $start-$end/$file_size");
        header('Content-Length: '.$chunksize);
#       header("Content-Disposition: attachment; filename=\"$_REQUEST[audio]\"");

	$fp = fopen($request_file, 'r');
	fseek($fp, $start, SEEK_SET);
	echo fread($fp, $chunksize);
	fclose($fp);
}

if (isset($_REQUEST['audio'])) {
	$extension = strtolower(substr(strrchr($_REQUEST['audio'],"."),1));
	$ctype ='';
	switch( $extension ) {
		case "wav16":
			$ctype="audio/x-wav";
			break;
		case "wav":
			$ctype="audio/x-wav";
			break;
		case "ulaw":
			$ctype="audio/basic";
			break;
		case "alaw":
			$ctype="audio/x-alaw-basic";
			break;
		case "sln":
			$ctype="audio/x-wav";
			break;
		case "gsm":
			$ctype="audio/x-gsm";
			break;
		case "g729":
			$ctype="audio/x-g729";
			break;
		default:
			$ctype="application/$system_audio_format";
			break ;
	}

	header("Accept-Ranges: bytes");

	if (!isset($_SERVER['HTTP_RANGE'])) {
		header("Content-Type: $ctype");
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize("$system_monitor_dir/$_REQUEST[audio]"));
		header("Content-Disposition: attachment; filename=\"$_REQUEST[audio]\"");
		readfile("$system_monitor_dir/$_REQUEST[audio]");
	}
	else {
		partial_download($_SERVER['HTTP_RANGE'], "$system_monitor_dir/$_REQUEST[audio]", $ctype);
	}

	/*$_REQUEST['audio'] = preg_replace("/\.\./",'', $_REQUEST['audio']);
	header("Content-Type: $ctype");
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: '.filesize("$system_monitor_dir/$_REQUEST[audio]"));
	header("Content-Disposition: attachment; filename=\"$_REQUEST[audio]\"");
	readfile("$system_monitor_dir/$_REQUEST[audio]");*/
} elseif (isset($_REQUEST['fax'])) {
	$_REQUEST['fax'] = preg_replace("/\.\./",'', $_REQUEST['fax']);
	header('Content-Type: image/tiff');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: '.filesize("$system_fax_archive_dir/$_REQUEST[fax]"));
	header("Content-Disposition: attachment; filename=\"$_REQUEST[fax]\"");
	readfile("$system_fax_archive_dir/$_REQUEST[fax]");
} elseif (isset($_REQUEST['csv'])) {
	$_REQUEST['csv'] = preg_replace("/\.\./",'', $_REQUEST['csv']);
	header('Content-Type: text/csv');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: '.filesize("$system_tmp_dir/$_REQUEST[csv]"));
	header("Content-Disposition: attachment; filename=\"$_REQUEST[csv]\"");
	readfile("$system_tmp_dir/$_REQUEST[csv]");
} elseif (isset($_REQUEST['arch'])) {
	$_REQUEST['arch'] = preg_replace("/\.\./",'', $_REQUEST['arch']);
	header('Content-Type: application/x-download');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: '.filesize("$system_monitor_dir/$_REQUEST[arch]"));
	header("Content-Disposition: attachment; filename=\"$_REQUEST[arch]\"");
	readfile("$system_monitor_dir/$_REQUEST[arch]");
}

exit();
?>
