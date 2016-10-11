<?php
  $I = new AcceptanceTester($scenario);
  $I->wantTo('ensure that National Bank gives XML file with all currencies');
  $I->amOnPage('/rss/rates_all.xml');
  $I->haveHttpHeader('Content-Type', 'text/xml');
  $I->see('rss');
  $I->see('RUB');
  $I->see('GBP');
  $I->see('USD');
  $I->see('EUR');
?>