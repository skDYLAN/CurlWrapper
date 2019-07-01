<?php


namespace Vendor\design_okno\skDYLAN\connect;

use Psr\Log\LoggerInterface;

interface IConnection
{
    public function getPage($url) : IRequest;

    public function setLogger(LoggerInterface $logger);
}