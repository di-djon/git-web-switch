<?php

class Git
{
	protected static $_instance = null;
	
	protected $_projectPath		= null;
	protected $_gitPath			= null;
	protected $_outLogPath		= null;
	
	public function __construct($projectPath, $gitPath)
	{
		$this->_projectPath = $projectPath;
		
		if (stripos(PHP_OS, 'win') === 0) {
			$this->_gitPath		= '"' . $gitPath . '"';
		}
		else
		{
			$this->_gitPath		= $gitPath;
		}
	}
	/**
	 * 
	 * @param string $projectPath
	 * @param string $gitPath
	 * 
	 * @return Git
	 * @throws Exception
	 */
	public static function getInstance($projectPath, $gitPath)
    {		
		if (self::$_instance === null) {
            self::$_instance = new self($projectPath, $gitPath);
        }
		
		chdir($projectPath);
		
        return self::$_instance;
    }
	
	/**
	 * Get actual remote branches
	 */
	public function getRemoteBranches()
	{
		$result = shell_exec ('git show-branch --list --remotes');
		
		preg_match_all('/\[.+\]/', $result, $branches);
		
		return array_map(function($item){ 
			$tmpBranch = explode('/', $item); 
			return trim(array_pop($tmpBranch), ']');
		}, $branches[0]);
	}
	
	/**
	 * Get actual local branches
	 */
	public function getLocalBranches($trim = false)
	{
		$result = shell_exec ('git branch');
		
		$branches = explode("\n", trim($result));
		
		if($trim)
			return array_map(function($branch){
				return trim($branch, '* ');
			}, $branches);
		
		return $branches;
	}
	
	/**
	 * Get status
	 */
	public function getStatus()
	{
		$result = shell_exec ('git status');
		
		return trim($result);
	}
	
	/**
	 * Git checkout
	 */
	public function checkout($branch)
	{
		$branches	= $this->getLocalBranches(true);
		$branches[] = '.';
		$branch		= trim($branch, ' *');

		//security check
		if(!in_array($branch, $branches))
			throw new Exception ('Branch ' . $branch . ' not found');

		$cmd = sprintf('%s checkout %s 2>&1', $this->_gitPath, $branch);
		
		$result =  exec  ($cmd, $out);
		
		return $result;
	}
	
	/**
	 * Clean project directory
	 * 
	 * @return string
	 */
	public function clean()
	{
		$cmd = 'git clean -fd 2>&1';
		
		$result =  exec  ($cmd, $out);
		
		if(empty($out))
			return 'Directory is clear';
		
		return implode("\n", $out);
	}
	
	public function pull()
	{
		$curBranch = $this->getCurrentBranch();
		
		if($curBranch == 'master')
			$curBranch = '';
		
		$cmd = sprintf('git pull -v --no-rebase "origin" %s 2>&1', $curBranch);
		
		$result =  exec  ($cmd, $out);
		
		array_unshift($out, $cmd);
		
		return implode("\n", $out);
	}
	
	public function getCurrentBranch()
	{
		$branches = $this->getLocalBranches();
		
		foreach ($branches as $b)
		{
			if(strpos($b, '*') === 0)
				return trim($b, '* ');
		}
		
		return null;
	}
}