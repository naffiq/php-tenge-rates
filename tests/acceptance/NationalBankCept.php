<?php
  $I = new AcceptanceTester($scenario);
  $I->wantTo('ensure that National Bank gives XML file');
  $I->amOnPage('/rss/rates.xml');
  $I->haveHttpHeader('Content-Type', 'text/xml');
  $I->see('rss');
  $I->see('RUR');
  $I->see('USD');
  $I->see('EUR');
?>