<?php


namespace Vendor\design_okno\skDYLAN\connect;


class Request implements IRequest
{
    protected $error;
    protected $content;
    protected $info;

    public function __construct($content, $info, $error)
    {
        $this->content = $content;
        $this->info = $info;
        $this->error = $error;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setInfo($info)
    {
        $this->info = $info;
    }

    public function setError($error)
    {
        $this->error = $error;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function getError()
    {
        return $this->error;
    }
}