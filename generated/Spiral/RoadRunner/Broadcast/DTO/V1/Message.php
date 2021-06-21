<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: broadcast.proto

namespace Spiral\RoadRunner\Broadcast\DTO\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>broadcast.v1.Message</code>
 */
class Message extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string command = 1;</code>
     */
    protected $command = '';
    /**
     * Generated from protobuf field <code>repeated string topics = 2;</code>
     */
    private $topics;
    /**
     * Generated from protobuf field <code>bytes payload = 3;</code>
     */
    protected $payload = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $command
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $topics
     *     @type string $payload
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Broadcast::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string command = 1;</code>
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Generated from protobuf field <code>string command = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setCommand($var)
    {
        GPBUtil::checkString($var, True);
        $this->command = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated string topics = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getTopics()
    {
        return $this->topics;
    }

    /**
     * Generated from protobuf field <code>repeated string topics = 2;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setTopics($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->topics = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>bytes payload = 3;</code>
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Generated from protobuf field <code>bytes payload = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setPayload($var)
    {
        GPBUtil::checkString($var, False);
        $this->payload = $var;

        return $this;
    }

}

