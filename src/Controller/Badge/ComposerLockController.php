<?php

/*
 * This file is part of the badge-poser package.
 *
 * (c) PUGX <http://pugx.github.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Badge;

use App\Badge\Infrastructure\ResponseFactory;
use App\Badge\Model\UseCase\CreateComposerLockBadge;
use App\Badge\Service\ImageFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UnexpectedValueException;

/**
 * Class Composer lock.
 * Composer-lock action for badges.
 *
 * @author Andreas Heigl <andreas@heigl.org>
 * @author Andrea Giannantonio <a.giannantonio@gmail.com>
 */
class ComposerLockController extends Controller
{
    /**
     * ComposerLock action.
     *
     * @param Request $request
     * @param ImageFactory $imageFactory
     * @param CreateComposerLockBadge $composerLockBadge
     * @param string $repository repository
     *
     * @param string $format
     * @return Response
     * @throws UnexpectedValueException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @Method({"GET"})
     * @Cache(maxage="3600", smaxage="3600", public=true)
     */
    public function composerLockAction(
        Request $request,
        ImageFactory $imageFactory,
        CreateComposerLockBadge $composerLockBadge,
        $repository,
        $format='svg'): Response
    {
        if ($request->query->get('format') === 'plastic') {
            $format = 'plastic';
        }

        $badge = $composerLockBadge->createComposerLockBadge($repository, $format);
        $image = $imageFactory->createFromBadge($badge);

        return ResponseFactory::createFromImage($image, 200);
    }
}
