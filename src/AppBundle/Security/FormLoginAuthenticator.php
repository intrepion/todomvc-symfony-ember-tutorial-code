<?php

namespace AppBundle\Security;

use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;

use KnpU\Guard\Authenticator\AbstractFormLoginAuthenticator;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\RouterInterface;

use Symfony\Component\Security\Core\Exception\BadCredentialsException;

use Symfony\Component\Security\Core\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @Service("app.form_login_authenticator")
 */
class FormLoginAuthenticator extends AbstractFormLoginAuthenticator
{
    private $router;

    private $securityPasswordEncoder;

    /**
     * @InjectParams({
     *     "router" = @Inject("router"),
     *     "securityPasswordEncoder" = @Inject("security.password_encoder"),
     * })
     */
    public function __construct($router, $securityPasswordEncoder)
    {
        $this->router = $router;
        $this->securityPasswordEncoder = $securityPasswordEncoder;
    }

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

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials['username']);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if (false === $this->securityPasswordEncoder
            ->isPasswordValid($user, $credentials['password'])) {
            // throw any AuthenticationException
            throw new BadCredentialsException();
        }
    }

    protected function getLoginUrl()
    {
        return $this->router
            ->generate('homepage');
    }

    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router
            ->generate('homepage');
    }
}
