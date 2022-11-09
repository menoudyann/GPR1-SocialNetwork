<?php declare(strict_types=1);

namespace SocialNetwork;

require_once 'IObserver.php';

class Follower implements IObserver
{
    public function __construct(int $id){}

    public function update(IObservable $observable):void
    {
        throw new RuntimeException();
    }
}