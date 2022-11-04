<?php

namespace SocialNetwork;

use RuntimeException;
use function PHPUnit\Framework\throwException;

require 'IObservable.php';

class Twitter implements IObservable
{
    protected $observers = [];
    protected $twits = [];

    public function __construct(array $observers = []){
        $this->observers = $observers;
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
        if(count($this->observers)>0) {
            if (in_array($observer, $this->observers, true)) {
                $id = array_search($observer, $this->observers);
                unset($this->observers[$id]);
            }else{
                throw new SubscriberNotFoundException();
            }
        }else{
            throw new EmptyListOfSubscribersException();
        }
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