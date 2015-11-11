<?php

namespace AppBundle\Security;

use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;

use KnpU\Guard\AbstractGuardAuthenticator;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

use Symfony\Component\Security\Core\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

/**
 * @Service("app.login_authenticator")
 */
class LoginAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var AuthenticationFailureHandlerInterface
     */
    private $handlerFailure;

    /**
     * @var AuthenticationSuccessHandlerInterface
     */
    private $handlerSuccess;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    /**
     * @InjectParams({
     *     "handlerFailure" = @Inject("lexik_jwt_authentication.handler.authentication_failure"),
     *     "handlerSuccess" = @Inject("lexik_jwt_authentication.handler.authentication_success"),
     *     "userPasswordEncoder" = @Inject("security.password_encoder"),
     * })
     */
    public function __construct(
        AuthenticationFailureHandlerInterface $handlerFailure,
        AuthenticationSuccessHandlerInterface $handlerSuccess,
        UserPasswordEncoderInterface $userPasswordEncoder
    )
    {
        $this->handlerFailure = $handlerFailure;
        $this->handlerSuccess = $handlerSuccess;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * {@inheritDoc}
     */
    public function getCredentials(Request $request)
    {
        if ($request->getPathInfo() !== '/login_check') {
            return;
        }

        $username = $request->request->get('_username');
        $request->getSession()->set(Security::LAST_USERNAME, $username);
        $password = $request->request->get('_password');

        return array(
            'username' => $username,
            'password' => $password
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
        if (false === $this->userPasswordEncoder
            ->isPasswordValid($user, $credentials['password'])) {
            // throw any AuthenticationException
            throw new BadCredentialsException();
        }
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
        return $this->handlerSuccess->onAuthenticationSuccess($request, $token);
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
        return new JsonReponse(
            // you could translate the message
            array('message' => 'Authentication required'),
            401
        );
    }
}
