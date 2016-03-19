<?php

class Netflows extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $router_id;

    /**
     *
     * @var string
     */
    public $src_ipn;

    /**
     *
     * @var string
     */
    public $dst_ipn;

    /**
     *
     * @var string
     */
    public $nxt_ipn;

    /**
     *
     * @var integer
     */
    public $ifin;

    /**
     *
     * @var integer
     */
    public $ifout;

    /**
     *
     * @var integer
     */
    public $packets;

    /**
     *
     * @var integer
     */
    public $octets;

    /**
     *
     * @var string
     */
    public $starttime;

    /**
     *
     * @var string
     */
    public $endtime;

    /**
     *
     * @var integer
     */
    public $srcport;

    /**
     *
     * @var integer
     */
    public $dstport;

    /**
     *
     * @var integer
     */
    public $tcp;

    /**
     *
     * @var integer
     */
    public $prot;

    /**
     *
     * @var integer
     */
    public $tos;

    /**
     *
     * @var integer
     */
    public $srcas;

    /**
     *
     * @var integer
     */
    public $dstas;

    /**
     *
     * @var integer
     */
    public $srcmask;

    /**
     *
     * @var integer
     */
    public $dstmask;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'netflows';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Netflows[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Netflows
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
