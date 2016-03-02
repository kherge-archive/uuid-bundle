<?php

namespace KHerGe\Bundle\UuidBundle\Tests\Test;

use Ramsey\Uuid\FeatureSet as Base;

/**
 * A test feature set.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class FeatureSet extends Base
{
    /**
     * The test codec.
     *
     * @var Codec
     */
    private $codec;

    /**
     * The test node provider.
     *
     * @var NodeProvider
     */
    private $nodeProvider;

    /**
     * {@inheritdoc}
     */
    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct()
    {
        $this->codec = new Codec();
        $this->nodeProvider = new NodeProvider();
    }

    /**
     * {@inheritdoc}
     */
    /** @noinspection PhpMissingParentCallCommonInspection */
    public function getCodec()
    {
        return $this->codec;
    }

    /**
     * {@inheritdoc}
     */
    /** @noinspection PhpMissingParentCallCommonInspection */
    public function getNodeProvider()
    {
        return $this->nodeProvider;
    }
}
