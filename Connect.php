<?php

namespace Vendor\design_okno\skDYLAN\connect;

class Connect implements IConnect
{
    protected $useragent;
    protected $timeout;
    protected $connectTimeout;
    protected $head;
    protected $cookie_file;
    protected $cookie_session;
    protected $proxy_ip;
    protected $proxy_port;
    protected $proxy_type;
    protected $headers;
    protected $post;
    protected $countAttempt;
    protected $userPWD;

    public function __construct()
    {
        $this->useragent      = "Mozilla/5.0 (Windows NT 6.3; W…) Gecko/20100101 Firefox/57.0";
        $this->timeout        = 5;
        $this->connecttimeout = 5;
        $this->head           = false;

        $this->cookie_file    = false;
        $this->cookie_session = false;

        $this->proxy_ip   = false;
        $this->proxy_port = false;
        $this->proxy_type = false;

        $this->headers = false;

        $this->post = false;

        $this->countAttempt = 3;
    }

    public function setUseragent($useragent){
        $new = clone $this;
        $new->useragent = $useragent;
        return clone $new;
    }

    public function setTimeout($timeout){
        $new = clone $this;
        $new->timeout = $timeout;
        return clone $new;
    }

    public function setConnectTimeout($connectTimeout){
        $new = clone $this;
        $new->connectTimeout = $connectTimeout;
        return clone $new;
    }

    public function setHead($head){
        $new = clone $this;
        $new->useragent = $head;
        return clone $new;
    }

    public function setCookie_file($cookie_file){
        $new = clone $this;
        $new->cookie_file = $cookie_file;
        return clone $new;
    }

    public function setCookie_session($cookie_session){
        $new = clone $this;
        $new->cookie_session = $cookie_session;
        return clone $new;
    }

    public function setProxy_ip($proxy_ip){
        $new = clone $this;
        $new->proxy_ip = $proxy_ip;
        return clone $new;
    }

    public function setProxy_port($proxy_port){
        $new = clone $this;
        $new->proxy_port = $proxy_port;
        return clone $new;
    }

    public function setProxy_type($proxy_type){
        $new = clone $this;
        $new->proxy_type = $proxy_type;
        return clone $new;
    }

    public function setHeaders($headers){
        $new = clone $this;
        $new->headers = $headers;
        return clone $new;
    }

    public function setCountAttempt($count){
        $new = clone $this;
        $new->countAttempt = $count;
        return clone $new;
    }

    public function setPost($post){
        $new = clone $this;
        $new->post = $post;
        return clone $new;
    }

    public function setUserPWD($userPWD){
        $new = clone $this;
        $new->userPWD = $userPWD;
        return clone $new;
    }

    public function getCountAttempt(){
        return $this->countAttempt;
    }

    public function getUseragent(){
        return $this->useragent;
    }

    public function getTimeout(){
        return $this->timeout;
    }

    public function getConnectTimeout(){
        return $this->connectTimeout;
    }

    public function getHead(){
        return $this->head;
    }

    public function getCookie_file(){
        return $this->cookie_file;
    }

    public function getCookie_session(){
        return $this->cookie_session;
    }

    public function getProxy_ip(){
        return $this->proxy_ip;
    }

    public function getProxy_port(){
        return $this->proxy_port;
    }

    public function getProxy_type(){
        return $this->proxy_type;
    }

    public function getHeaders(){
        return $this->headers;
    }

    public function getPost(){
        return $this->post;
    }

    public function getUserPWD()
    {
        return $this->userPWD;
    }
}