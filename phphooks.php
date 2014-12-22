<?php
/**
 * @Author: Amin by
 * @Date:   2014-12-08 16:28:05
 * @Last Modified by:   Amin by
 * @Last Modified time: 2014-12-09 12:08:52
 */
class PHPHooks(){
  var $hooks = array();

  public function remove_all_hooks($hook_name) {
    if(array_key_exists($hook_name, $hooks))
      unset($this->hooks[$hook_name]);
  }

  public function remove_a_hook($hook_name, $hook_callable) {
    $callable_uuid = $this->callable_unique_id($hook_callable);
    foreach($this->hooks[$hook_name] as $k => $v) {
      
    }
  }

  public function run_a_hook($hook_name, $hook_args = array()) {
    if(is_object($hook_args))
      $hook_args = (array)$hook_args;
    if(!is_array($hook_args))
      throw new Exception("Arguments Not an Array when run a hook!");
    $hook_args = array_values($hook_args);

    count($hook_args) || $hook_args = array(null);
    if (!array_key_exists($hook_name, $hooks)) {
      return;
    }

    // sort by priorior
    ksort($hooks[$hook_name]);

    // execute
    foreach($hooks[$hook_name] as $priorior => $hfs) {
      foreach($hfs as $k => $_) {
        extract($_);
        $_args = array_slice($hook_args, 0, $accept_args);
        $hook_args[0] = call_user_func_array($callable, $_args);

        // unset if exected
        unset($hooks[$hook_name][$priorior][$k]);
      }
      // unset if ran
      unset($hooks[$hook_name][$priorior]);
    }
    // unset if ran
    unset($hooks[$hook_name]);
    return $hook_args[0];
  }

  public function callable_unique_id($fuc) {
    return md5(json_encode($hook_callable));
  }

  public function add_a_hook($hook_name, $hook_callable, $priorior = 10, $accept_args = 0) use($hooks) {
    if(array_key_exists($hook_name, $hooks)) {
      $hooks[$hook_name] = array();
    }
    if(array_key_exists($priorior, $hooks[$hook_name])) {
      $hooks[$hook_name][$priorior] = array();
    }

    $hooks[$hook_name][$priorior][] = array(
      'uuid' => $this->callable_unique_id($hook_callable);
      'callable' => $hook_callable,
      'accept_args' => $accept_args
      );
    return;
  }
}
/*
function phphooks_core() {
  static $hooks = array();

  static $misc;
  if(is_null($misc)){
    $misc = array(
      'remove_all_hooks' => function($hook_name) use ($hooks) {
        unset($hooks[$hook_name]);
      },
      'remove_a_hook' => function($hook_name, $hook_callable) use ($hooks) {
        // unimplement
      },
      'run_hook' => function($hook_name, $hook_args = array()) use ($hooks) {
        if(is_object($hook_args))
          $hook_args = (array)$hook_args;
        if(!is_array($hook_args))
          throw new Exception("Arguments Not an Array when run a hook!");
        $hook_args = array_values($hook_args);

        count($hook_args) || $hook_args = array(null);
        if (!array_key_exists($hook_name, $hooks)) {
          return;
        }

        // sort by priorior
        ksort($hooks[$hook_name]);

        // execute
        foreach($hooks[$hook_name] as $priorior => $hfs) {
          foreach($hfs as $k => $_) {
            extract($_);
            $_args = array_slice($hook_args, 0, $accept_args);
            $hook_args[0] = call_user_func_array($callable, $_args);

            // unset if exected
            unset($hooks[$hook_name][$priorior][$k]);
          }
          // unset if ran
          unset($hooks[$hook_name][$priorior]);
        }
        // unset if ran
        unset($hooks[$hook_name]);
        return $hook_args[0];
      },
      'unique_id' => function($func) {
      },
      'add_a_hook' => function($hook_name, $hook_callable, $priorior = 10, $accept_args = 0) use($hooks) {
        if(array_key_exists($hook_name, $hooks)) {
          $hooks[$hook_name] = array();
        }
        if(array_key_exists($priorior, $hooks[$hook_name])) {
          $hooks[$hook_name][$priorior] = array();
        }
        $hook_callable_uuid = "";// TODO
        $hooks[$hook_name][$priorior][] = array(
          'uuid' => $hook_callable_uuid,
          'callable' => $hook_callable,
          'accept_args' => $accept_args
          );
        return;
      }
    );
  }

  // return false if no args
  if( func_num_args() < 1 ) {
    return false;
  }

  // return first argument if that is not a scalar such as string, numeric
  $args = func_get_args();
  $arg_0 = array_shift($args);
  if(!is_scalar($arg_0))
    return $arg_0;

  // execute hook without arguments if without any other arguments
  if(!count($args)) {
    return $misc['run_hook']($arg_0);
  }

  $arg_1 = array_shift($args);
  if(!is_callable($arg_1)) {

    // execute hook with arguments if arg_1 is object or array
    if( is_object($arg_1) || is_array($arg_1) ) {
      return $misc['run_hook']($arg_0, $arg_1);
    }

    // arg_1 is a command if that is a scalar but not a callable string
    switch($arg_1) {
      case "remove":

        // remove all hooks if without object to remove
        if(!count($args)) {
          return $misc['remove_all_hook']($arg_0);
        }

        // remove a hook
        $arg_2 = array_shift($args);
        return $misc['remove_a_hook']($arg_0, $arg_2);

      case 'run':
        return $misc['run_a_hook']($arg_0, $args);

      default:
        throw new Execption("Wrong Argument 1 for phphooks_core()! Mode 'Command'.");
        return false;
    }
  }

  // add a hook
  array_unshift($args, $arg_1);
  array_unshift($args, $arg_0);
  return call_user_func_array($misc['add_a_hook'], $args)
}*/
