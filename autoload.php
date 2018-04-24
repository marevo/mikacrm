<?php
/**
 * Created by PhpStorm.
 * User: marevo
 * Date: 21.06.2017
 * Time: 19:36
 */
function __autoload($class){
    //App\Models\Supplier =>./App/Models/Supplier.php
	//set_error_handler(function(){debug_print_backtrace();});
    include_once  __DIR__.'/'.str_replace('\\','/' ,$class ).'.php';
//	include __DIR__.'\\'.$class.'.php';
	//debug_print_backtrace();
	//restore_error_handler();
}