<?php
namespace FMUP\Logger\Channel;

use FMUP\Logger\Channel;
use Monolog\Handler\SyslogHandler;

class Syslog extends Channel
{
    const NAME = 'Syslog';

    /**$
     * @return mixed
     */
    public function getName()
    {
        $split = explode('\\', get_class($this));
        return array_pop($split);
    }

    /**
     * @return $this
     */
    public function configure()
    {
        $this->getLogger()->pushHandler(new SyslogHandler($this->getName()));
        return $this;
    }
}
