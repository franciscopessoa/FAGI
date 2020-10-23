<?php

namespace AGI;

class Connection
{
    private $input;
    private $output;

    /**
     * __construct
     *
     * @return void
     */
    protected function __construct()
    {
        $this->open();
    }

    /**
     * send
     *
     * @param  mixed $text
     *
     * @return void
     */
    public function send($text)
    {
        $text .= "\n";
        $len = strlen($text);
        $res = fwrite($this->output, $text) === $len;
        if ($res != true) {
            return false;
        }
        do {
            $res = $this->read();
        } while (strlen($res) < 2);
        return $this->formatResponse($res);
    }

    /**
     * formatResponse
     *
     * @param  mixed $text
     *
     * @return void
     */
    public function formatResponse($text)
    {
        $line   = $text;
        $result = false;
        $data   = false;

        $response = explode(' ', $line);
        $code     = $response[0];
        $result   = explode('=', $response[1]);

        if (isset($result[1])) {
            $result = $result[1];
        }

        if (isset($response[2])) {
            unset($response[0]);
            unset($response[1]);
            $data = implode(' ', (array) $response);
            $data = substr($data, 0, 1) == '(' ? substr($data, 1) : $data;
            $data = substr($data, -1) == ')' ? substr($data, 0, -1) : $data;
        }

        return [
            'data' => $data,
            'code' => $code,
            'result' => $result
        ];
    }

    /**
     * open
     *
     * @return void
     */
    protected function open()
    {
        if (isset($this->options['stdin'])) {
            $this->input = $this->options['stdin'];
        } else {
            $this->input = fopen('php://stdin', 'r');
        }
        if (isset($this->options['stdout'])) {
            $this->output = $this->options['stdout'];
        } else {
            $this->output = fopen('php://stdout', 'w');
        }
        while (true) {
            $line = $this->read($this->input);
            if ($this->isEndOfEnvironmentVariables($line)) {
                break;
            }
        }
    }

    /**
     * isEndOfEnvironmentVariables
     *
     * @param  mixed $line
     *
     * @return void
     */
    protected function isEndOfEnvironmentVariables($line)
    {
        return strlen($line) < 1;
    }

    /**
     * close
     *
     * @return void
     */
    protected function close()
    {
        if ($this->input !== false) {
            fclose($this->input);
        }
        if ($this->output !== false) {
            fclose($this->output);
        }
    }

    /**
     * read
     *
     * @return void
     */
    protected function read()
    {
        $line = fgets($this->input);
        if ($line === false) {
            return false;
        }
        $line = substr($line, 0, -1);
        return $line;
    }

    /**
     * __destruct
     *
     * @return void
     */
    protected function __destruct()
    {
        $this->close();
    }
}
