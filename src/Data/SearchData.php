<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\User;

class SearchData
{
    public int $page = 1;

    public array $pays = [];

    public array $region = [];
    public array $typeRecette = [];
    public bool $allergene = false;
    public ?User $user = null ;

}
