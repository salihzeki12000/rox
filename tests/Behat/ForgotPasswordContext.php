<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use App\Repository\UserRepository;
use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behatch\Context\RestContext;
use CoopTilleuls\ForgotPasswordBundle\Manager\PasswordTokenManager;
use Doctrine\ORM\EntityManagerInterface;

final class ForgotPasswordContext extends RawMinkContext
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;
    private PasswordTokenManager $passwordTokenManager;
    private ?RestContext $restContext;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, PasswordTokenManager $passwordTokenManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->passwordTokenManager = $passwordTokenManager;
    }

    /**
     * @BeforeScenario
     */
    public function gatherContexts(BeforeScenarioScope $scope): void
    {
        /** @var InitializedContextEnvironment $environment */
        $environment = $scope->getEnvironment();
        $this->restContext = $environment->getContext(RestContext::class);
    }

    /**
     * @Given I have a valid token
     */
    public function iHaveAValidToken()
    {
        $this->passwordTokenManager->createPasswordToken($this->userRepository->loadUserByUsername('john.doe@example.com'));
    }

    /**
     * @Given I have an expired token
     */
    public function iHaveAnExpiredToken()
    {
        $this->passwordTokenManager->createPasswordToken($this->userRepository->loadUserByUsername('john.doe@example.com'), new \DateTime('-1 minute'));
    }

    /**
     * @Then I update my password
     */
    public function iUpdateMyPassword()
    {
        $token = $this->passwordTokenManager->createPasswordToken($this->userRepository->loadUserByUsername('john.doe@example.com'));

        $this->restContext->iSendARequestToWithBody(
            'POST',
            sprintf('/forgot_password/%s', $token->getToken()),
            new PyStringNode([
            <<<'JSON'
{
    "password": "foo"
}
JSON], null)
        );
    }

    /**
     * @Then I update my password using no password
     */
    public function iUpdateMyPasswordUsingNoPassword()
    {
        $token = $this->passwordTokenManager->createPasswordToken($this->userRepository->loadUserByUsername('john.doe@example.com'));

        $this->restContext->iSendARequestTo('POST', sprintf('/forgot_password/%s', $token->getToken()));
    }

    /**
     * @Then I update my password using an expired token
     */
    public function iUpdateMyPasswordUsingAnExpiredToken()
    {
        $token = $this->passwordTokenManager->createPasswordToken($this->userRepository->loadUserByUsername('john.doe@example.com'), new \DateTime('-1 minute'));

        $this->restContext->iSendARequestToWithBody(
            'POST',
            sprintf('/forgot_password/%s', $token->getToken()),
            new PyStringNode([
            <<<'JSON'
{
    "password": "foo"
}
JSON], null)
        );
    }

    /**
     * @Then I get a password token
     */
    public function iGetAPasswordToken()
    {
        $token = $this->passwordTokenManager->createPasswordToken($this->userRepository->loadUserByUsername('john.doe@example.com'));
        $token->setToken('d7xtQlJVyN61TzWtrY6xy37zOxB66BqMSDXEbXBbo2Mw4Jjt9C');
        $this->entityManager->persist($token);
        $this->entityManager->flush($token);

        $this->restContext->iSendARequestTo('GET', sprintf('/forgot_password/%s', $token->getToken()));
    }

    /**
     * @Then I get a password token using an expired token
     */
    public function iGetAPasswordTokenUsingAnExpiredToken()
    {
        $token = $this->passwordTokenManager->createPasswordToken($this->userRepository->loadUserByUsername('john.doe@example.com'), new \DateTime('-1 minute'));

        $this->restContext->iSendARequestTo('GET', sprintf('/forgot_password/%s', $token->getToken()));
    }
}
