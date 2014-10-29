<?php

// password
function password($password, $salt=null) {
  is_null($salt) && $salt = "hellowold";
  return sha1(sha1($password . $salt).$salt);
}

// uuid
function uuid() {
  return strtoupper( md5(uniqid(mt_rand(), true)) );
}

// uuid for windows format
function win_uuid() {
  $charid = strtoupper( md5(uniqid(mt_rand(), true)) );

  return '{' . implode('-', array(
    substr($charid, 0, 8),
    substr($charid, 8, 4),
    substr($charid,12, 4),
    substr($charid,16, 4),
    substr($charid,20,12),
    )) . '}';
}