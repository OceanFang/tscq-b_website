<?php

namespace App\Services;

use App\Repository\SiteRepository;

class SiteService
{
    protected $siteRepo;

    public function __construct(SiteRepository $siteRepo)
    {
        $this->siteRepo = $siteRepo;
    }
}
