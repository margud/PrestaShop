<?php

namespace MolliePrefix;

interface AnInterfaceWithReturnType
{
    public function returnAnArray() : array;
}
\class_alias('MolliePrefix\\AnInterfaceWithReturnType', 'AnInterfaceWithReturnType', \false);