<?php
namespace Core;

/**
 * 
 */
abstract class Model {

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
    $class      = new \ReflectionClass("Core\\Engine");
    // Instanse Controller class without constructor
    $object     = $class->newInstanceWithoutConstructor();
    $object->handler(get_object_vars($object)['handlers'], $this);
    
    switch ($variable) {
      // Variable for ajax connection
      case 'action':
        return $this->request->post['action'];
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