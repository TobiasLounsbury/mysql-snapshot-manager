<?php
function read_settings() {

  $settings = array();
  // Assimilate files. In order of lowest-priority to highest-priority.
  $files = array(
      __DIR__ . '/settings.dist.php', // Bundled defaults
      getenv('HOME') . '/.msnap.php', // Unix
      getenv('USERPROFILE') . '/.msnap.php',  // Win
      __DIR__ . '/settings.php', // Defaults for this particular installation
      getenv('MSNAP_SETTINGS'), // Allow CLI users to fully specify their own settings
  );
  foreach ($files as $file) {
    if (is_readable($file)) {
      $settings = array_merge($settings, @include $file);
    }
  }


  // (Maybe) Assimilate env vars
  // $keys = array('STORAGE_PATH', 'MYSQL_HOST', ...);
  // foreach ($keys as $key) {
  //   if (getenv("MSNAP_$key")) {
  //     $settings[$key] = getenv("MSNAP_$key");
  //   }
  // }


  return $settings;
}