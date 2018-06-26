<?php 
	error_reporting(E_ALL ^ E_NOTICE);
	ini_set('display_errors', 1);
	
	require_once ('config.php');
	require_once './git.php';
	
	$git = Git::getInstance(DIR_PROJECT, PATH_GIT);
	
	$action = $_REQUEST['action'];

	if($_REQUEST['clean'])
		$msgInfo[] = $git->clean();
	
	switch ($action)
	{
		case 'checkout':
			$msgInfo[] = $git->checkout($_REQUEST['branch']);
			break;
		case 'pull':
			if($_REQUEST['clean'])
				$git->checkout('.');
			
			$msgInfo[] = $git->pull();
			break;
		default :
			break;
	}
	
	$branches = $git->getLocalBranches();
	
	$status = $git->getStatus();
	
	require_once TEMPLATE_DIR . '/layout.php';