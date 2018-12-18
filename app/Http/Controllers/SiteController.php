<?php

namespace App\Http\Controllers;

use App\Library\Accessibility;
use App\Services\SiteService;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    protected $siteService;
    protected $accessibility;
    public function __construct(SiteService $siteService, Accessibility $accessibility)
    {
        $this->siteService = $siteService;
        $this->accessibility = $accessibility;
    }

    // 取得總代理下之代理 or 代理下之平台
    public function getSubLevelLists(Request $request)
    {
        $subLists = $this->siteService->getSubLevelLists($request->parentId, $request->subType);

        return $subLists;
    }

    // 取得商務下之總代理/直建代理/直建平台
     public function getSubDistributorLists(Request $request)
     {
         $subLists = $this->siteService->getSubDistributorLists($request->parentId);

         return $subLists;
     }

     // 下拉選單初始化
     public function optionInit(Request $request)
     {
         $subLists = $this->siteService->getProxiesDropdownMenu($request);

         return $subLists;
     }
}
