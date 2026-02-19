<?php

namespace App\Form\Product\Data;

use Symfony\Component\Validator\Constraints as Assert;

class DetailsData
{
    #[Assert\NotBlank(groups: ['Default', 'details'])]
    public ?string $name = null;

    #[Assert\NotBlank(groups: ['Default', 'details'])]
    public ?string $description = null;

    #[Assert\NotBlank(groups: ['Default', 'details'])]
    #[Assert\Positive(groups: ['Default', 'details'])]
    public ?float $price = null;
}
