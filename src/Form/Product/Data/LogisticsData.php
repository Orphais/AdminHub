<?php

namespace App\Form\Product\Data;

use Symfony\Component\Validator\Constraints as Assert;

class LogisticsData
{
    #[Assert\Positive(groups: ['Default', 'logistics'])]
    public ?int $weight = null;

    #[Assert\Positive(groups: ['Default', 'logistics'])]
    public ?int $width = null;

    #[Assert\Positive(groups: ['Default', 'logistics'])]
    public ?int $height = null;

    #[Assert\Positive(groups: ['Default', 'logistics'])]
    public ?int $depth = null;

    #[Assert\Positive(groups: ['Default', 'logistics'])]
    public ?int $stock = null;
}
