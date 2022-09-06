<?php

namespace App\Providers;

use App\Slices\Tag\Domain\IDeleteTagCommand;
use App\Slices\Tag\Domain\IGetAllTagQuery;
use App\Slices\Tag\Domain\IGetByUuidTagQuery;
use App\Slices\Tag\Domain\IStoreTagCommand;
use App\Slices\Tag\Domain\IUpdateTagCommand;
use App\Slices\Tag\Repository\MySql\MySqlDeleteTagCommand;
use App\Slices\Tag\Repository\MySql\MySqlGetAllTagQuery;
use App\Slices\Tag\Repository\MySql\MySqlGetByUuidTagQuery;
use App\Slices\Tag\Repository\MySql\MySqlStoreTagCommand;
use App\Slices\Tag\Repository\MySql\MySqlUpdateTagCommand;
use App\Slices\Tag\UseCase\DeleteTagUseCase;
use App\Slices\Tag\UseCase\GetAllTagUseCase;
use App\Slices\Tag\UseCase\GetByUuidTagUseCase;
use App\Slices\Tag\UseCase\IDeleteTagUseCase;
use App\Slices\Tag\UseCase\IGetAllTagUseCase;
use App\Slices\Tag\UseCase\IGetByUuidTagUseCase;
use App\Slices\Tag\UseCase\IStoreTagUseCase;
use App\Slices\Tag\UseCase\IUpdateTagUseCase;
use App\Slices\Tag\UseCase\StoreTagUseCase;
use App\Slices\Tag\UseCase\UpdateTagUseCase;
use App\Slices\User\Domain\IGetAllUserQuery;
use App\Slices\User\Domain\IStoreUserCommand;
use App\Slices\User\Repository\MySql\MySqlGetAllUserQuery;
use App\Slices\User\Repository\MySql\MySqlStoreUserCommand;
use App\Slices\User\UseCase\GetAllUserUseCase;
use App\Slices\User\UseCase\IGetAllUserUseCase;
use App\Slices\User\UseCase\IStoreUserUseCase;
use App\Slices\User\UseCase\StoreUserUseCase;
use Illuminate\Support\ServiceProvider;

class DependencyServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Repository

        $this->app->bind(IGetAllTagQuery::class, MySqlGetAllTagQuery::class);
        $this->app->bind(IStoreTagCommand::class, MySqlStoreTagCommand::class);
        $this->app->bind(IGetByUuidTagQuery::class, MySqlGetByUuidTagQuery::class);
        $this->app->bind(IDeleteTagCommand::class, MySqlDeleteTagCommand::class);
        $this->app->bind(IUpdateTagCommand::class, MySqlUpdateTagCommand::class);
        $this->app->bind(IGetAllUserQuery::class, MySqlGetAllUserQuery::class);
        $this->app->bind(IStoreUserCommand::class, MySqlStoreUserCommand::class);

        // Use Case

        $this->app->bind(IGetAllTagUseCase::class, GetAllTagUseCase::class);
        $this->app->bind(IStoreTagUseCase::class, StoreTagUseCase::class);
        $this->app->bind(IGetByUuidTagUseCase::class, GetByUuidTagUseCase::class);
        $this->app->bind(IDeleteTagUseCase::class, DeleteTagUseCase::class);
        $this->app->bind(IUpdateTagUseCase::class, UpdateTagUseCase::class);
        $this->app->bind(IGetAllUserUseCase::class, GetAllUserUseCase::class);
        $this->app->bind(IStoreUserUseCase::class, StoreUserUseCase::class);
    }
}
