<?php

namespace AppBundle\Security;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;

use KnpU\Guard\AbstractGuardAuthenticator;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

use Symfony\Component\Security\Core\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

/**
 * @Service("app.json_web_token_authenticator")
 */
class JsonWebTokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var AuthenticationFailureHandlerInterface
     */
    private $handlerFailure;

    /**
     * @var AuthenticationSuccessHandlerInterface
     */
    private $handlerSuccess;

    /**
     * @var JWTEncoderInterface
     */
    private $jwtEncoder;

    /**
     * @InjectParams({
     *     "entityManager" = @Inject("doctrine.orm.entity_manager"),
     *     "handlerFailure" = @Inject("lexik_jwt_authentication.handler.authentication_failure"),
     *     "handlerSuccess" = @Inject("lexik_jwt_authentication.handler.authentication_success"),
     *     "jwtEncoder" = @Inject("lexik_jwt_authentication.jwt_encoder"),
     * })
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        AuthenticationFailureHandlerInterface $handlerFailure,
        AuthenticationSuccessHandlerInterface $handlerSuccess,
        JWTEncoderInterface $jwtEncoder
    )
    {
        $this->entityManager = $entityManager;
        $this->handlerFailure = $handlerFailure;
        $this->handlerSuccess = $handlerSuccess;
        $this->jwtEncoder = $jwtEncoder;
    }

    /**
     * {@inheritDoc}
     */
    public function getCredentials(Request $request)
    {
        if (substr($request->getPathInfo(), 0, 5) !== '/api/') {
            return;
        }

        $payload = $this->jwtEncoder
            ->decode($request->request->get('jsonWebToken'));

        return array(
            'username' => $payload['username'],
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials['username']);
    }

    /**
     * {@inheritDoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        // no need to check
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return $this->handlerFailure->onAuthenticationFailure($request, $exception);
    }

    /**
     * {@inheritDoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // do nothing - let the request just continue!
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function start(Request $request, AuthenticationException $authenticationException = null)
    {
        return new JsonResponse(
            // you could translate the message
            array('message' => 'Authentication required'),
            401
        );
    }
}
