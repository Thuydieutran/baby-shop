<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @var string
 */

class OrderContact
{
    /**
     * @var string
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas valide."
     * )
     * @Assert\NotBlank(message="Veuillez remplir ce champ s'il vous plait.")
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez remplir ce champ s'il vous plait.")
     */
    private $message; 

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}