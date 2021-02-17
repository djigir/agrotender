<?php

namespace App\Http\Controllers;

use App\Models\ADV\AdvTorgPost;
use App\Models\ADV\AdvTorgPostComplains;
use App\Models\ADV\AdvWordTopic;
use App\Models\Comp\CompItems;
use App\Models\Elevators\TorgElevator;
use App\Models\Seo\SeoTitles;
use App\Models\Seo\SeoTitlesBoard;
use App\Models\Torg\TorgBuyer;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function traders()
    {
        CompItems::whereIn('id', \request()->get('_id'))->delete();
    }

    public function posts()
    {
        AdvTorgPost::whereIn('id', \request()->get('_id'))->delete();
    }

    public function torgPostComplains()
    {
        AdvTorgPostComplains::whereIn('id', \request()->get('_id'))->delete();
    }

    public function torgElevators()
    {
        TorgElevator::whereIn('id', \request()->get('_id'))->delete();
    }

    public function advWordTopics()
    {
        AdvWordTopic::whereIn('id', \request()->get('_id'))->delete();
    }

    public function seoTitlesBoards()
    {
        SeoTitlesBoard::whereIn('id', \request()->get('_id'))->delete();
    }

    public function seoTitles()
    {
        SeoTitles::whereIn('id', \request()->get('_id'))->delete();
    }

    public function torgBuyers()
    {
        TorgBuyer::whereIn('id', \request()->get('_id'))->delete();
    }

    public function compItemsActives()
    {
        CompItems::whereIn('id', \request()->get('_id'))->delete();
    }
}
