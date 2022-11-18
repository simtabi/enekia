<?php declare(strict_types=1);

namespace Simtabi\Enekia\Vanilla\Validators;
namespace Simtabi\Enekia\Vanilla\Validators;

use Respect\Validation\Validator as Respect;

class Age
{

    public function __construct(){}

    public function respect(): Respect
    {
        return new Respect();
    }

    public function isLegalAge($value, $limit = 18): bool
    {
        if($this->respect()->age($limit)->validate($value)){
            return true;
        }
        return false;
    }

}