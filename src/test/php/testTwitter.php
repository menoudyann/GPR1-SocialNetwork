<?php

namespace SocialNetwork;
use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\TestCase;
use SocialNetwork\Follower;
use SocialNetwork\SubscriberNotFoundException;
use SocialNetwork\Twitter;

require '..\..\..\vendor\autoload.php';

class testTwitter extends TestCase
{
    //region private attributes
    private Twitter $twitter;
    //endregion private attributes

    public function setup():void
    {
        $this->twitter = new Twitter();
    }

    public function test_getObservers_AfterInstantiationWithoutObservers_Success()
    {
        //given
        //refer to Setup method
        $expectedAmountOfObservers = 0;

        //when
        //event is called directly by the assertion

        //then
        $this->assertCount($expectedAmountOfObservers, $this->twitter->getObservers());
    }

    public function test_getObservers_AfterInstantiationWithObservers_Success()
    {
        //given
        //refer to Setup method
        $expectedAmountOfObservers = 10;
        $observer = $this->generateObservers($expectedAmountOfObservers);
        $this->twitter = new Twitter($this->generateObservers($expectedAmountOfObservers));

        //when
        //event is called directly by the assertion

        //then
        $this->assertEquals($expectedAmountOfObservers, Count($this->twitter->getObservers()));
    }

    public function test_twits_AfterInstantiation_Success(){
        //given
        //refer to Before Each method
        $expectedAmountOfTwits = 0;

        //when
        //event is called directly by the assertion

        //then
        $this->assertCount($expectedAmountOfTwits, $this->twitter->getTwits());
    }

    public function test_notifyObservers_EmptyListOfSubscriber_ThrowsException(){
        //given
        //refer to Before Each method

        //when
        //event is called directly by the assertion

        //then
        $this->expectException(EmptyListOfSubscribersException::class);
        $this->twitter->notifyObservers();
    }

    public function test_subscribe_AddFirstSubscriber_Success() {
        //given
        //refer to Before Each method
        $expectedAmountOfSubscribers = 15;
        $followers = $this->generateObservers($expectedAmountOfSubscribers);

        //when
        $this->twitter->subscribe($followers);

        //then
        $this->assertCount($expectedAmountOfSubscribers, $this->twitter->getObservers());
    }

    public function test_subscribe_AddSubscribersToExistingList_Success(){
        //given
        //refer to Before Each method
        $expectedAmountOfSubscriber = 30;
        $followers = $this->generateObservers($expectedAmountOfSubscriber / 2);
        $this->twitter->subscribe($followers);
        $followersToAdd = $this->generateObservers($expectedAmountOfSubscriber / 2);

        //when
        $this->twitter->subscribe($followersToAdd);

        //then
        $this->assertCount($expectedAmountOfSubscriber, $this->twitter->getObservers());
    }

    public function test_subscribe_SubscriberAlreadyExists_ThrowsException()
    {
        //given
        //refer to Before Each method
        $expectedAmountOfSubscriber = 15;
        $followers = $this->generateObservers($expectedAmountOfSubscriber);
        $this->twitter->subscribe($followers);
        $followersDuplicate = array();
        array_push($followersDuplicate, $followers[0]);

        //when
        //event is called directly by the assertion

        //then
        $this->expectException(SubscriberAlreadyExistsException::class);
        $this->twitter->subscribe($followersDuplicate);
    }

    public function test_unsubscribe_NominalCase_Success()
    {
        //given
        //refer to Before Each method
        $expectedAmountOfSubscribers = 14;
        $followers = $this->generateObservers($expectedAmountOfSubscribers + 1);
        $this->twitter->subscribe($followers);

        //when
        $this->twitter->unsubscribe($followers[0]);

        //then
        $this->assertCount($expectedAmountOfSubscribers, $this->twitter->getObservers());
    }

    public function test_unsubscribe_EmptyListOfSubscriber_ThrowsException()
    {
        //given
        //refer to Before Each method
        $followerToRemove = new Follower();

        //when
        //event is called directly by the assertion

        //then
        $this->expectException(EmptyListOfSubscribersException::class);
        $this->twitter->unsubscribe($followerToRemove);
    }

    public function test_unsubscribe_SubscriberNotFound_ThrowsException()
    {
        //given
        //refer to Before Each method
        $followerNotFound = new Follower();
        $this->twitter->subscribe($this->generateObservers(10));

        //when
        //event is called directly by the assertion

        //then
        $this->expectException(SubscriberNotFoundException::class);
        $this->twitter->unsubscribe($followerNotFound);
    }

    //region private methods
    #[Pure] private function generateObservers($amountOfObserversToCreate):array
    {
        $observers = array();
        for ($i=0 ; $i < $amountOfObserversToCreate ; $i++)
        {
            $observers[] = new Follower();
        }
        return $observers;
    }
    //endregion private methods
}
