<?php declare(strict_types=1);

namespace SocialNetwork;

interface IObserver
{
//Receive update from the observable
public function update(IObservable $observable);
}