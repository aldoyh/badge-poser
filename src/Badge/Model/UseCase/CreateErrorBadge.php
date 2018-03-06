<?php

/*
 * This file is part of the badge-poser package.
 *
 * (c) PUGX <http://pugx.github.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Badge\Model\UseCase;

use App\Badge\Model\Badge;
use GuzzleHttp\Exception\BadResponseException;
use UnexpectedValueException;

/**
 * Create the 'error' badge with the standard Font and standard Image.
 */
class CreateErrorBadge
{
    CONST COLOR = 'e05d44';
    CONST SUBJECT = 'error';
    CONST ERROR_TEXT_GENERIC = 'generic';
    CONST ERROR_TEXT_CLIENT_EXCEPTION = 'connection';
    CONST ERROR_TEXT_CLIENT_BAD_RESPONSE = 'not found?';

    /**
     * @param $exception
     * @param $format
     * @return Badge
     */
    public function createErrorBadge($exception, $format): Badge
    {
        return $this->createBadge($exception, $format);
    }

    /**
     * @param $exception
     * @param $format
     * @return Badge
     */
    protected function createBadge($exception, $format): Badge
    {
        $subject =  'error';
        $status = self::ERROR_TEXT_GENERIC;
        if ($exception instanceof BadResponseException) {
            $status = self::ERROR_TEXT_CLIENT_BAD_RESPONSE;
        } elseif ($exception instanceof UnexpectedValueException) {
            $status = self::ERROR_TEXT_CLIENT_EXCEPTION;
        }

        return new Badge((string) $exception, $status, self::COLOR, $format);
    }
}
