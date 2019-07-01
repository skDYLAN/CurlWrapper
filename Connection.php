<?php
/**
 * Created by PhpStorm.
 * User: skdylan
 * Date: 20.03.19
 * Time: 19:07
 */

namespace Vendor\design_okno\skDYLAN\connect;

use Psr\Log\LoggerInterface;

class Connection implements IConnection
{
    protected $connect;

    /**
     * @var LoggerInterface $logger
     */
    protected $logger;
    /**
     * @var array
     */
    private static $arErrorCodes = [
        "CURLE_UNSUPPORTED_PROTOCOL",
        "CURLE_FAILED_INIT",
        "CURLE_URL_MALFORMAT",
        "CURLE_URL_MALFORMAT_USER",
        "CURLE_COULDNT_RESOLVE_PROXY",
        "CURLE_COULDNT_RESOLVE_HOST",
        "CURLE_COULDNT_CONNECT",
        "CURLE_FTP_WEIRD_SERVER_REPLY",
        "CURLE_REMOTE_ACCESS_DENIED",
        "CURLE_FTP_WEIRD_PASS_REPLY",
        "CURLE_FTP_WEIRD_PASV_REPLY",
        "CURLE_FTP_WEIRD_227_FORMAT",
        "CURLE_FTP_CANT_GET_HOST",
        "CURLE_FTP_COULDNT_SET_TYPE",
        "CURLE_PARTIAL_FILE",
        "CURLE_FTP_COULDNT_RETR_FILE",
        "CURLE_QUOTE_ERROR",
        "CURLE_HTTP_RETURNED_ERROR",
        "CURLE_WRITE_ERROR",
        "CURLE_UPLOAD_FAILED",
        "CURLE_READ_ERROR",
        "CURLE_OUT_OF_MEMORY",
        "CURLE_OPERATION_TIMEDOUT",
        "CURLE_FTP_PORT_FAILED",
        "CURLE_FTP_COULDNT_USE_REST",
        "CURLE_RANGE_ERROR",
        "CURLE_HTTP_POST_ERROR",
        "CURLE_SSL_CONNECT_ERROR",
        "CURLE_BAD_DOWNLOAD_RESUME",
        "CURLE_FILE_COULDNT_READ_FILE",
        "CURLE_LDAP_CANNOT_BIND",
        "CURLE_LDAP_SEARCH_FAILED",
        "CURLE_FUNCTION_NOT_FOUND",
        "CURLE_ABORTED_BY_CALLBACK",
        "CURLE_BAD_FUNCTION_ARGUMENT",
        "CURLE_INTERFACE_FAILED",
        "CURLE_TOO_MANY_REDIRECTS",
        "CURLE_UNKNOWN_TELNET_OPTION",
        "CURLE_TELNET_OPTION_SYNTAX",
        "CURLE_PEER_FAILED_VERIFICATION",
        "CURLE_GOT_NOTHING",
        "CURLE_SSL_ENGINE_NOTFOUND",
        "CURLE_SSL_ENGINE_SETFAILED",
        "CURLE_SEND_ERROR",
        "CURLE_RECV_ERROR",
        "CURLE_SSL_CERTPROBLEM",
        "CURLE_SSL_CIPHER",
        "CURLE_SSL_CACERT",
        "CURLE_BAD_CONTENT_ENCODING",
        "CURLE_LDAP_INVALID_URL",
        "CURLE_FILESIZE_EXCEEDED",
        "CURLE_USE_SSL_FAILED",
        "CURLE_SEND_FAIL_REWIND",
        "CURLE_SSL_ENGINE_INITFAILED",
        "CURLE_LOGIN_DENIED",
        "CURLE_TFTP_NOTFOUND",
        "CURLE_TFTP_PERM",
        "CURLE_REMOTE_DISK_FULL",
        "CURLE_TFTP_ILLEGAL",
        "CURLE_TFTP_UNKNOWNID",
        "CURLE_REMOTE_FILE_EXISTS",
        "CURLE_TFTP_NOSUCHUSER",
        "CURLE_CONV_FAILED",
        "CURLE_CONV_REQD",
        "CURLE_SSL_CACERT_BADFILE",
        "CURLE_REMOTE_FILE_NOT_FOUND",
        "CURLE_SSH",
        "CURLE_SSL_SHUTDOWN_FAILED",
        "CURLE_AGAIN",
        "CURLE_SSL_CRL_BADFILE",
        "CURLE_SSL_ISSUER_ERROR",
        "CURLE_FTP_PRET_FAILED",
        "CURLE_FTP_PRET_FAILED",
        "CURLE_RTSP_CSEQ_ERROR",
        "CURLE_RTSP_SESSION_ERROR",
        "CURLE_FTP_BAD_FILE_LIST",
        "CURLE_CHUNK_FAILED"
    ];

    public function __construct(IConnect $connect)
    {
        $this->connect = $connect;
    }

    function curlInit($url){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_USERAGENT, $this->connect->getUseragent());
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->connect->getTimeout());
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connect->getConnectTimeout());

        if($this->connect->getHead()){
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
        }
        if(strpos($url, "https") !== false){

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        }
        if($this->connect->getCookie_file()){
            curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__."/../temp/".$this->connect->getCookie_file());
            curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__."/../temp/".$this->connect->getCookie_file());
            if($this->connect->getCookie_session()){
                curl_setopt($ch, CURLOPT_COOKIESESSION, true);
            }
        }

        if($this->connect->getProxy_ip() && $this->connect->getProxy_port() && $this->connect->getProxy_type()){

            curl_setopt($ch, CURLOPT_PROXY, $this->connect->getProxy_ip().":".$this->connect->getProxy_port());
            curl_setopt($ch, CURLOPT_PROXYTYPE, $this->connect->getProxy_type());
        }

        if($this->connect->getHeaders()){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->connect->getHeaders());
        }

        if($this->connect->getUserPWD()){
            curl_setopt($ch, CURLOPT_USERPWD, $this->connect->getUserPWD());
        }

        return $ch;
    }

    /**
     * @param $url
     * @param bool $post
     * @return IRequest
     */
    public function getPage($url, $post = false) : IRequest{
        if($url){
            $funcConnect = function ($url, $post) {
                $ch = $this->curlInit($url);
                if ($post)
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

                $content = curl_exec($ch);
                $info = curl_getinfo($ch);

                if ($content === false) {
                    $data = false;
                    $data["content"] = curl_error($ch);
                    $data["error"] = true;
                    $data["info"] = self::$arErrorCodes[curl_errno($ch)];
                    $this->sendToLog("Connection Error! CODE:[".$data['info']."]");
                    //throw new Exception("Connection Error! CODE:[".$data['info']."]");
                    exit();
                } else {
                    $data["content"] = $content;
                    $data["info"] = $info;
                    $data["error"] = false;
                }

                curl_close($ch);
                return new Request($data["content"], $data["info"], $data["error"]);
            };

//            $countAttempt = 1;
//            $data = new Request([],[], false);
//            while($countAttempt != $this->connect->getCountAttempt() || $data->getError() !== false){
//                $countAttempt++;
//                $data = $funcConnect($url,$post);
//            }

            $data = $funcConnect($url,$post);

            return $data;
        }
        return new Request("", "", true);
    }

    public function setLogger(LoggerInterface $logger){
        $new = clone $this;
        $new->logger = $logger;
        return clone $new;
    }

    private function sendToLog($string){
        if($this->logger)
            $this->logger->error($string);
    }

}