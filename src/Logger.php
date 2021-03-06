<?php
namespace FMUP;

class Logger
{
    use Environment\OptionalTrait {
        getEnvironment as getEnvironmentTrait;
    }
    use Config\OptionalTrait;
    /**
     * Detailed debug information
     */
    const DEBUG = \Monolog\Logger::DEBUG;

    /**
     * Interesting events
     *
     * Examples: User logs in, SQL logs.
     */
    const INFO = \Monolog\Logger::INFO;

    /**
     * Uncommon events
     */
    const NOTICE = \Monolog\Logger::NOTICE;

    /**
     * Exceptional occurrences that are not errors
     *
     * Examples: Use of deprecated APIs, poor use of an API,
     * undesirable things that are not necessarily wrong.
     */
    const WARNING = \Monolog\Logger::WARNING;

    /**
     * Runtime errors
     */
    const ERROR = \Monolog\Logger::ERROR;

    /**
     * Critical conditions
     *
     * Example: Application component unavailable, unexpected exception.
     */
    const CRITICAL = \Monolog\Logger::CRITICAL;

    /**
     * Action must be taken immediately
     *
     * Example: Entire website down, database unavailable, etc.
     * This should trigger the SMS alerts and wake you up.
     */
    const ALERT = \Monolog\Logger::ALERT;

    /**
     * Urgent alert.
     */
    const EMERGENCY = \Monolog\Logger::EMERGENCY;


    private $instances = array();
    /**
     * @var Request
     */
    private $request;


    protected $factory;

    /**
     * @return Logger\Factory
     */
    public function getFactory()
    {
        if (!$this->factory) {
            $this->factory = Logger\Factory::getInstance();
        }
        return $this->factory;
    }

    /**
     * @param Logger\Factory $factory
     * @return $this
     */
    public function setFactory(Logger\Factory $factory)
    {
        $this->factory = $factory;
        return $this;
    }

    /**
     * @param string $instanceName
     * @return Logger\Channel
     */
    public function get($instanceName)
    {
        $instanceName = (string)$instanceName;
        if (!isset($this->instances[$instanceName])) {
            $channel = $this->getFactory()->getChannel($instanceName);
            $channel->setConfig($this->getConfig())->setEnvironment($this->getEnvironment());
            $this->instances[$instanceName] = $channel;
        }
        return $this->instances[$instanceName];
    }

    /**
     * @param Logger\Channel $logger
     * @param string $instanceName
     * @return $this
     */
    public function set(Logger\Channel $logger, $instanceName)
    {
        $instanceName = (string)$instanceName;
        if (!is_null($logger) && !is_null($instanceName)) {
            $this->instances[$instanceName] = $logger;
        }
        return $this;
    }

    /**
     * Define HTTP request object
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * Retrieve defined HTTP request object
     * @return Request
     * @throws \LogicException if no request has been set
     */
    public function getRequest()
    {
        if (!$this->request) {
            throw new \LogicException('Request is not defined');
        }
        return $this->request;
    }

    /**
     * @return Environment
     */
    public function getEnvironment()
    {
        if (!$this->hasEnvironment()) {
            $environment = Environment::getInstance();
            $this->setEnvironment($environment->setConfig($this->getConfig()));
        }
        return $this->getEnvironmentTrait();
    }

    /**
     * Add log Record
     * @param string $channel
     * @param int $level
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function log($channel, $level, $message, array $context = array())
    {
        $channel = (string)$channel;
        $message = (string)$message;
        $level = (int)($level <= 0 ? self::ALERT : $level);
        $channelType = $this->get($channel);
        if ($channelType->getName() === Logger\Channel\Standard::NAME) {
            $message = "[Channel $channel] $message";
        }
        return $channelType->addRecord((int)$level, $message, (array)$context);
    }
}
