<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    private RouterInterface $router;
    private RequestStack $requestStack;

    public function __construct(RouterInterface $router, RequestStack $requestStack)
    {
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    public function handle($request, AccessDeniedException $accessDeniedException): ?RedirectResponse
    {
        /** @var SessionInterface|null $session */
        $session = $this->requestStack->getSession();
        if ($session) {
            $session->getFlashBag()->add('danger', 'Accès refusé.');
        }

        return new RedirectResponse($this->router->generate('home'));
    }
}
