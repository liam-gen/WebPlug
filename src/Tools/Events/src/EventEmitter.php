<?php
namespace Peridot;
require_once("EventEmitterTrait.php");
require_once("EventEmitterInterface.php");

class EventEmitter implements EventEmitterInterface
{
    use EventEmitterTrait;
}
