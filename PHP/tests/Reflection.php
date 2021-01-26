<?php
final class ReflectionExecuter
{

  public static function getPrivateMethod( $className, $methodName ) {
		    $reflector = new ReflectionClass( $className );
		    $method = $reflector->getMethod( $methodName );
		    $method->setAccessible( true );

		    return $method;
	}

  public static function getPrivateProperty( $className, $propertyName ) {
		$reflector = new ReflectionClass( $className );
		$property = $reflector->getProperty( $propertyName );
		$property->setAccessible( true );

		return $property;
	}

  public static function getParameterType($className, $methodName){
    $reflector = new ReflectionClass($className);

    foreach ($reflector->getMethod($methodName)->getParameters() as $param) {
      // param type hint (or null, if not specified).
      return $param->getType()->getName();
    }
  }
}
