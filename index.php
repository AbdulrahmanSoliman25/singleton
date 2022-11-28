<?php


class Singleton
{

    private static $instances = [];

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Can not serialize singleton");
    }

    public static function getInstance()
    {
        $subClass = static::class;
        if (!isset(self::$instances[$subClass])) {
            self::$instances[$subClass] = new static();
        }
        return self::$instances[$subClass];
    }
}


class logger extends Singleton
{
    private $fileHandle;

    protected function __construct()
    {
        $this->fileHandle = fopen('php://output', 'w');
    }

    public function writeLog(string $message): void
    {
        $date = date('Y-m-d H:i:s');
        fwrite($this->fileHandle, "$date: $message\n");
    }

    public function log(string $message): void
    {
        $logger = self::getInstance();
        $logger->writeLog($message);
    }
}



/**
 * test code.
 */
logger::log("Started!");

$firstLogger = Logger::getInstance();
$secondLogger = Logger::getInstance();

if ($firstLogger === $secondLogger) {
    Logger::log("Logger has a single instance.");
} else {
    Logger::log("Loggers are different.");
}
