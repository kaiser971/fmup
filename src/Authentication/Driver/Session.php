<?php
namespace FMUP\Authentication\Driver;

use FMUP\Authentication\DriverInterface;
use FMUP\Authentication\UserInterface;

/**
 * Description of Session
 *
 * @author sweffling
 */
class Session implements DriverInterface
{
    private $session;

    /**
     * @return \FMUP\Session
     */
    public function getSession()
    {
        if (!$this->session) {
            $this->session = \FMUP\Session::getInstance();
        }
        return $this->session;
    }

    /**
     * @param \FMUP\Session $session
     * @return $this
     */
    public function setSession(\FMUP\Session $session)
    {
        $this->session = $session;
        return $this;
    }

    /**
     * Add a user in session
     * @param UserInterface $user
     * @return $this
     */
    public function set(UserInterface $user)
    {
        $this->getSession()->set(__CLASS__, $user);
        return $this;
    }

    /**
     * Get the user in the session
     * @return UserInterface|null $user
     */
    public function get()
    {
        return $this->getSession()->get(__CLASS__);
    }

    /**
     * Clear the session from user
     * @return $this
     */
    public function clear()
    {
        $this->getSession()->remove(__CLASS__);
        return $this;
    }
}
