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
*     message = "Wrong value for your current password"
* )
*/
protected $oldPassword;

/**
* @Assert\Length(
*     min = 6,
*     minMessage = "Password should be at least 6 chars long"
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