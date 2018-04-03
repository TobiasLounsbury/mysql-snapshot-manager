<?php
/**
 * Generated by Toby.
 *
 * @link https://github.com/herrera-io/php-box/
 */
if (class_exists('Phar')) {

  if (php_sapi_name() == "cli") {
    //echo "#!/usr/bin/env php";
    Phar::mapPhar('default.phar');
    require 'phar://' . __FILE__ . '/cli.php';
  } else {
    Phar::webPhar("", "index.php");
    Phar::interceptFileFuncs();
    Phar::mungServer(array('REQUEST_URI'));

    define("MSNAP_PREFIX", "msnap.phar");
    require 'phar://' . __FILE__ . '/index.php';
  }
}
__HALT_COMPILER(); ?>