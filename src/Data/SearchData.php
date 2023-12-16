<?php

declare(strict_types=1);

namespace App\Form;

class SearchData
{
    public int $page = 1;

    public array $pays = [];

    public array $region = [];
    public array $typeRecette = [];
}