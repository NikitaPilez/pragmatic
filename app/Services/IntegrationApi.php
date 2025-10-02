<?php

namespace App\Services;

class IntegrationApi
{
    const BASE_URL = 'https://api.prerelease-env.biz/IntegrationService/v3/http/CasinoGameAPI/';
    const REPLAY_URL = 'https://api.prerelease-env.biz/IntegrationService/v3/http/ReplayAPI/';
    const GAME_SERVER = 'https://easycash.prerelease-env.biz/';

    public $result = null;
    public $http_code = null;
    public $error = null;
    private $secureLogin;
    private $secretKey;
    private $proxy;
    private $proxyPassword;

    public function __construct()
    {
        $this->secureLogin = config('services.pragmatic.secure_login');
        $this->secretKey = config('services.pragmatic.secret_key');
        $this->proxy = config('services.pragmatic.proxy');
        $this->proxyPassword = config('services.pragmatic.proxy_password');
    }

    /**
     * 2.1 GetCasinoGames method
     *
     * @param array $options List of settings (String).
     * By including it, operator can get additional information about game.
     * Possible values are:
     * GetFrbDetails, GetLines, GetDataTypes, GetFeatures, GetFcDetails, GetStudio
     * FilterStudio=<studio_name>, for example FilterStudio=PP - for Pragmatic Play games
     * FilterStudio=FP - for Fat Panda games
     */
    public function getCasinoGames(array $options = []): array
    {
        $data = [
            'secureLogin' => $this->secureLogin,
            'options' => implode(',', $options),
        ];

        $data['hash'] = $this->generateHash($data);

        return $this->call('getCasinoGames', $data);
    }

    /**
     * 2.2 GetLobbyGames method
     *
     * @param string $categories
     * List of games (String).
     * Possible values are:
     * all – games from All Games category
     * new – games from New Games category
     * hot – games from Hot Games category
     * If multiple values are to be used, they are specified separated by commas.
     *
     * @param string $country
     * ISO Country code. Possibility to get games available (not blocked) for the specific country.
     */
    public function getLobbyGames(string $categories = 'all', string $country = ''): array
    {
        $data = [
            'secureLogin' => $this->secureLogin,
            'categories' => $categories,
        ];

        if ($country) {
            $data['country'] = $country;
        }

        $data['hash'] = $this->generateHash($data);

        return $this->call('getLobbyGames', $data);
    }

    /**
     * 2.3 CloseSession
     *
     * @param string $externalPlayerId id of the player within the Operator system.
     *
     * @param string $gameId id of the game.
     * This is optional parameter, which has to be sent by Operator if only the session for
     * specific game should be closed.
     *
     * @param int $clearHistory Specifies whether to clear the history of the round or not.
     * May have the following values:
     * 1 – history should be removed, so that the last game round cannot be completed anymore
     * 0 – last game round can be completed
     */
    public function closeSession(string $externalPlayerId, string $gameId = '', int $clearHistory = 0): array
    {
        $data = [
            'secureLogin' => $this->secureLogin,
            'externalPlayerId' => $externalPlayerId,
            'clearHistory' => $clearHistory,
        ];

        if ($gameId) {
            $data['gameId'] = $gameId;
        }

        $data['hash'] = $this->generateHash($data);

        return $this->call('closeSession', $data);
    }

    /**
     * 2.4 CancelRound
     *
     * @param string $externalPlayerId id of the player within the Operator system.
     * @param string $gameId id of the game. This is required parameter.
     * @param int $roundId id of the game round to be canceled (play session id).
     */
    public function cancelRound(string $externalPlayerId, string $gameId, int $roundId): array
    {
        $data = [
            'secureLogin' => $this->secureLogin,
            'externalPlayerId' => $externalPlayerId,
            'gameId' => $gameId,
            'roundId' => $roundId,
        ];

        $data['hash'] = $this->generateHash($data);

        return $this->call('cancelRound', $data);
    }

    /**
     * 2.5 HealthCheck
     *
     * @param bool $isApiService if true - check API service health check
     * If false - check game server health check
     */
    public function healthCheck(bool $isApiService): array
    {
        if ($isApiService) {
            $url = self::BASE_URL . 'health/heartbeatCheck';
        } else {
            $url = self::GAME_SERVER . 'gs2c/livetest';
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxyPassword);

        $this->result = curl_exec($ch);
        $this->http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->error = curl_error($ch);

        curl_close($ch);

        return [
            'result' => json_decode($this->result, true),
            'http_code' => $this->http_code,
            'error' => $this->error,
        ];
    }

    /**
     * 2.7 Replay link
     *
     * @param string $externalPlayerId id of the player within the operator system.
     * @param int $roundId unique identifier of the game round.
     */
    public function getReplayLink(string $externalPlayerId, int $roundId): array
    {
        $data = [
            'secureLogin' => $this->secureLogin,
            'externalPlayerId' => $externalPlayerId,
            'roundId' => $roundId,
        ];

        $data['hash'] = $this->generateHash($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::REPLAY_URL . 'getSharedLink?' . http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);

        curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxyPassword);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Cache-Control: no-cache'
        ]);

        $this->result = curl_exec($ch);
        $this->http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->error = curl_error($ch);

        curl_close($ch);

        return $this->call('getSharedLink', $data);
    }

    /**
     * 2.8 Error codes (catalogues)
     */
    public function getErrorCodes(): array
    {
        return [
            0   => 'OK',
            1   => 'Unauthorized - Incorrect secure login or hash',
            2   => 'Empty mandatory field',
            3   => 'Invalid parameter value',
            4   => 'Round not found',
            5   => 'No replay available for this round',
            17  => 'Player not found',
            99  => 'Request limit exceeded',
            100 => 'Internal error'
        ];
    }

    /**
     * 3.1.2 GameURL API method
     *
     * @param string $symbol id of the game within the Pragmatic Play system.
     *
     * @param string $language language on which the game should be opened.
     *
     * @param string $externalPlayerId unique identifier of the player within the Casino Operator system.
     * Parameter value is case-sensitive.
     *
     * @param string $playMode if value is `REAL` – return real game launch URL
     * If value is `DEMO` – return demo game launch URL.
     *
     * @param string $country country of the player. 2-letter Country code, ISO 3166-1 alpha-2.
     *
     * @param string|null $currency player's ISO 4217 currency code. Examples: 'EUR' or 'USD'.
     *
     * @param string|null $platform platform for which the game should be opened.
     *
     * @param string|null $technology H5 (for all games and devices)
     *
     * @param string|null $styleName unique identifier of the OPERATOR at PROVIDER side, not for all integration
     * protocols
     *
     * @param string|null $cashierUrl URL for opening the cashier on Casino Operator site when a player has no
     * funds
     *
     * @param string|null $lobbyUrl URL for returning to Lobby page on Casino Operator site. This link is used for
     * Back to Lobby (Home) button in mobile version of games
     *
     * @param string|null $rci the reality check interval, in minutes
     *
     * @param string|null $rce the reality check elapsed time, in minutes
     *
     * @param string|null $rcHistoryUrl link to the player’s game history.
     * For an iframe, the following example should be used:
     * rcHistoryUrl=javascript:window.parent.location.href={http://somewebsite.com/}
     *
     * @param string|null $rcCloseUrl link to the page on the Operator’s website, to which the player will be
     * redirected if they choose to close the game
     * For an iframe, the following example should be used:
     * rcCloseUrl=javascript:window.parent.location.href={http://somewebsite.com/}
     *
     * @param string|null $promo Indicates if player is allowed to participate promo campaign include. FSB,
     * Tournament and Prize Drop campaigns.
     * Possible values: “y”; “n” (Logic of this parameter application is described in note below)
     *
     * @param string|null $ctlGroup identification for specific table limits group is applicable for Live Casino
     * portfolio only
     *
     * @param string|null $jurisdiction Jurisdiction of the player. Within this method is used only for playMode=DEMO.
     *
     * @param string|null $miniMode 1 or 0 Enable or disable mini mode open game
     *
     * @param string|null $operatorGameHistoryUrl URL to open game history page on Operator’s side
     *
     * @param string|null $lobbyFilter When requesting a URL for LC game – filter values which will be predefined
     * when user will open Live Casino lobby category.
     * Possible values available in section 18.4 Predefined filters in Live Casino Lobby categories
     * If no option or incorrect value is sent in the ‘lobbyFilter’ parameter, it should NOT be changed.
     *
     * @param string|null $lobbyCategory Category that will be opened in the lobby by default when launched.
     * Possible options:
     * `FOR_YOU` – For you category will be opened when launching the lobby
     * `NEW` – New category will be opened when launching the lobby
     * `ALL_SLOTS` – All Slots category will be opened when launching the lobby
     * `DDW` – Drops and Wins category will be opened when launching the lobby;
     * `CRASHGAMES` – Crash games category will be opened when launching the lobby.
     * If no option or incorrect value is sent in the ‘lobbyCategory’ parameter, it should NOT be changed.
     *
     * @param string|null $token Secure one-time token is generated by OPERATOR for specific player.
     * Not required if playMode=DEMO
     */
    public function gameUrl(
        string $symbol,
        string $language,
        string $externalPlayerId,
        string $playMode,
        string $country,
        ?string $currency = null,
        ?string $platform = null,
        ?string $technology = null,
        ?string $styleName = null,
        ?string $cashierUrl = null,
        ?string $lobbyUrl = null,
        ?string $rci = null,
        ?string $rce = null,
        ?string $rcHistoryUrl = null,
        ?string $rcCloseUrl = null,
        ?string $promo = null,
        ?string $ctlGroup = null,
        ?string $jurisdiction = null,
        ?string $miniMode = null,
        ?string $operatorGameHistoryUrl = null,
        ?string $lobbyFilter = null,
        ?string $lobbyCategory = null,
        ?string $token = null): array
    {
        $data = [
            'secureLogin' => $this->secureLogin,
            'symbol' => $symbol,
            'language' => $language,
            'externalPlayerId' => $externalPlayerId,
            'playMode' => $playMode,
            'country' => $country,
        ];

        if ($currency) {
            $data['currency'] = $currency;
        }

        if ($platform) {
            $data['platform'] = $platform;
        }

        if ($technology) {
            $data['technology'] = $technology;
        }

        if ($styleName) {
            $data['styleName'] = $styleName;
        }

        if ($cashierUrl) {
            $data['cashierUrl'] = $cashierUrl;
        }

        if ($lobbyUrl) {
            $data['lobbyUrl'] = $lobbyUrl;
        }

        if ($rci) {
            $data['rci'] = $rci;
        }

        if ($rce) {
            $data['rce'] = $rce;
        }

        if ($rcHistoryUrl) {
            $data['rcHistoryUrl'] = $rcHistoryUrl;
        }

        if ($rcCloseUrl) {
            $data['rcCloseUrl'] = $rcCloseUrl;
        }

        if ($promo) {
            $data['promo'] = $promo;
        }

        if ($ctlGroup) {
            $data['ctlGroup'] = $ctlGroup;
        }

        if ($jurisdiction) {
            $data['jurisdiction'] = $jurisdiction;
        }

        if ($miniMode) {
            $data['miniMode'] = $miniMode;
        }

        if ($operatorGameHistoryUrl) {
            $data['operatorGameHistoryUrl'] = $operatorGameHistoryUrl;
        }

        if ($lobbyFilter) {
            $data['lobbyFilter'] = $lobbyFilter;
        }

        if ($lobbyCategory) {
            $data['lobbyCategory'] = $lobbyCategory;
        }

        if ($token) {
            $data['token'] = $token;
        }

        $data['hash'] = $this->generateHash($data);

        return $this->call('game/url', $data);
    }

    public function generateHash(array $params): string
    {
        ksort($params);

        $plain = urldecode(http_build_query($params, '', '&'));

        return md5($plain . $this->secretKey);
    }

    public function call($method, $params = []): array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::BASE_URL . $method . '/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxyPassword);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'Cache-Control: no-cache'
        ]);

        $this->result = curl_exec($ch);
        $this->http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->error = curl_error($ch);

        curl_close($ch);

        return [
            'result' => json_decode($this->result, true),
            'http_code' => $this->http_code,
            'error' => $this->error,
        ];
    }
}
