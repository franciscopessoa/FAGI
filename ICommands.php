<?php

namespace AGI;

interface ICommands
{

    /**
     * answer atende a chamada corrente
     *
     * @return void
     */
    public function answer();

    /**
     * hangup desliga o canal da chamada especificada, caso não especificado, ecerra o canal atual
     *
     * @param  string $channel
     *
     * @return void
     */
    public function hangup($channel = '');

    /**
     * getCallerID get callerID of call
     * 
     * @param  mixed $param all | ani | ani2 | dnid | name | num | rdnis
     *
     * @return void
     */
    public function getCallerID($param = 'all');

    /**
     * getChannel get current channel name
     * 
     * @return void
     */
    public function getChannel();

    /**
     * getContext get current context
     *
     * @return void
     */
    public function getContext();

    /**
     * getEpoch get current 
     *
     * @return void
     */
    public function getExten();

    /**
     * getExten get current priority in the dialplan
     *
     * @return void
     */
    public function getPriority();

    /**
     * getEpoch get current unix style epoch
     *
     * @return void
     */
    public function getEpoch();

    /**
     * getEpoch get current call unique identifier
     *
     * @return void
     */
    public function getUniqueid();

    /**
     * getUserfield get current call userfield
     *
     * @return void
     */
    public function getUserfield($field = 'FILE');

    /**
     * getQueueWaitingCount busca a quantidade de chamadas em espera na fila
     *
     * @param  mixed $queue
     *
     * @return void
     */
    public function getQueueWaitingCount($queue);

    /**
     * getQueueMemberCount busca a quantidade de agentes logados na fila
     *
     * @param  mixed $queue
     *
     * @return void
     */
    public function getQueueMemberCount($queue);

    /**
     * getVariable busca uma váriavel específica do canal atual
     *
     * @param  mixed $variable variavel a ser buscada
     * @param  mixed $data se setado como true retorna apenas o valor
     *
     * @return void
     */
    public function getVariable($variable, $returnData = false);

    /**
     * setVariable
     *
     * @param  mixed $variable
     * @return void
     */
    public function setVariable($variable, $value);

    /**
     * dial
     *
     * @param  mixed $dial
     *
     * @return void
     */
    public function dial($dial);

    /**
     * noop mostra na CLI um dado específico
     *
     * @param  mixed $text texto a ser exibido
     *
     * @return void
     */
    public function noop($text);

    /**
     * playback executa um arquivo de áudio especificado
     *
     * @param  string $filename arquivo de áudio (localizado em /var/lib/asterisk/sounds/)
     * @param  array $options opções de parametros para o playback
     *
     * @return void
     */
    public function playback($filename, $options = []);

    /**
     * queue
     *
     * @param  mixed $queue
     * @param  mixed $options
     *
     * @return void
     */
    public function queue($queue, $options = '');

    /**
     * goto
     *
     * @param  mixed $queue
     * @param  mixed $options
     * @return void
     */
    public function gotoContext($context, $exten, $priority = '1');

    /**
     * getCDRVariable
     *
     * @param  mixed $variable
     *
     * @return void
     */
    public function getCDRVariable($variable);

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
    public function getData($filename, $timeout = null, $maxdigits = null, $result = false);

    /**
     * channelStatus retorna o status do canal especificado
     *
     * @param  mixed $channel canal da ligacao
     *
     * @return void
     */
    public function channelStatus($channel = '');

    /**
     * execApplication executa aplicações do plano de discagem do asterisk
     *
     * @param  string $command aplicação a ser executada
     *
     * @return void
     */
    public function execApplication($command);

    /**
     * execute executa o comando desejado diretamente no manager do asterisk
     *
     * @param  string $command comando a ser executado
     *
     * @return void
     */
    public function execute($command);
}
