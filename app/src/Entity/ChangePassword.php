<?php
/**
 * ChangePassword entity.
 */

namespace App\Entity;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
{
/**
* @SecurityAssert\UserPassword(
*     message = "Wpisz poprawnie swoje aktualne hasło"
* )
*/
protected $oldPassword;

/**
* @Assert\Length(
*     min = 6,
*     minMessage = "Hasło powinno mieć przynajmniej 6 znaków"
* )
*/
protected $newPassword;


/**
 * Getter for the oldPassword.
 *
 * @return string|null oldPassword
 */
public function getOldPassword(): ?string
{
    return $this->oldPassword;
}

/**
 * Setter for the oldPassword.
 *
 * @param string $oldPassword oldPassword
 */
public function setOldPassword(string $oldPassword): void
{
    $this->oldPassword = $oldPassword;
}

/**
* Getter for the newPassword.
*
* @return string|null newPassword
*/
public function getNewPassword(): ?string
{
    return $this->newPassword;
}

/**
 * Setter for the oldPassword.
 *
 * @param string $newPassword oldPassword
 */
public function setNewPassword(string $newPassword): void
{
    $this->newPassword = $newPassword;
}

}