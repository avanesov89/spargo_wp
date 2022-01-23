<?php
define('THEME_DIR', get_template_directory() . '/');
define('THEME_URI', get_template_directory_uri() . '/');
define('THEME_ASSETS', THEME_URI . 'assets/');
define('THEME_CLASSES', THEME_DIR . 'classes/');
define('THEME_PARTS', THEME_DIR . 'templates/');
define('THEME_NAME', 'spargo');
define('DS', DIRECTORY_SEPARATOR);

class Theme_Autoload
{
  private $classes = [];

  public function __construct()
  {
  }

  public static function init()
  {
    require THEME_CLASSES . 'vendor/autoload.php';

    $self = new self;

    $classesFiles = scandir(THEME_CLASSES);

    foreach ($classesFiles as $class) {
      if (is_file(THEME_CLASSES . $class)) {

        $file_parts = pathinfo(THEME_CLASSES . $class);

        if ($file_parts['extension'] == 'php') {
          require_once THEME_CLASSES . $class;

          $pathName = explode('-', $class);

          $className = 'Theme_';

          foreach ($pathName as $pathPart) {
            if ($pathPart == 'class' || $pathPart == 'theme') continue;

            $className .= ucfirst(str_replace('.php', '', $pathPart));

            $self->classes[str_replace('.php', '', $pathPart)] = $className;
          }
        }
      }
    }
  }

  public static function getClass($name)
  {
    $self = new self;

    if (isset($self->classes[$name])) {
      $class = new $self->classes[$name]();
    } else {
      $class = false;
    }

    return $class;
  }
}
