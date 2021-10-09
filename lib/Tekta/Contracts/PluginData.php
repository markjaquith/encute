<?php

namespace CWS\Encute\Tekta\Contracts;

use Countable;
use ArrayAccess;
use Traversable;
use ArrayIterator;
use CachingIterator;
use JsonSerializable;
use IteratorAggregate;
use CWS\Encute\Illuminate\Support\Traits\Macroable;
use CWS\Encute\Illuminate\Contracts\Support\Jsonable;
use CWS\Encute\Illuminate\Contracts\Support\Arrayable;

interface PluginData extends ArrayAccess, Arrayable, Countable, IteratorAggregate, Jsonable, JsonSerializable {}
