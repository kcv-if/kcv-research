<?php

namespace App\Providers;

use App\Slices\Tag\Domain\IGetAllTagQuery;
use App\Slices\Tag\Domain\IStoreTagCommand;
use App\Slices\Tag\Repository\MySql\MySqlGetAllTagQuery;
use App\Slices\Tag\Repository\MySql\MySqlStoreTagCommand;
use App\Slices\Tag\UseCase\GetAllTagUseCase;
use App\Slices\Tag\UseCase\IGetAllTagUseCase;
use App\Slices\Tag\UseCase\IStoreTagUseCase;
use App\Slices\Tag\UseCase\StoreTagUseCase;
use Illuminate\Support\ServiceProvider;

class DependencyServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Repository

        $this->app->bind(IGetAllTagQuery::class, MySqlGetAllTagQuery::class);
        $this->app->bind(IStoreTagCommand::class, MySqlStoreTagCommand::class);

        // Use Case

        $this->app->bind(IGetAllTagUseCase::class, GetAllTagUseCase::class);
        $this->app->bind(IStoreTagUseCase::class, StoreTagUseCase::class);
    }
}
