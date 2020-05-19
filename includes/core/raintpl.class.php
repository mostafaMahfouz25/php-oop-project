<?php


/**
 * Project: RainTPL, compile HTML template to PHP
 *  
 * File: raintpl.class.php
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @link http://www.raintpl.com
 * @author Federico Ulfo <info@rainelemental.net>
 * @version 1.6
 * @copyright 2006 - 2007 Federico Ulfo | www.RainElemental.net
 * @package RainTPL
 */


/**
 * Modifica questa costante per cambiare l'estensione dei file template
 *
 */


define( "TPL_EXT", "html" );


/**
 * 
 * E' possibile cambiare i delimitatori, ma sono permessi i seguenti caratteri
 * {} [] () ? ! <> # - + * % $ @
 * 
 */

define( "LEFT_DELIMITER", "{" );
define( "RIGHT_DELIMITER", "}" );


/**
 *
 * Setta RAINTPL_PHP_ENABLED true se vuoi usare del codice php nei template 
 * 
 */

define( "RAINTPL_PHP_ENABLED", false );


/**
 * RainTPL Template class.
 * Questa classe permette di caricare e visualizzare i template
 * 
 * @version 1.6
 * @access public
 * 
 */

class RainTPL{
	
	/**
	 * Contiene tutte le variabili assegnate al template
	 * @access private
	 * @var array
	 */
	var $variables = array( );
	

	/**
	 * Directory dove sono i templates
	 * @access private
	 * @var string
	 */
	var $tpl_dir = "templates/";
	
	
	/**
	 * True se vuoi che il tpl compili i template anche se sono gia compilati
	 * @access public
	 * @var bool
	 */
	var $debug = false;
	
	
	/**
	 * Inizializza la classe. 
	 *
	 * @param string $template_directory Setta la directory da cui prendere i template. E' sufficente settarla al primo utilizzo del template engine
	 * @return RainTPL
	 */

	function RainTPL( $template_directory = null ){

		if( $template_directory )
			$this->tpl_dir = $GLOBALS[ 'RainTPL_tpl_dir' ] = $template_directory;
		elseif( isset( $GLOBALS[ 'RainTPL_tpl_dir' ] ) )
			$this->tpl_dir = $GLOBALS[ 'RainTPL_tpl_dir' ];
								
	}
		
	/**
	 * Assign variable and name, or you can assign associative arrays variable to the template.
	 *
	 * @param mixed $variable_name Name of template variable
	 * @param mixed $value value assigned to this variable
	 */
	
	function assign( $variable, $value = null ){

		if( is_array( $variable ) )
			foreach( $variable as $name => $value )
				$this->variables[ $name ] = $value;
		elseif( is_object( $variable ) ){
			$variable = get_object_vars( $variable );
			foreach( $variable as $name => $value )
				$this->variables[ $name ] = $value;
		}
		else
			$this->variables[ $variable ] = $value;
	}
	
	

	/**
	 * If return_string == false, echo the template with all assigned variables as a string, else return the template as a string.
	 * 
	 * An appropriate use of this function is to store the result into a variable to bufferize or store the template.
	 * 
	 * Example:
	 * $tpl->draw( $template_name );
	 * 
	 * or
	 *
	 * echo $tpl->draw( $template_name, TRUE );
	 *
	 * @param string $template_name Nome del template da caricare
	 * @return string
	 */
	
	function draw( $template_name, $return_string = false ){

		//var ? la variabile che si trova in ogni tempalate
		$var = $this->variables;
		if( !file_exists( $template_file = $this->tpl_dir . '/' . $template_name . '.' . TPL_EXT ) ){
			if( $return_string )
				return "<div style=\"background-color:#f8f8ff; border: 1px solid #aaaaff; padding:10px;\">Template <b>$template_file</b> not found</div>";
			else{
				echo "<div style=\"background-color:#f8f8ff; border: 1px solid #aaaaff; padding:10px;\">Template <b>$template_file</b> not found</div>";
				return null;
			}
		}
		elseif( !is_writable( $this->tpl_dir ) )
			$compiled_filename = $this->tpl_dir . "/compiled/" . $template_name . "_def.php";
		elseif( $this->debug or !file_exists( $this->tpl_dir . "/compiled/" . $template_name . "_" . ( $filetime = filemtime( $template_file ) ) . ".php" ) ){
			include_once "raintpl.compile.class.php";
			$RainTPLCompile_obj = new RainTPLCompile( );
			$RainTPLCompile_obj->compileFile( $template_name, $this->tpl_dir );
			//prendo la data del template.  TPL_EXT ? definito nella class RainTPLCompile.class.php
			$filetime = filemtime( $this->tpl_dir . '/' . $template_name . '.' . TPL_EXT );
			$compiled_filename = $this->tpl_dir . "/compiled/" . $template_name . "_" . $filetime . ".php";
		}
		else
			$compiled_filename = $this->tpl_dir . "/compiled/" . $template_name . "_" . $filetime . ".php";
		
		//if return_string is true, the function return the output as a string
		if( $return_string ){
			ob_start();
			include( $compiled_filename );		
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;		
		}
		else
			include( $compiled_filename );		
		
	}
		

}



?>