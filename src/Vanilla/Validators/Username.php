<?php declare(strict_types=1);

namespace Simtabi\Enekia\Vanilla\Validators;

use Respect\Validation\Validator as Respect;
use Simtabi\Enekia\Vanilla\Validators\Transfigure;

class Username
{

    public function __construct(){}

    public function respect(): Respect
    {
        return new Respect();
    }

    public function isUsername($username, $minLength = 5, $maxLength = 32, $startWithAlphabets = false): bool
    {

        $tr = new Transfigure();

        // trim username
        $username  = trim($username);

        $minLength = !$tr->isInteger($minLength) ? 5 : $minLength;

        // validate username maximum length
        $maxLength = !$tr->isInteger($maxLength) ? 32 : $maxLength;

        // validate username length
        if(!$this->respect()->stringType()->length($minLength, $maxLength, true)->validate($username))
        {
            return false;
        }

        // if we are to strictly start with alphabets
        $regex = $startWithAlphabets ? '[A-Za-z]' : '';
        if(preg_match('/^'.$regex.'[A-Za-z0-9\d_]{5,'.$maxLength.'}$/', $username)){
            return true;
        }

        return false;
    }


}
