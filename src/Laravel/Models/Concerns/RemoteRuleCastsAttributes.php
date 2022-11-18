<?php

namespace Simtabi\Enekia\Laravel\Models\Concerns;

trait RemoteRuleCastsAttributes
{
    public function initializeCastsAttributes()
    {
        $this->mergeCasts(
                config('enekia.remote_rule.attribute_cast')
        );
    }
}
