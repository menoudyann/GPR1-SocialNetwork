<?php declare(strict_types=1);

namespace SocialNetwork;

interface IObservable
{
    //Subscribe an Observer to an Observable
    public function subscribe(array $observers);

    //Unsubscribe an Observer from an Observable
    public function unsubscribe(IObserver $observer);

    //Notify all Observers about a post, an event and any kind of updates
    public function notifyObservers();
}