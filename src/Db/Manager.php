<?php
namespace FMUP\Db;

use FMUP\Config;
use FMUP\Logger;
use FMUP\Db;

/**
 * Class Db
 * @package FMUP\Helper
 */
class Manager implements Logger\LoggerInterface
{
    use Logger\LoggerTrait;
    use Config\RequiredTrait;

    const DEFAULT_NAME = 'DEFAULT_NAME';
    private static $instance = null;
    private $instances = array();

    private function __construct()
    {
    }

    /**
     * @codeCoverageIgnore
     */
    private function __clone()
    {
    }

    /**
     * @param string $name
     * @return Db
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     */
    public function get($name = self::DEFAULT_NAME)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Name must be set');
        }
        $name = (string)$name;
        if (!isset($this->instances[$name])) {
            if ($name == self::DEFAULT_NAME) {
                $params = $this->getConfig()->get('parametres_connexion_db');
            } else {
                $dbSettings = $this->getConfig()->get('db');
                if (isset($dbSettings[$name])) {
                    $params = $dbSettings[$name];
                } else {
                    throw new \OutOfRangeException('Trying to access a database name ' . $name . ' that not exists');
                }
            }
            $instance = new Db((array)$params);
            if ($this->hasLogger()) {
                $instance->setLogger($this->getLogger());
            }
            $this->instances[$name] = $instance;
        }

        return $this->instances[$name];
    }

    /**
     * Close or change a connection by its name
     * @param string $name
     * @param Db|null $db
     * @return $this
     */
    public function set($name = self::DEFAULT_NAME, Db $db = null)
    {
        $this->instances[(string) $name] = $db;
        return $this;
    }

    /**
     * @return $this
     */
    final public static function getInstance()
    {
        if (!self::$instance) {
            $class = get_called_class();
            self::$instance = new $class();
        }
        return self::$instance;
    }
}
