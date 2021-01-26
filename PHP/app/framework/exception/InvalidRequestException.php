<?php
namespace app\framework\exception;
require_once(dirname(__FILE__,1) . '/NullPointerException.php');
class  InvalidRequestException extends NullPointerException{
    public function __construct(String $message = 'The url contains data that is not allowed', int $code = 0, Exception $previous = null){
        parent::__construct($message, $code, $previous);
    }
}
?>
