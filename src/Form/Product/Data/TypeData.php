<?php

namespace App\Form\Product\Data;

use Symfony\Component\Validator\Constraints as Assert;

class TypeData
{
    #[Assert\NotBlank(groups: ['Default', 'type'])]
    public ?string $type = null;
}
