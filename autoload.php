<?php
/**
 * 以命名空间全名文件的自动加载
 * @param  [type] $className [description]
 * @return [type]            [description]
 */
namespace SPACE;

function autoload($className)
  {
  $thisClass = str_replace(__NAMESPACE__.'\\', '', __CLASS__);

  $baseDir = __DIR__;

  if (substr($baseDir, -strlen($thisClass)) === $thisClass) {
    $baseDir = substr($baseDir, 0, -strlen($thisClass));
  }

  $className = ltrim($className, '\\');
  $fileName  = $baseDir;
  $namespace = '';
  if ($lastNsPos = strripos($className, '\\')) {
    $namespace = substr($className, 0, $lastNsPos);
    $className = substr($className, $lastNsPos + 1);
    $fileName  .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
  }
  $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

  if (file_exists($fileName)) {
    require $fileName;
  }
}

function registerAutoloader(){
  spl_autoload_register(__NAMESPACE__ . "\\autoload");
}