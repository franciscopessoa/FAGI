<?php

namespace AGI;

class Commands extends Connection implements ICommands
{
    /**
     * __construct inicia um socket de comunicação com o asterisk
     * @link https://wiki.asterisk.org/wiki/display/AST/Asterisk+Standard+Channel+Variables for channel variables
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * answer atende a chamada corrente
     *
     * @return void
     */
    public function answer()
    {
        $this->execute("ANSWER");
    }

    /**
     * hangup desliga o canal da chamada especificada, caso não especificado, ecerra o canal atual
     *
     * @param  string $channel
     *
     * @return void
     */
    public function hangup($channel = '')
    {
        $this->execute("HANGUP $channel");
    }

    /**
     * getCallerID get callerID of call
     * 
     * @param  mixed $param all | ani | ani2 | dnid | name | num | rdnis
     *
     * @return void
     */
    public function getCallerID($param = 'all')
    {
        return $this->getVariable('CALLERID' . '(' . $param . ')', true);
    }

    /**
     * getChannel get current channel name
     * 
     * @return void
     */
    public function getChannel()
    {
        return $this->getVariable('CHANNEL', true);
    }

    /**
     * getContext get current context
     *
     * @return void
     */
    public function getContext()
    {
        return $this->getVariable('CONTEXT', true);
    }

    /**
     * getEpoch get current 
     *
     * @return void
     */
    public function getExten()
    {
        return $this->getVariable('EXTEN', true);
    }

    /**
     * getExten get current priority in the dialplan
     *
     * @return void
     */
    public function getPriority()
    {
        return $this->getVariable('PRIORITY', true);
    }

    /**
     * getEpoch get current unix style epoch
     *
     * @return void
     */
    public function getEpoch()
    {
        return $this->getVariable('EPOCH', true);
    }

    /**
     * getEpoch get current call unique identifier
     *
     * @return void
     */
    public function getUniqueid()
    {
        return $this->getVariable('UNIQUEID', true);
    }

    /**
     * getUserfield get current call userfield
     *
     * @return void
     */
    public function getUserfield($field = 'FILE')
    {
        return $this->getVariable($field, true);
    }

    /**
     * getQueueWaitingCount busca a quantidade de chamadas em espera na fila
     *
     * @param  mixed $queue
     *
     * @return void
     */
    public function getQueueWaitingCount($queue)
    {
        return $this->getVariable("QUEUE_WAITING_COUNT($queue)", true);
    }

    /**
     * getQueueMemberCount busca a quantidade de agentes logados na fila
     *
     * @param  mixed $queue
     *
     * @return void
     */
    public function getQueueMemberCount($queue)
    {
        return $this->getVariable("QUEUE_MEMBER_COUNT($queue)", true);
    }

    /**
     * getVariable busca uma váriavel específica do canal atual
     *
     * @param  mixed $variable variavel a ser buscada
     * @param  mixed $data se setado como true retorna apenas o valor
     *
     * @return void
     */
    public function getVariable($variable, $returnData = false)
    {
        $result = $this->execute("GET VARIABLE $variable");
        return $returnData ? $result['data'] : $result;
    }

    /**
     * dial
     *
     * @param  mixed $dial
     *
     * @return void
     */
    public function dial($dial)
    {
        return $this->execApplication("DIAL $dial");
    }

    /**
     * noop mostra na CLI um dado específico
     *
     * @param  mixed $text texto a ser exibido
     *
     * @return void
     */
    public function noop($text)
    {
        return $this->execApplication("NOOP " . $text);
    }

    /**
     * playback executa um arquivo de áudio especificado
     *
     * @param  string $filename arquivo de áudio (localizado em /var/lib/asterisk/sounds/)
     * @param  array $options opções de parametros para o playback
     *
     * @return void
     */
    public function playback($filename, $options = [])
    {
        $options = count($options) ? ',' . implode(',', $options) : '';
        return $this->execApplication("Playback " . trim($filename) . $options);
    }

    /**
     * queue
     *
     * @param  mixed $queue
     * @param  mixed $options
     *
     * @return void
     */
    public function queue($queue, $options = '')
    {
        if (!empty($options) && substr($options, 0, 1) != ',') $options = ',' . $options;
        return $this->execApplication("Queue " . trim($queue) . trim($options));
    }

    /**
     * goto
     *
     * @param  mixed $context
     * @param  mixed $exten
     * @param  mixed $priority
     * @return void
     */
    public function gotoContext($context, $exten, $priority = '1')
    {
        return $this->execApplication("GOTO " . trim($context) . ',' . trim($exten) . ',' . $priority);
    }

    /**
     * getCDRVariable
     *
     * @param  mixed $variable
     *
     * @return void
     */
    public function getCDRVariable($variable)
    {
        return $this->getVariable('CDR(' . strtoupper(trim($variable)) . ')', true);
    }

    /**
     * getData executa um arquivo de áudio e aguarda a entrada de dígitos
     *
     * @param  string $filename arquivo de áudio a ser executado
     * @param  int | null $timeout tempo limite (em milisegundos) para serem informados os digítos
     * @param  int | null $maxdigits maximo de digitos a serem reconhecidos
     * @param  bolean $result caso true retornará somente o valor digitado
     *
     * @return void
     */
    public function getData($filename, $timeout = null, $maxdigits = null, $result = false)
    {
        $data = $this->execute("GET DATA $filename $timeout $maxdigits");
        return $result ? $data['result'] : $data;
    }

    /**
     * channelStatus retorna o status do canal especificado
     *
     * @param  mixed $channel canal da ligacao
     *
     * @return void
     */
    public function channelStatus($channel = '')
    {
        return $this->execute("CHANNEL STATUS $channel");
    }

    /**
     * setVariable
     *
     * @param  mixed $variable
     * @param  mixed $value
     * @return void
     */
    public function setVariable($variable, $value)
    {
        return $this->execute("SET VARIABLE $variable $value");
    }

    /**
     * execApplication executa aplicações do plano de discagem do asterisk
     *
     * @param  string $command aplicação a ser executada
     *
     * @return void
     */
    public function execApplication($command)
    {
        return $this->execute("EXEC $command");
    }

    /**
     * execute executa o comando desejado diretamente no manager do asterisk
     *
     * @param  string $command comando a ser executado
     *
     * @return void
     */
    public function execute($command)
    {
        return $this->send($command);
    }

    /**
     * __destruct destrói o socket criado no inicio da chamada
     *
     * @return void
     */
    public function __destruct()
    {
        parent::__destruct();
    }
}
