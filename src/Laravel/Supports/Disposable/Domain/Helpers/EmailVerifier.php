<?php

namespace Simtabi\Enekia\Laravel\Validators\Disposable\Domain\Helpers;

use Exception;

class EmailVerifier
{
    public $domain;

    public $details;

    public string $result = '';

    public string $emailFrom = '';

    /*
    ==============================================================

    This method will set from email address

    ==============================================================

    @return String
     */
    public function setFromEmail($email_from)
    {
        if (filter_var($email_from, FILTER_VALIDATE_EMAIL)) {
            $this->emailFrom = $email_from;
        } else if (filter_var(env('EMAIL_CHECKER_SET_FROM'), FILTER_VALIDATE_EMAIL)) {
            $this->emailFrom = env('EMAIL_CHECKER_SET_FROM');
        } else {
            $this->emailFrom = 'example@example.com';
        }
    }

    /*
    ==============================================================

    This method will check all possibilities of email verification

    ==============================================================

    @return array
     */
    public function checkEmail($email, $deepCheck = false)
    {
        $disposable = $mxrecord = $domain = [];

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // check for disposable email
            if ($this->checkDisposableEmail($email, $deepCheck) === true) {
                return [
                    'success' => false,
                    'error'   => 'Entered email address is disposable',
                ];
            } else {
                $disposable = [
                    'success' => true,
                    'detail'  => 'Email address is not disposable',
                ];
            }
            $verify = $this->checkMxAndDnsRecord($email);
            if ($verify[0] !== 'valid') {
                return [
                    'success' => false,
                    'error'   => 'Entered email address has no MX and DNS record.',
                ];
            } else {
                $mxrecord = [
                    'success' => true,
                    'detail'  => $verify[1],
                ];
            }
            if ($this->checkDomain($email) === false) {
                return [
                    'success' => false,
                    'error'   => 'Unable to verify email address.',
                ];
            } else {
                $domain = [
                    'success' => true,
                    'detail'  => 'Domain is exist.',
                ];
            }
            return [
                'success'     => true,
                'dispossable' => $disposable,
                'mxrecord'    => $mxrecord,
                'domain'      => $domain,
            ];
        } else {
            return [
                'success' => false,
                'error'   => 'Please enter valid email address',
            ];
        }
    }

    /*
    =====================================================

    This method will only check for disposable emails

    =====================================================

    @return true | false
     */
    public function checkDisposableEmail($email, $deepCheck = false)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $domain = $this->splitEmail($email);

            // Possibilities of domain name that can generate disposable emails COURTESY FORMGET
            if (preg_match("/(ThrowAwayMail|DeadAddress|10MinuteMail|20MinuteMail|AirMail|Dispostable|Email Sensei|EmailThe|FilzMail|Guerrillamail|IncognitoEmail|Koszmail|Mailcatch|Mailinator|Mailnesia|MintEmail|MyTrashMail|NoClickEmail|
            SpamSpot|Spamavert|Spamfree24|TempEmail|Thrashmail.ws|Yopmail|EasyTrashMail|Jetable|MailExpire|MeltMail|Spambox|empomail|33Mail|
            E4ward|GishPuppy|InboxAlias|MailNull|Spamex|Spamgourmet|BloodyVikings|SpamControl|MailCatch|Tempomail|EmailSensei|Yopmail|
            Trasmail|Guerrillamail|Yopmail|boximail|ghacks|Maildrop|MintEmail|fixmail|gelitik.in|ag.us.to|mobi.web.id
            |fansworldwide.de|privymail.de|gishpuppy|spamevader|uroid|tempmail|soodo|deadaddress|trbvm)/i", $domain)) {
                return true;
            }

            if ($deepCheck) {
                return $this->deepCheck($domain);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function deepCheck(string $domain): bool
    {
        $startingCharacter = strtolower(substr($domain, 0, 1));
        if (preg_match("/^[a-zA-Z0-9]+$/", $startingCharacter) == 1) {
            $data = json_decode(file_get_contents((__DIR__ . "/../../resources/domains/") . $startingCharacter . ".json"), true);
            for ($i = 0; $i < count($data); $i++) {
                if (preg_match("/(" . $data[$i] . ")/i", $domain)) {
                    return true;
                }
            }
            return false;
        } else {
            return false;
        }
    }

    /*
    =====================================================

    This method will check for DNS and MX record of the
    email address domain.

    =====================================================

    @return array with details
     */
    public function checkMxAndDnsRecord($email): array
    {
        if (empty($this->emailFrom)) {
            $this->setFromEmail('');
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Get the domain of the email recipient
            $detailsDesc = '';
            $email_arr   = explode('@', $email);
            $domain      = array_slice($email_arr, -1);
            $domain      = $domain[0];

            // Trim [ and ] from beginning and end of domain string, respectively
            $domain = ltrim($domain, '[');
            $domain = rtrim($domain, ']');
            if ('IPv6:' == substr($domain, 0, strlen('IPv6:'))) {
                $domain = substr($domain, strlen('IPv6') + 1);
            }

            $mxhosts = [];

            // Check if the domain has an IP address assigned to it
            if (filter_var($domain, FILTER_VALIDATE_IP)) {
                $mx_ip = $domain;
            } else {
                // If no IP assigned, get the MX records for the host name
                getmxrr($domain, $mxhosts, $mxweight);
            }
            if (!empty($mxhosts)) {
                $mx_ip = $mxhosts[array_search(min($mxweight), $mxhosts)];
            } else {
                // If MX records not found, get the A DNS records for the host
                if (filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    $record_a = dns_get_record($domain, DNS_A);
                    // else get the AAAA IPv6 address record
                } elseif (filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                    $record_a = dns_get_record($domain, DNS_AAAA);
                }
                if (!empty($record_a)) {
                    $mx_ip = $record_a[0]['ip'];
                } else {
                    // Exit the program if no MX records are found for the domain host
                    $result = 'invalid';
                    $details = 'No suitable MX records found.';
                    return array($result, $details);
                }
            }
            // Open a socket connection with the hostname, smtp port 25
            try {
                if ($connect = @fsockopen($mx_ip, 25, $errno, $errstr, 5)) {
                    // Initiate the Mail Sending SMTP transaction
                    if (preg_match('/^220/i', $out = fgets($connect, 1024))) {
                        // Send the HELO command to the SMTP server
                        fputs($connect, "HELO $mx_ip\r\n");
                        $out          = fgets($connect, 1024);
                        $detailsDesc .= $out . "\n";
                        // Send an SMTP Mail command from the sender's email address
                        fputs($connect, "MAIL FROM: <" . $this->emailFrom . ">\r\n");
                        $from         = fgets($connect, 1024);
                        $detailsDesc .= $from . "\n";
                        // Send the SCPT command with the recepient's email address
                        fputs($connect, "RCPT TO: <$email>\r\n");
                        $to = fgets($connect, 1024);
                        $detailsDesc .= $to . "\n";
                        // Close the socket connection with QUIT command to the SMTP server
                        fputs($connect, 'QUIT');
                        fclose($connect);
                        // The expected response is 250 if the email is valid
                        if (!preg_match('/^250/i', $from) || !preg_match('/^250/i', $to)) {
                            $result  = 'invalid';
                            $details = 'Invalid email address';
                        } else {
                            $result  = 'valid';
                            $details = 'Valid email address';
                        }
                    } else {
                        $result = 'valid';
                        $details = 'MX record found but could not connect to server';
                    }
                } else {
                    $result  = 'valid';
                    $details = 'MX record found but could not connect to server';
                }
            } catch (Exception $e) {
                $result = 'valid';
                $details = 'MX record found but could not connect to server';
            }
            return array($result, $details);
        } else {
            $result  = 'invalid';
            $details = 'Validation error email address.';

            return [$result, $details];
        }
    }

    /*
    =====================================================

    This method will check if domain exist or not using
    curl.

    =====================================================

    @return true | false
     */

    public function checkDomain($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $domain   = 'https://' . $this->splitEmail($email);
            $httpcode = $this->goCurl($domain);

            if ($httpcode === 301 || $httpcode === 301) {
                $domain   = 'https://' . $this->splitEmail($email);
                $httpcode = $this->goCurl($domain);
            }

            if ($httpcode >= 200 && $httpcode < 302) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /*
    =====================================================

    This method will split domain from email address

    =====================================================

    @return domain
     */
    private function splitEmail($email): string
    {
        return substr(strrchr($email, "@"), 1);
    }

    private function goCurl($domain)
    {
        $init = curl_init($domain);
        curl_setopt($init, CURLOPT_TIMEOUT, 5);
        curl_setopt($init, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($init, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($init, CURLOPT_MAXREDIRS, 3);
        curl_exec($init);
        $httpcode = curl_getinfo($init, CURLINFO_HTTP_CODE);
        curl_close($init);
        return $httpcode;
    }
}
