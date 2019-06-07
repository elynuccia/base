<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 05/06/2019
 * Time: 11:29
 */

namespace App\Listener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SchoolCodeListener
{

    private $authorizationChecker;
    private $tokenStorage;
    private $router;

    public function __construct(TokenStorage $tokenStorage, Router $router, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function onKernelController(FilterControllerEvent $event)
    {

        if($this->tokenStorage->getToken()) {
            $user = $this->tokenStorage->getToken()->getUser();

            if($this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY') &&
                $this->authorizationChecker->isGranted('ROLE_0AUTH_USER') &&
                !$user->getSchoolCode() && $event->getRequest()->getRequestUri() != '/schoolcode') {
                $redirectUrl=$this->router->generate('school_code');
//pagina che devo creare
                $event->setController(function() use ($redirectUrl) {
                    return new RedirectResponse($redirectUrl);
                });

            }
        }
    }

}