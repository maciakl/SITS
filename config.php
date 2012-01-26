<?php
/**
 * This is the main config file where you define global options.
 * 
 * Please change these to your database details. If you want to
 * run SITS in private mode, change SITS_PUBLIC_MODE to false.
 */

 
//////////////////////////////////////	DATABASE CONFIG

/* 	DATABASE HOSTNAME	
	This is the name or the IP of your database server. Usually localhost. */
define('SITS_DB_HOSTNAME', 		'localhost'	);

/* 	DATABASE NAME	
	This is the name of the database you set up for SITS. It's recomended you use sits.*/
define('SITS_DB_NAME', 			'sits'		);

/*	USERNAME		
	The database user you want to use for this application. Make a separate user for sits; 
	Grant him UPDATE, INSERT, DELETE and SELECT on sits db only.*/
define('SITS_DB_USER', 			'sits_user'	);

/*	 PASSWORD		
	The password for the above written in plain text. Use something long and crazy.*/
define('SITS_DB_PASSWORD', 		'password'	);


//////////////////////////////////////	OTHER OPTIONS

/* 	PUBLIC MODE		
	If set to true, everyone can read the tickets. If set to false, tickets will only be
	visible to those who are logged in.*/
define('SITS_PUBLIC_MODE', 		true		);

/*	ENABLE INDEXING & CACHING
	If set to true the site can be cashed and indexed by search engines. If set to false,
 	meta-tags will disallow indexing and caching.*/
define('SITS_ENABLE_INDEXING',		true		);

?>
