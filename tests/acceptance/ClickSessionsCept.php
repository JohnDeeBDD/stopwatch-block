<?php
$I = new AcceptanceTester($scenario);

$I->wantTo('See that the stopwatch creates sessions');
    $I->loginAsAdmin();
    $I->amOnPage("/stopwatch");
    $I->dontSeeElement('.session1');
    //$I->dontSee("[X]");
    $I->see('Start');
    $I->see('Reset');
    $I->see('Stopwatch');

$I->expect('start and stop a session');
$I->expect('the session to appear');
$I->click(['class' => 'startTimer']);
$I->dontSee("Start");
$I->click(['class' => 'pauseTimer']);
$I->seeElementInDOM(['id' => 'session1']);

$I->expect('do it again with another session');
$I->click(['class' => 'startTimer']);
$I->click(['class' => 'pauseTimer']);
$I->seeElementInDOM(['id' => 'session2']);
$I->dontSeeElement(['id' => 'session3']);