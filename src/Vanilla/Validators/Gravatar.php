<?php

namespace Simtabi\Enekia\Vanilla\Validators;

class Gravatar
{

    public function __construct(){}

    /**
     * Check if the email has any gravatar image or not
     *
     * @param  string $email Email of the User
     * @return boolean true, if there is an image. false otherwise
     */
    public static function isValidGravatarEmail(string $email): bool
    {
        $headers = @get_headers('http://www.gravatar.com/avatar/' . md5($email) . '?d=404');

        return !preg_match("|200|", $headers[0]) ? false : true;
    }
}