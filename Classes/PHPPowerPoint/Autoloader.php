<?php
/**
 * PHPPowerPoint
 *
 * Copyright (c) 2006 - 2010 PHPPowerPoint
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
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPPowerPoint
 * @package    PHPPowerPoint
 * @copyright  Copyright (c) 2006 - 2010 PHPPowerPoint (http://www.codeplex.com/PHPPowerPoint)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

PHPPowerPoint_Autoloader::Register();
// check mbstring.func_overload
if (ini_get('mbstring.func_overload') & 2) {
    throw new Exception('Multibyte function overloading in PHP must be disabled for string functions (2).');
}


/**
 * PHPPowerPoint_Autoloader
 *
 * @category	PHPPowerPoint
 * @package		PHPPowerPoint
 * @copyright	Copyright (c) 2006 - 2012 PHPPowerPoint (https://github.com/Progi1984/PHPPowerPoint)
 */
class PHPPowerPoint_Autoloader
{
	/**
	 * Register the Autoloader with SPL
	 *
	 */
	public static function Register() {
		if (function_exists('__autoload')) {
			//	Register any existing autoloader function with SPL, so we don't get any clashes
			spl_autoload_register('__autoload');
		}
		//	Register ourselves with SPL
		return spl_autoload_register(array('PHPPowerPoint_Autoloader', 'Load'));
	}	//	function Register()


	/**
	 * Autoload a class identified by name
	 *
	 * @param	string	$pClassName		Name of the object to load
	 */
	public static function Load($pObjectName){
		if ((class_exists($pObjectName)) || (strpos($pObjectName, 'PHPPowerPoint') === False)) {
			//	Either already loaded, or not a PHPPowerPoint class request
			return FALSE;
		}

		$pObjectFilePath =	PHPPOWERPOINT_ROOT.
							str_replace('_',DIRECTORY_SEPARATOR,$pObjectName).
							'.php';

		if ((file_exists($pObjectFilePath) === false) || (is_readable($pObjectFilePath) === false)) {
			//	Can't load
			return FALSE;
		}

		require($pObjectFilePath);
	}	//	function Load()

}