<?php

/**
 * This file is part of RoadRunner package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spiral\RoadRunner\Broadcast;

use Spiral\Goridge\RPC\Codec\ProtobufCodec;
use Spiral\Goridge\RPC\RPCInterface;
use Spiral\RoadRunner\Broadcast\DTO\V1\Message;
use Spiral\RoadRunner\Broadcast\DTO\V1\Request;
use Spiral\RoadRunner\Broadcast\DTO\V1\Response;
use Spiral\RoadRunner\Broadcast\Exception\InvalidArgumentException;
use Spiral\RoadRunner\Broadcast\Topic\Group;
use Spiral\RoadRunner\Broadcast\Topic\SingleTopic;

class Broker implements BrokerInterface
{
    /**
     * @var RPCInterface
     */
    private RPCInterface $rpc;

    /**
     * @var string
     */
    private string $broker;

    /**
     * @param RPCInterface $rpc
     * @param string $name
     */
    public function __construct(RPCInterface $rpc, string $name)
    {
        $this->rpc = $rpc->withCodec(new ProtobufCodec());
        $this->broker = $name;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->broker;
    }

    /**
     * @param non-empty-array<string> $topics
     * @param string $message
     * @return Message
     */
    private function createMessage(string $message, array $topics): Message
    {
        return new Message([
            'broker'  => $this->broker,
            'topics'  => $topics,
            'payload' => $message,
        ]);
    }

    /**
     * @param non-empty-list<Message> $messages
     * @return Response
     */
    private function request(iterable $messages): Response
    {
        $request = new Request(['messages' => $this->toArray($messages)]);

        return $this->rpc->call('websockets.Publish', $request, Response::class);
    }

    /**
     * @psalm-type T of mixed
     * @param iterable<T>|T $entries
     * @return array<T>
     */
    private function toArray($entries): array
    {
        switch (true) {
            case \is_array($entries):
                return $entries;

            case $entries instanceof \Traversable:
                return \iterator_to_array($entries, false);

            default:
                return [$entries];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function publish($topics, $messages): void
    {
        assert(
            \is_string($topics) || \is_iterable($topics),
            '$topics argument must be type of iterable<string>|string'
        );
        assert(
            \is_string($messages) || \is_iterable($messages),
            '$messages argument must be type of iterable<string>|string'
        );

        $topics = $this->toArray($topics);
        if ($topics === []) {
            throw new InvalidArgumentException('Unable to publish message to 0 topics');
        }

        $request = [];

        foreach ($this->toArray($messages) as $message) {
            $request[] = $this->createMessage($message, $topics);
        }

        if ($request === []) {
            throw new InvalidArgumentException('Unable to publish 0 messages');
        }

        $this->request($request);
    }

    /**
     * {@inheritDoc}
     */
    public function join($topics): TopicInterface
    {
        assert(
            \is_string($topics) || \is_iterable($topics),
            '$topics argument must be type of iterable<string>|string'
        );

        $topics = $this->toArray($topics);

        switch (\count($topics)) {
            case 0:
                throw new InvalidArgumentException('Unable to connect to 0 topics');

            case 1:
                return new SingleTopic($this, \reset($topics));

            default:
                return new Group($this, $topics);
        }
    }
}
