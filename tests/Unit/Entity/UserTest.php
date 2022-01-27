<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTest extends KernelTestCase
{
    public function assertHasErrors(User $user, int $numberError = 0, string $field = null, array $fieldMessages = null): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $errors = $container->get("validator")->validate($user);

        $debugMessages = [];
        $errorMessages = [];
        $errorField = "";

        foreach ($errors as $error) {
            $debugMessages[] = $error->getPropertyPath() . " : " . $error->getMessage();
            $errorMessages[] = $error->getMessage();
            $errorField = $error->getPropertyPath();
        }

        $this->assertCount($numberError, $errors, implode(', ', $debugMessages));

        if (!is_null($field) && !is_null($fieldMessages)) {
            $this->assertEquals($field, $errorField);
            $this->assertEquals($fieldMessages, $errorMessages);
        }
    }

    public function testValidUser(): void
    {
        $user = (new User())
            ->setEmail("user@domain.com")
            ->setPlainPassword("Azerty")
            ->setFirstName("Alexandre")
            ->setLastName("Marchand")
            ->setBirthdate(new DateTime('2022-04-25', new DateTimeZone('UTC')))
            ->setPhoneNumber("0034611223344")
            ->setRoles(["USER_ROLE"]);

        $this->assertHasErrors($user, 0);
    }
    /**
     * firstName
     */
    public function testInValidUserFirstName(): void
    {
        $user = (new User())
            ->setEmail("user@domain.com")
            ->setPlainPassword("Azerty")
            ->setFirstName("Alexandre >")
            ->setLastName("Marchand")
            ->setBirthdate(new DateTime('2022-04-25', new DateTimeZone('UTC')))
            ->setPhoneNumber("0034611223344")
            ->setRoles(["USER_ROLE"]);

        $this->assertHasErrors($user, 1, "firstName", ["This value is not valid."]);
    }

    public function testInValidUserFirstNameNotSet(): void
    {
        $user = (new User())
            ->setEmail("user@domain.com")
            ->setPlainPassword("Azerty")
            ->setLastName("Marchand")
            ->setBirthdate(new DateTime('2022-04-25', new DateTimeZone('UTC')))
            ->setPhoneNumber("0034611223344")
            ->setRoles(["USER_ROLE"]);

        $this->assertHasErrors($user, 1, "firstName", ["This value should not be null."]);
    }

    public function testInValidUserFirstNameNotEmpty(): void
    {
        $user = (new User())
            ->setEmail("user@domain.com")
            ->setPlainPassword("Azerty")
            ->setFirstName("")
            ->setLastName("Marchand")
            ->setBirthdate(new DateTime('2022-04-25', new DateTimeZone('UTC')))
            ->setPhoneNumber("0034611223344")
            ->setRoles(["USER_ROLE"]);

        $this->assertHasErrors($user, 2, "firstName", ["This value should not be blank.", "This value is too short. It should have 1 character or more."]);
    }
    /**
     * lastName
     */
    public function testInValidUserLastName(): void
    {
        $user = (new User())
            ->setEmail("user@domain.com")
            ->setPlainPassword("Azerty")
            ->setFirstName("Alexandre")
            ->setLastName("Marchand >")
            ->setBirthdate(new DateTime('2022-04-25', new DateTimeZone('UTC')))
            ->setPhoneNumber("0034611223344")
            ->setRoles(["USER_ROLE"]);

        $this->assertHasErrors($user, 1, "lastName", ["This value is not valid."]);
    }

    public function testInValidUserLastNameNotSet(): void
    {
        $user = (new User())
            ->setEmail("user@domain.com")
            ->setPlainPassword("Azerty")
            ->setFirstName("Alexandre")
            ->setBirthdate(new DateTime('2022-04-25', new DateTimeZone('UTC')))
            ->setPhoneNumber("0034611223344")
            ->setRoles(["USER_ROLE"]);

        $this->assertHasErrors($user, 1, "lastName", ["This value should not be null."]);
    }

    public function testInValidUserLastNameNotEmpty(): void
    {
        $user = (new User())
            ->setEmail("user@domain.com")
            ->setPlainPassword("Azerty")
            ->setFirstName("Alexandre")
            ->setLastName("")
            ->setBirthdate(new DateTime('2022-04-25', new DateTimeZone('UTC')))
            ->setPhoneNumber("0034611223344")
            ->setRoles(["USER_ROLE"]);

        $this->assertHasErrors($user, 2, "lastName", ["This value should not be blank.", "This value is too short. It should have 1 character or more."]);
    }

    /**
     * plainPassword todo
     */
    public function testInValidUserplainPasswordTooShort(): void
    {
        $user = (new User())
            ->setEmail("user@domain.com")
            ->setPlainPassword("a")
            ->setFirstName("Alexandre")
            ->setLastName("Marchand")
            ->setBirthdate(new DateTime('2022-04-25', new DateTimeZone('UTC')))
            ->setPhoneNumber("0034611223344")
            ->setRoles(["USER_ROLE"]);

        $this->assertHasErrors($user, 1, "plainPassword", ["This value is too short. It should have 6 characters or more."]);
    }

    /**
     * phoneNumber 
     */
    public function testInValidUserPhoneNumber(): void
    {
        $user = (new User())
            ->setEmail("user@domain.com")
            ->setPlainPassword("azerty")
            ->setFirstName("Alexandre")
            ->setLastName("Marchand")
            ->setBirthdate(new DateTime('2022-04-25', new DateTimeZone('UTC')))
            ->setPhoneNumber("34611223344")
            ->setRoles(["USER_ROLE"]);

        $this->assertHasErrors($user, 1, "phoneNumber", ["This value is not valid."]);
    }

    /**
     * email
     */
    public function testInValidEmail(): void
    {
        $email = "userdomain.com";
        $user = (new User())
            ->setEmail($email)
            ->setPlainPassword("azerty")
            ->setFirstName("Alexandre")
            ->setLastName("Marchand")
            ->setBirthdate(new DateTime('2022-04-25', new DateTimeZone('UTC')))
            ->setPhoneNumber("0034611223344")
            ->setRoles(["USER_ROLE"]);;

        $this->assertHasErrors($user, 1, "email", ["The email '\"$email\"' is not a valid email."]);
    }

    public function testInValidEmailNotSet(): void
    {
        $user = (new User())
            ->setPlainPassword("azerty")
            ->setFirstName("Alexandre")
            ->setLastName("Marchand")
            ->setBirthdate(new DateTime('2022-04-25', new DateTimeZone('UTC')))
            ->setPhoneNumber("0034611223344")
            ->setRoles(["USER_ROLE"]);;

        $this->assertHasErrors($user, 1, "email", ["This value should not be null."]);
    }

    public function testInValidEmailEmpty(): void
    {
        $user = (new User())
            ->setEmail("")
            ->setPlainPassword("azerty")
            ->setFirstName("Alexandre")
            ->setLastName("Marchand")
            ->setBirthdate(new DateTime('2022-04-25', new DateTimeZone('UTC')))
            ->setPhoneNumber("0034611223344")
            ->setRoles(["USER_ROLE"]);;

        $this->assertHasErrors($user, 1, "email", ["This value should not be blank."]);
    }
}
