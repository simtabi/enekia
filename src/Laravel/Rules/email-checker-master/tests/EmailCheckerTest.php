<?php

namespace Aman\EmailVerifier\Tests;

use Aman\EmailVerifier\EmailVerifier;

class EmailCheckerTest extends TestCase
{
    public function testCheckDisposableEmail()
    {
        $emailChecker = new EmailVerifier();
        $dispossibleEmail = $this->disposableEmailList();
        for ($i = 0; $i < count($dispossibleEmail); $i++) {
            self::assertTrue(
                $emailChecker->checkDisposableEmail($dispossibleEmail[$i], true)
            );
        }
        $emailList = $this->emailList();
        for ($i = 0; $i < count($emailList); $i++) {
            self::assertFalse(
                $emailChecker->checkDisposableEmail($emailList[$i])
            );
        }
    }

    public function testCheckDomain()
    {
        $emailChecker = new EmailVerifier();
        $emailList = $this->emailList();
        for ($i = 0; $i < count($emailList); $i++) {
            $response = $emailChecker->checkDomain($emailList[$i], false);
            self::assertTrue($response);
        }

    }

    public function testCheckEmail()
    {
        $emailChecker = new EmailVerifier();
        $dispossibleEmail = $this->disposableEmailList();
        for ($i = 0; $i < count($dispossibleEmail); $i++) {
            $response = $emailChecker->checkEmail($dispossibleEmail[$i]);
            self::assertFalse($response['success']);
        }
    }

    private function disposableEmailList()
    {
        //TODO : add list support for dispossable emails
        return array(
            'df@mailinator.com',
            'df@spamevader.com',
            'temp@tempmail.com',
            'something@trbvm.com',
            'anything@boximail.com',
        );
    }

    private function emailList()
    {
        //Some email address with the valid domain
        return array(
            'temp@yahoo.com',
            'something@outlook.com',
            'anything@yahoo.com',
        );
    }

}
