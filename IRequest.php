<?php


namespace Vendor\design_okno\skDYLAN\connect;


interface IRequest
{
    public function __construct($content, $info, $error);

    public function setContent($content);
    public function setError($error);
    public function setInfo($info);
    public function getContent();
    public function getError();
    public function getInfo();
}