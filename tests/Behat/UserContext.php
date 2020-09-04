<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use App\Repository\MemberRepository;
use Behat\MinkExtension\Context\RawMinkContext;

final class UserContext extends RawMinkContext
{
    private $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    /**
     * @Then the user :username should be locked
     */
    public function login(string $username): void
    {
        $user = $this->memberRepository->loadUserByUsername($username);
        if (null === $user) {
            throw new \RuntimeException("User \"$username\" does not exist.");
        }

        if ($user->isEnabled()) {
            throw new \RuntimeException("User \"$username\" is enabled.");
        }
    }
}
