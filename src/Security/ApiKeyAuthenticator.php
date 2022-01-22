<?php

namespace App\Security;

use App\Entity\ApiClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiKeyAuthenticator extends AbstractAuthenticator
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function supports(Request $request): ?bool
    {
        // always use this authenticator to authenticate requests
        return true;
    }

    public function authenticate(Request $request): PassportInterface
    {
        $appId = $request->headers->get('X-APP-ID');
        $appSecret = $request->headers->get('X-APP-SECRET');

        if (empty($appId) || empty($appSecret)) {
            // The app id and secret header were empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"
            throw new CustomUserMessageAuthenticationException('No API key provided');
        }

        $app = $this->entityManager->getRepository(ApiClient::class)->findOneBy(['appId' => $appId, 'appSecret' => $appSecret]);

        if (!$app) {
            // client id or secret incorrect
            // Code 401 "Unauthorized"
            throw new CustomUserMessageAuthenticationException('Invalid Credentials');
        }

        return new SelfValidatingPassport(new UserBadge($appId, function () use ($app) {
            return $app;
        }));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}
