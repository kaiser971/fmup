<?php
namespace FMUP;


abstract class Controller extends \Controller
{
    private $request;
    private $response;
    private $dbInstance;

    /**
     * @return Request
     */
    public function getRequest()
    {
        if (!$this->request) {
            $this->request = new Request();
        }
        return $this->request;
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        if (!$this->response) {
            $this->response = new Response();
        }
        return $this->response;
    }

    /**
     * @param Response $response
     * @return $this
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return Helper\Db
     */
    public function getDb()
    {
        if (!$this->dbInstance) {
            $this->dbInstance = Helper\Db::getInstance();
        }
        return $this->dbInstance;
    }
}