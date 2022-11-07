<?php

namespace SocialNetwork;

use RuntimeException;
use function PHPUnit\Framework\throwException;

require 'IObservable.php';

class Twitter implements IObservable
{
    protected array $observers = [];
    protected array $twits = [];

    public function __construct(array $observers = []){
        //TODO REVIEW NGY - Single Responsibility Principle
        //https://www.freecodecamp.org/news/solid-principles-single-responsibility-principle-explained
        //Your class already contains a method responsible to add, meeting business rules, followers. Use it !
        $this->subscribe($observers);
    }

    public function subscribe(array $observers):void
    {
        foreach ($observers as $observer) {
            if (in_array($observer, $this->observers, true)){
                throw new SubscriberAlreadyExistsException();
            }
            $this->observers[] = $observer;
        }
    }

    public function unsubscribe(IObserver $observer):void
    {
        //TODO REVIEW NGY - KISS Principle - Keep it as simple as simple
        //https://people.apache.org/~fhanik/kiss.html
        //Review the way your are checking the several cases (what happens when an exception is thrown ?)

        if (count($this->observers) <= 0){
            throw new EmptyListOfSubscribersException();
        }

        if (!in_array($observer, $this->observers, true)){
            throw new SubscriberNotFoundException();
        }

        $id = array_search($observer, $this->observers);
        unset($this->observers[$id]);

    }

    public function notifyObservers():void
    {
        if(count($this->observers) == 0){
            throw new EmptyListOfSubscribersException();
        }
    }

    public function getObservers():array
    {
        return $this->observers;
    }

    public function getTwits():array
    {
        return $this->twits;
    }
}

class TwitterException extends RuntimeException { }
class EmptyListOfSubscribersException extends TwitterException { }
class SubscriberAlreadyExistsException extends TwitterException { }
class SubscriberNotFoundException extends TwitterException { }