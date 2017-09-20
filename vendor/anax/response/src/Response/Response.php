<?php

namespace Anax\Response;

/**
 * Handling a response.
 */
class Response
{
    /**
    * @var array $headers    set all headers to send.
    * @var array $statusCode set statuscode to use.
    * @var array $body       body to send with response.
    */
    private $headers = [];
    private $statusCode;
    private $body;



    /**
     * @var array $validStatusCode these status codes are supported.
     */
    private $validStatusCode = [
        "200" => "HTTP/1.1 200 OK",
        "400" => "HTTP/1.1 400 Bad Request",
        "403" => "HTTP/1.1 403 Forbidden",
        "404" => "HTTP/1.1 404 Not Found",
        "405" => "HTTP/1.1 405 Method Not Allowed",
        "418" => "HTTP/1.1 418 I'm a teapot",
        "500" => "HTTP/1.1 500 Internal Server Error",
        "501" => "HTTP/1.1 501 Not Implemented",
    ];



    /**
     * Set status code to be sent as part of headers.
     *
     * @param string $header type of header to set
     *
     * @return $this
     */
    public function setStatusCode($value)
    {
        if (!array_key_exists($value, $this->validStatusCode)) {
            throw new Exception("Unsupported statuscode: $value");
        }
        $this->statusCode = $value;
    }



    /**
     * Set headers.
     *
     * @param string $header type of header to set
     *
     * @return $this
     */
    public function addHeader($header)
    {
        $this->headers[] = $header;
    }



    /**
     * Check if headers are already sent and throw exception if it is.
     *
     * @return void
     *
     * @throws Exception
     */
    public function checkIfHeadersAlreadySent()
    {
        if (headers_sent($file, $line)) {
            throw new Exception("Try to send headers but headers already sent, output started at $file line $line.");
        }
    }



    /**
     * Send headers.
     *
     * @return $this
     */
    public function sendHeaders()
    {
        $this->checkIfHeadersAlreadySent();

        if (isset($this->statusCode)) {
            header($this->validStatusCode[$this->statusCode]);
        }

        foreach ($this->headers as $header) {
            header($header);
        }

        return $this;
    }



    /**
     * Set the body.
     *
     * @param callable|string $body either a string or a callable that
     *                              can generate the body.
     *
     * @return this
     */
    public function setBody($body)
    {
        if (is_string($body)) {
            $this->body = $body;
        } elseif (is_callable($body)) {
            ob_start();
            $res1 = call_user_func($body);
            $res2 = ob_get_contents();
            $this->body = $res2 . $res1;
            ob_end_clean();
        }
        return $this;
    }



    /**
     * Get the body.
     *
     * @return void
     */
    public function getBody()
    {
        return $this->body;
    }



    /**
     * Send response with an optional statuscode.
     *
     * @param integer $statusCode optional statuscode to send.
     *
     * @return void
     */
    public function send($statusCode = null)
    {
        if ($statusCode) {
            $this->setStatusCode($statusCode);
        }

        if (!headers_sent()) {
            $this->sendHeaders();
        }
        echo $this->getBody();
    }



    /**
     * Send JSON response with an optional statuscode.
     *
     * @param mixed   $data       to be encoded as json.
     * @param integer $statusCode optional statuscode to send.
     *
     * @return void
     */
    public function sendJson($data, $statusCode = null)
    {
        if ($statusCode) {
            $this->setStatusCode($statusCode);
        }

        if (!headers_sent()) {
            $this->addHeader("Content-Type: application/json; charset=utf8");
            $this->sendHeaders();
        }
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }



    /**
     * Redirect to another page.
     *
     * @param string $url to redirect to
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.ExitExpression)
     */
    public function redirect($url)
    {
        $this->checkIfHeadersAlreadySent();
        header("Location: " . $url);
        exit;
    }
}
