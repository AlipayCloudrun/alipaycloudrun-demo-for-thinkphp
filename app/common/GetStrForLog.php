<?php

namespace app\common;

class GetStrForLog
{
  public function getStr($begin, $rs)
  {
    $pid = (string)posix_getpid() . ',' . $_SERVER['REQUEST_URI'] . ',' . (string)(time() - $begin) . 'ms,' . $rs . ',' . file_get_contents("php://input");
    return $pid;
  }
}
