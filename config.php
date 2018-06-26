<?php
	define('DIR_ROOT', __DIR__);
	define('ENVIRONMENT_FILE', DIR_ROOT . '/.environment');
	define('TEMPLATE_DIR', DIR_ROOT . '/templates');
	
	if (!file_exists(ENVIRONMENT_FILE)) 
		throw new Exception('File "' . ENVIRONMENT_FILE . '" not exist. Please create file.');
	
	$params = parse_ini_file(ENVIRONMENT_FILE);
		
	$requiredParams = array(
		'DIR_PROJECT',
		'PATH_GIT',
	);

	array_map(function ($name) use ($params) {
		if (!isset($params[$name])) {
			throw new Exception('Param ' . $name . ' not set in file ' . ENVIRONMENT_FILE);
		}else{
			define($name, $params[$name]);
		}
	}, $requiredParams);
		
	if (!file_exists(DIR_PROJECT))
		throw new Exception('Project ' . DIR_PROJECT . ' not found. Check DIR_PROJECT in .env file');
		
	$gitDir = DIR_PROJECT . '.git';

	if (!file_exists($gitDir))
		throw new Exception('Git directory ' . $gitDir . ' not found. Check is "' . DIR_PROJECT . '" git repo');
	
	if (!file_exists(PATH_GIT))
		throw new Exception('Git executable ' . PATH_GIT . ' not found. Check PATH_GIT in .env file');