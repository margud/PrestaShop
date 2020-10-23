<?php

namespace MolliePrefix;

// Declare the interface 'iTemplate'
interface iTemplate
{
    public function setVariable($name, $var);
    public function getHtml($template);
}
// Declare the interface 'iTemplate'
\class_alias('MolliePrefix\\iTemplate', 'iTemplate', \false);
interface a
{
    public function foo();
}
\class_alias('MolliePrefix\\a', 'a', \false);
interface b extends \MolliePrefix\a
{
    public function baz(\MolliePrefix\Baz $baz);
}
\class_alias('MolliePrefix\\b', 'b', \false);
// short desc for class that implement a unique interface
class c implements \MolliePrefix\b
{
    public function foo()
    {
    }
    public function baz(\MolliePrefix\Baz $baz)
    {
    }
}
// short desc for class that implement a unique interface
\class_alias('MolliePrefix\\c', 'c', \false);