<?php

namespace App\Services;

class PragmaticErrorCodesService
{
    /**
     * Success
     *
     * @return int
     */
    public static function getSuccessCode(): int
    {
        return 0;
    }

    /**
     * Insufficient balance.
     * The error should be returned in the response on the bet request.
     *
     * @return int
     */
    public static function getInsufficientBalanceCode(): int
    {
        return 1;
    }

    /**
     * Player not found or is logged out.
     * Should be returned in the response on any request if the player
     * can’t be found or is logged out at Casino Operator’s side.
     *
     * @return int
     */
    public static function getPlayerNotFoundCode(): int
    {
        return 2;
    }

    /**
     * Bet is not allowed.
     * Should be returned when the player is not allowed to play a specific game.
     *
     * @return int
     */
    public static function getBetNotAllowedCode(): int
    {
        return 3;
    }

    /**
     * Player authentication failed due to invalid, not found or expired token.
     *
     * @return int
     */
    public static function getAuthenticationFailedCode(): int
    {
        return 4;
    }

    /**
     * Invalid hash code.
     * Should be returned if the hash code validation failed.
     *
     * @return int
     */
    public static function getInvalidHashCode(): int
    {
        return 5;
    }

    /**
     * Player is frozen.
     * Should be returned if player account is banned or frozen.
     *
     * @return int
     */
    public static function getPlayerFrozenCode(): int
    {
        return 6;
    }

    /**
     * Bad parameters in the request.
     *
     * @return int
     */
    public static function getBadParametersCode(): int
    {
        return 7;
    }

    /**
     * Game is not found or disabled.
     * Should be returned on Bet request if the game cannot be played.
     *
     * @return int
     */
    public static function getGameNotFoundCode(): int
    {
        return 8;
    }

    /**
     * Bet limit has been reached.
     * Relevant for regulated markets.
     *
     * @return int
     */
    public static function getBetLimitReachedCode(): int
    {
        return 50;
    }

    /**
     * Internal server error (with retry).
     * Request will follow Reconciliation process.
     *
     * @return int
     */
    public static function getInternalServerErrorRetryCode(): int
    {
        return 100;
    }

    /**
     * Internal server error (no retry).
     * Request will NOT follow Reconciliation process.
     *
     * @return int
     */
    public static function getInternalServerErrorNoRetryCode(): int
    {
        return 101;
    }

    /**
     * Internal server error on EndRound processing (retry).
     * Used only for EndRound method.
     *
     * @return int
     */
    public static function getInternalServerErrorEndRoundCode(): int
    {
        return 102;
    }

    /**
     * Reality check warning.
     *
     * @return int
     */
    public static function getRealityCheckWarningCode(): int
    {
        return 210;
    }

    /**
     * Player’s bet is out of his bet limits.
     * Should be returned if player’s limits have changed, and the bet
     * is out of new limit levels.
     *
     * @return int
     */
    public static function getBetOutOfLimitsCode(): int
    {
        return 310;
    }
}
