<?php

namespace MolliePrefix;

/*
 * This file is part of the PHPUnit_MockObject package.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * Invocation matcher which allows any parameters to a method.
 *
 * @since Class available since Release 1.0.0
 */
class PHPUnit_Framework_MockObject_Matcher_AnyParameters extends \MolliePrefix\PHPUnit_Framework_MockObject_Matcher_StatelessInvocation
{
    /**
     * @return string
     */
    public function toString()
    {
        return 'with any parameters';
    }
    /**
     * @param PHPUnit_Framework_MockObject_Invocation $invocation
     *
     * @return bool
     */
    public function matches(\MolliePrefix\PHPUnit_Framework_MockObject_Invocation $invocation)
    {
        return \true;
    }
}
/*
 * This file is part of the PHPUnit_MockObject package.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * Invocation matcher which allows any parameters to a method.
 *
 * @since Class available since Release 1.0.0
 */
\class_alias('MolliePrefix\\PHPUnit_Framework_MockObject_Matcher_AnyParameters', 'MolliePrefix\\PHPUnit_Framework_MockObject_Matcher_AnyParameters', \false);
