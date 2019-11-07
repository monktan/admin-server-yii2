<?php

namespace monktan\libraries;

class SnowFlake
{
    const EPOCH_OFFSET = 1561910400000;   // 2019-07-01 00:00:00;
    const SIGN_BITS = 1;
    const TIMESTAMP_BITS = 41;
    const DATA_CENTER_BITS = 5;
    const MACHINE_ID_BITS = 5;
    const SEQUENCE_BITS = 12;
    /**
     * @var IdWorker
     */
    private static $idWorker;
    /**
     * @var mixed
     */
    protected $dataCenterId;
    /**
     * @var mixed
     */
    protected $machineId;
    /**
     * @var null|int
     */
    protected $lastTimestamp = null;
    /**
     * @var null|CountServerInterFace
     */
    private $countService = null;
    /**
     * @var int
     */
    protected $sequence = 1;
    protected $signLeftShift = self::TIMESTAMP_BITS +
    self::DATA_CENTER_BITS +
    self::MACHINE_ID_BITS +
    self::SEQUENCE_BITS;
    protected $timestampLeftShift = self::DATA_CENTER_BITS + self::MACHINE_ID_BITS + self::SEQUENCE_BITS;
    protected $dataCenterLeftShift = self::MACHINE_ID_BITS + self::SEQUENCE_BITS;
    protected $machineLeftShift = self::SEQUENCE_BITS;
    protected $maxSequenceId = -1 ^ (-1 << self::SEQUENCE_BITS);
    protected $maxMachineId = -1 ^ (-1 << self::MACHINE_ID_BITS);
    protected $maxDataCenterId = -1 ^ (-1 << self::DATA_CENTER_BITS);
    /**
     * UniqueId constructor.
     * @param $dataCenter_id
     * @param $machine_id
     * @throws \Exception
     */
    private function __construct($dataCenter_id, $machine_id)
    {
        if ($dataCenter_id > $this->maxDataCenterId) {
            throw_info('数据中心ID应该是0到 ' . $this->maxDataCenterId . '之间');
        }
        if ($machine_id > $this->maxMachineId) {
            throw_info('机器ID应该是0到' . $this->maxMachineId . '之间');
        }
        $this->dataCenterId = $dataCenter_id;
        $this->machineId = $machine_id;
    }
    /**
     * Notes:__clone
     * @author  zhangrongwang
     * @date 2018-12-25 11:42:06
     */
    private function __clone()
    {
    }
    /**
     * 获取对象
     * @param int $dataCenterId
     * @param int $machineId
     * @throws \Exception
     * @return SnowFlake $snowflake;
     */
    public static function getInstance($dataCenterId = 0, $machineId = 0)
    {
        if (!(self::$idWorker instanceof self)) {
            self::$idWorker = new self($dataCenterId, $machineId);
        }
        return self::$idWorker;
    }

    /**
     * 生成id
     * @date 2018-12-25 11:48:09
     * @throws \Exception
     */
    public function generateId()
    {
        $id = $this->baseGenerateId(function ($timestamp) {
            $sequence = random_int(1, 2^12);
            $sequence = str_pad($sequence, 4, '0', STR_PAD_LEFT);
            return $sequence;
        });

        return $id;
    }

    public function generateIdWithRedis()
    {
        $dataCenterId = $this->dataCenterId;
        $machineId = $this->machineId;
        $id = $this->baseGenerateId(function ($timestamp) use ($dataCenterId, $machineId) {
//            $countServiceKey = $dataCenterId . '-' . $machineId . '-' . $timestamp;
            $sequence = random_int(1, 2^12);
            $sequence = str_pad($sequence, 4, '0', STR_PAD_LEFT);
            return $sequence;
        });

        return $id;
    }

    private function baseGenerateId(callable $callback)
    {
        $sign = 0;
        $timestamp = $this->getUnixTimestamp();
        if ($timestamp < $this->lastTimestamp) {
            throw_info('服务器时钟错误');
        }

        $sequence = call_user_func($callback, $timestamp);
        if ($sequence > $this->maxSequenceId) {
            $timestamp = $this->getUnixTimestamp();
            while ($timestamp <= $this->lastTimestamp) {
                $timestamp = $this->getUnixTimestamp();
            }
            $sequence = call_user_func($callback, $timestamp);
        }
        $this->lastTimestamp = $timestamp;

        $time = (int)($timestamp - self::EPOCH_OFFSET);
        $id = ($sign << $this->signLeftShift) |
            ($time << $this->timestampLeftShift) |
            ($this->dataCenterId << $this->dataCenterLeftShift) |
            ($this->machineId << $this->machineLeftShift) |
            $sequence;

        return (string)$id;
    }

    /**
     * 解析id
     * @param $uuid
     * @return array
     */
    public function parseId($uuid)
    {
        $binUuid = decbin($uuid);
        $len = strlen($binUuid);
        $sequenceStart = $len - self::SEQUENCE_BITS;
        $sequence = substr($binUuid, $sequenceStart, self::SEQUENCE_BITS);
        $machineIdStart = $len - self::MACHINE_ID_BITS - self::SEQUENCE_BITS;
        $machineId = substr($binUuid, $machineIdStart, self::MACHINE_ID_BITS);
        $dataCenterIdStart = $len - self::DATA_CENTER_BITS - self::MACHINE_ID_BITS - self::SEQUENCE_BITS;
        $dataCenterId = substr($binUuid, $dataCenterIdStart, self::DATA_CENTER_BITS);
        $timestamp = substr($binUuid, 0, $dataCenterIdStart);
        $realTimestamp = bindec($timestamp) + self::EPOCH_OFFSET;
        $timestamp = substr($realTimestamp, 0, -3);
        $microSecond = substr($realTimestamp, -3);
        return [
            'timestamp' => date('Y-m-d H:i:s', $timestamp) . '.' . $microSecond,
            'dataCenterId' => bindec($dataCenterId),
            'machineId' => bindec($machineId),
            'sequence' => bindec($sequence),
        ];
    }
    /**
     * getUnixTimestamp
     */
    private function getUnixTimestamp()
    {
        return floor(microtime(true) * 1000);
    }
}
