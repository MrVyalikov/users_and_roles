<?php

	const HTML_UNKNOWN_DATABASE_ERROR = "<div class='alert alert-danger'>Unknown database error</div>";

	function string_get($str){
		return htmlspecialchars(trim($str));
	}

	function user_role_create()
	{
		global $dbPDO;

		$rolename = string_get($_POST['rolename']);
		if (!preg_match("/^[a-zа-я0-9_]{1,}+[a-zа-я0-9_ ]{0,20}$/iu", $rolename))
			return "<div class='alert alert-danger'>User role should be between 1 and 20 characters. Use latin and russian characters, spaces and numbers</div>";

		// validation is okay, create record
		try 
		{
			$stmt = $dbPDO->prepare("INSERT INTO `user_role` (`id`, `rolename`) VALUES (0, '$rolename')"); 
			if($result = $stmt->execute()){
				return "<div class='alert alert-success'>User role '$rolename' was created</div>";
			} 
			else 
			{
				return HTML_UNKNOWN_DATABASE_ERROR;
			}
		}
		catch(PDOException $e)
		{
			if ($e->getCode() == 23000) {
				return "<div class='alert alert-danger'>Already have role '$rolename' in database</div>";
			}

			echo 'Error : '.$e->getMessage();
			exit();
		}	
	}

	function user_create()
	{
		global $dbPDO;

		$username = string_get($_POST['username']);
		$role_id = (int)$_POST['role_id'];

		if (!preg_match("/^[a-zа-я0-9_]{1,}+[a-zа-я0-9_ ]{0,20}$/iu", $username))
			return "<div class='alert alert-danger'>User name should be between 1 and 20 characters. Use latin and russian characters, spaces and numbers</div>";

		// validation is okay, create record
		try 
		{
			$stmt = $dbPDO->prepare("INSERT INTO `user` (`id`, `username`, `role_id`) VALUES (0, '$username', $role_id)"); 
			if($result = $stmt->execute()){
				return "<div class='alert alert-success'>User '$username' was created</div>";
			} 
			else 
			{
				return HTML_UNKNOWN_DATABASE_ERROR;
			}
		}
		catch(PDOException $e)
		{
			if ($e->getCode() == 23000) {
				return "<div class='alert alert-danger'>Already have user '$username' in database</div>";
			}

			echo 'Error : '.$e->getMessage();
			exit();
		}	
	}
?>