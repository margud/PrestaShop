<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper5ea00cc67502b\Symfony\Component\Config\Definition;

/**
 * This interface must be implemented by nodes which can be used as prototypes.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
interface PrototypeNodeInterface extends \_PhpScoper5ea00cc67502b\Symfony\Component\Config\Definition\NodeInterface
{
    /**
     * Sets the name of the node.
     *
     * @param string $name The name of the node
     */
    public function setName($name);
}
