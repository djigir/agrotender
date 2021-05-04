<?php
namespace Core;

/**
 * 
 */
abstract class Controller {

  /**
   * Calling the model
   *
   * @return object
   */
  public function model($modelName) {
  	$modelName = ucfirst($modelName);
  	// New Model Class
    $class      = new \ReflectionClass("App\models\\{$modelName}");
    $object     = $class->newInstance();
    return $object;
  } 

  public function __get($variable) {
    switch ($variable) {
      // Variable for ajax connection
      case 'action':
        return $this->request->post['action'] ?? null;
        break;

      default:
        if (property_exists($this, $variable)) {
          return $this->$variable;
        } else {
          throw new Fail("The \"{$variable}\" variable does not exist");
        }
        break;
    }
  }

}
