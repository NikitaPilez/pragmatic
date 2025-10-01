<?php

namespace App\Http\Controllers;

use App\Http\HttpResponse;
use App\Services\IntegrationApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class PragmaticController extends Controller
{
    private $api;
    public function __construct(IntegrationApi $api)
    {
        $this->api = $api;
    }

    public function casinoGames(Request $request): JsonResponse
    {
        $options = $request->input('params', []);

        try {
            $apiResponse = $this->api->getCasinoGames($options);

            return HttpResponse::make()->withData($apiResponse)->send();
        } catch (Throwable $e) {

            logger()->error('Get casino games error', [
                'message' => $e->getMessage(),
                'options' => $options,
            ]);

            return HttpResponse::make()->serverError()->send();
        }
    }

    public function lobbyGames(Request $request): JsonResponse
    {
        $categories = $request->input('categories', 'all');
        $country = $request->input('country', '');

        try {
            $apiResponse = $this->api->getLobbyGames($categories, $country);

            return HttpResponse::make()->withData($apiResponse)->send();
        } catch (Throwable $e) {

            logger()->error('Get lobby games error', [
                'message' => $e->getMessage(),
                'categories' => $categories,
                'country' => $country,
            ]);

            return HttpResponse::make()->serverError()->send();
        }
    }

    public function closeSession(Request $request): JsonResponse
    {
        $externalPlayerId = $request->input('external_player_id');
        $gameId = $request->input('game_id', '');
        $isClearHistory = $request->input('clear_history', 0);

        try {
            $apiResponse = $this->api->closeSession($externalPlayerId, $gameId, $isClearHistory);

            return HttpResponse::make()->withData($apiResponse)->send();
        } catch (Throwable $e) {

            logger()->error('Close session error', [
                'message' => $e->getMessage(),
                'externalPlayerId' => $externalPlayerId,
                'gameId' => $gameId,
                'clearHistory' => $isClearHistory,
            ]);

            return HttpResponse::make()->serverError()->send();
        }
    }

    public function cancelRound(Request $request): JsonResponse
    {
        $externalPlayerId = $request->input('external_player_id');
        $gameId = $request->input('game_id', '');
        $roundId = $request->input('round_id', 1);

        try {
            $apiResponse = $this->api->cancelRound($externalPlayerId, $gameId, $roundId);

            return HttpResponse::make()->withData($apiResponse)->send();
        } catch (Throwable $e) {

            logger()->error('Cancel round error', [
                'message' => $e->getMessage(),
                'externalPlayerId' => $externalPlayerId,
                'gameId' => $gameId,
                'roundId' => $roundId,
            ]);

            return HttpResponse::make()->serverError()->send();
        }
    }

    public function healthCheck(Request $request): JsonResponse
    {
        $isApiService = $request->input('is_api_service', 1);

        try {
            $apiResponse = $this->api->healthCheck($isApiService);

            return HttpResponse::make()->withData($apiResponse)->send();
        } catch (Throwable $e) {

            logger()->error('Health check error', [
                'message' => $e->getMessage(),
                'is_api_service' => $isApiService,
            ]);

            return HttpResponse::make()->serverError()->send();
        }
    }

    public function replayLink(Request $request): JsonResponse
    {
        $externalPlayerId = $request->input('external_player_id');
        $roundId = $request->input('round_id');

        try {
            $apiResponse = $this->api->getReplayLink($externalPlayerId, $roundId);

            return HttpResponse::make()->withData($apiResponse)->send();
        } catch (Throwable $e) {

            logger()->error('Replay link error', [
                'message' => $e->getMessage(),
                'external_player_id' => $externalPlayerId,
                'round_id' => $roundId,
            ]);

            return HttpResponse::make()->serverError()->send();
        }
    }

    public function gameUrl(Request $request): JsonResponse
    {
        $symbol = $request->input('symbol');
        $language = $request->input('language');
        $externalPlayerId = $request->input('external_player_id');
        $playMode = $request->input('play_mode');
        $country = $request->input('country');
        $currency = $request->input('currency');
        $platform = $request->input('platform');
        $technology = $request->input('technology');
        $styleName = $request->input('style_name');
        $cashierUrl = $request->input('cashier_url');
        $lobbyUrl = $request->input('lobby_url');
        $rci = $request->input('rci');
        $rce = $request->input('rce');
        $rcHistoryUrl = $request->input('rc_history_url');
        $rcCloseUrl = $request->input('rc_close_url');
        $promo = $request->input('promo');
        $ctlGroup = $request->input('ctl_group');
        $jurisdiction = $request->input('jurisdiction');
        $miniMode = $request->input('mini_mode');
        $operatorGameHistoryUrl = $request->input('operator_game_history_url');
        $lobbyFilter = $request->input('lobby_filter');
        $lobbyCategory = $request->input('lobby_category');
        $token = $request->input('token');

        try {
            $apiResponse = $this->api->gameUrl(
                $symbol,
                $language,
                $externalPlayerId,
                $playMode,
                $country,
                $currency,
                $platform,
                $technology,
                $styleName,
                $cashierUrl,
                $lobbyUrl,
                $rci,
                $rce,
                $rcHistoryUrl,
                $rcCloseUrl,
                $promo,
                $ctlGroup,
                $jurisdiction,
                $miniMode,
                $operatorGameHistoryUrl,
                $lobbyFilter,
                $lobbyCategory,
                $token
            );

            return HttpResponse::make()->withData($apiResponse)->send();
        } catch (Throwable $e) {

            logger()->error('Game url error', array_merge($request->all(), ['message' => $e->getMessage()]));

            return HttpResponse::make()->serverError()->send();
        }
    }
}
