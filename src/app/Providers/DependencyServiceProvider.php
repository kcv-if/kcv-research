<?php

namespace App\Providers;

use App\Slices\Tag\Domain\IGetAllTagQuery;
use App\Slices\Tag\Repository\MySql\MySqlGetAllTagQuery;
use App\Slices\Tag\UseCase\GetAllTagUseCase;
use App\Slices\Tag\UseCase\IGetAllTagUseCase;
use Illuminate\Support\ServiceProvider;

class DependencyServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Repository

        $this->app->bind(IGetAllTagQuery::class, MySqlGetAllTagQuery::class);

        // Use Case

        $this->app->bind(IGetAllTagUseCase::class, GetAllTagUseCase::class);
    }
}
