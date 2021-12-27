<?php

namespace Simtabi\Enekia\Helpers;

use Snipe\BanBuilder\CensorWords;

class OffensiveWordChecker
{
    private CensorWords $censor;
    private const        DATA_PATH = __DIR__.'/../../resources/data/';

    public function __construct(array $blacklist = [], array $whitelist = [])
    {
        $this->censor = new CensorWords();

        $this->setupBadWords($blacklist);
        $this->setupWhiteList($whitelist);
    }

    private function getCustomBlacklistedWords(array $blacklisted = []): array
    {
        $path = '/tmp/custom-blacklist.json';
        file_put_contents($path, json_encode($blacklisted));

        $data = json_decode(file_get_contents($path));
        return !empty($blacklisted) ? array_merge($blacklisted, $data) : $data;
    }

    private function getBlacklistedWords(array $blacklisted = []): array
    {
        $data = json_decode(file_get_contents(self::DATA_PATH.'blacklisted.json'));
        return !empty($blacklisted) ? array_merge($blacklisted, $data) : $data;
    }

    private function getWhitelistedWords(array $whitelisted = []): array
    {
        $data = json_decode(file_get_contents(self::DATA_PATH.'whitelisted.json'));
        return !empty($whitelisted) ? array_merge($whitelisted, $data) : $data;
    }

    private function setupBadWords(array $blacklist)
    {
        if ($blacklist) {
            $this->censor->setDictionary([$this->getCustomBlacklistedWords($blacklist)]);
        } else {
            $this->censor->setDictionary([$this->getBlacklistedWords()]);
        }
    }

    private function setupWhiteList(array $whitelist)
    {
        if ($whitelist) {
            $words = $whitelist;
        } else {
            $words = $this->getWhitelistedWords();
        }

        foreach ($words as $word) {
            $words[] = strtoupper($word);
            $words[] = ucwords($word);
        }

        $this->censor->addWhiteList($words);
    }

    public function isOffensiveWord($text)
    {
        $results = $this->censor->censorString($text);

        return count($results['matched']) > 0;
    }
}