<?php

namespace App\Http\Controllers;

use App\Services\IntegrationApi;

class PragmaticController extends Controller
{
    private $api;
    public function __construct(IntegrationApi $api)
    {
        $this->api = $api;
    }

    public function casinoGames()
    {
        dd($this->api->getCasinoGames([
            'GetFrbDetails',
            'GetLines',
            'GetDataTypes',
            'GetFcDetails',
            'GetStudio',
            'GetFeatures',
            'GetFrbDetails',
        ]));
    }

    public function lobbyGames()
    {
        dd($this->api->getLobbyGames('all', 'ES'));
    }

    public function closeSession()
    {
        dd($this->api->closeSession('nmikser1', 'vs20lobcrab', 1));
    }

    public function cancelRound()
    {
        dd($this->api->cancelRound('nmikser1', 'vs20lobcrab', '1'));
    }

    public function healthCheck()
    {
        dd($this->api->healthCheck(true));
    }

    public function replayLink()
    {
        dd($this->api->getReplayLink('player123', '1234567890'));
    }

    public function gameUrl()
    {
        dd($this->api->gameUrl('scgoldrush', 'ru', 'player12345', 'REAL', 'RU', 'USD'));
    }
}
