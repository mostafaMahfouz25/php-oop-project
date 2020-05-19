<?php

	//include the RainTPL class
	include( 'includes/raintpl.class.php' );

	//initialize a Rain TPL object
	$tpl = new RainTPL( 'themes' );
	
	//variable assign example
	$variable = "CIAO, BELLA GIORNATA?";
	$tpl->assign( "variable", $variable );
	
	//loop example
	$week = array( 'lunedì', 'martedì', 'mercoledì', 'giovedì', 'venerdì', 'sabato', 'domenica' );
	$tpl->assign( "week", $week );
	
	
	//loop example 2
	$user = array( 0 => array( 'name'=>'Mario', 'age'=>45 ),
				   1 => array( 'name'=>'Federico', 'age'=>27 ),
				   2 => array( 'name'=>'Giovanna', 'age'=>32 )
	);
	$tpl->assign( "user", $user );
	
	
	//assign the template variable copyright
	$tpl->assign( 'copyright', 'Copyright 2006 Rain TPL<br>Project By <a href="http://www.rainelemental.net" target="_blank">RainElemental.net</a>' );

	//draw the template	
	echo $tpl->draw( 'page' );
	
?>