<?php


namespace Vendor\design_okno\skDYLAN\connect;

interface IConnect
{
    public function getUseragent();

    public function getTimeout();

    public function getConnectTimeout();

    public function getHead();

    public function getCookie_file();

    public function getCookie_session();

    public function getProxy_ip();

    public function getProxy_port();

    public function getProxy_type();

    public function getHeaders();

    public function getPost();

    public function getCountAttempt();

    public function getUserPWD();
}