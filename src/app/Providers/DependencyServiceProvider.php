<?php

namespace App\Providers;

use App\Slices\Publication\Domain\IGetAllPublicationAuthorQuery;
use App\Slices\Publication\Domain\IGetAllPublicationQuery;
use App\Slices\Publication\Domain\IGetAllPublicationTagQuery;
use App\Slices\Publication\Domain\IGetByUuidPublicationQuery;
use App\Slices\Publication\Domain\IStorePublicationCommand;
use App\Slices\Publication\Repository\MySql\MySqlGetAllPublicationAuthorQuery;
use App\Slices\Publication\Repository\MySql\MySqlGetAllPublicationQuery;
use App\Slices\Publication\Repository\MySql\MySqlGetAllPublicationTagQuery;
use App\Slices\Publication\Repository\MySql\MySqlGetByUuidPublicationQuery;
use App\Slices\Publication\Repository\MySql\MySqlStorePublicationCommand;
use App\Slices\Publication\UseCase\GetAllPublicationUseCase;
use App\Slices\Publication\UseCase\GetByUuidPublicationUseCase;
use App\Slices\Publication\UseCase\IGetAllPublicationUseCase;
use App\Slices\Publication\UseCase\IGetByUuidPublicationUseCase;
use App\Slices\Publication\UseCase\IStorePublicationUseCase;
use App\Slices\Publication\UseCase\StorePublicationUseCase;
use App\Slices\PublicationReview\Domain\IGetAllPublicationReviewQuery;
use App\Slices\PublicationReview\Repository\MySql\MySqlGetAllPublicationReviewQuery;
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
use App\Slices\User\Domain\IDeleteUserCommand;
use App\Slices\User\Domain\IGetAllUserQuery;
use App\Slices\User\Domain\IGetByUuidUserQuery;
use App\Slices\User\Domain\IStoreUserCommand;
use App\Slices\User\Domain\IUpdateUserCommand;
use App\Slices\User\Repository\MySql\MySqlDeleteUserCommand;
use App\Slices\User\Repository\MySql\MySqlGetAllUserQuery;
use App\Slices\User\Repository\MySql\MySqlGetByUuidUserQuery;
use App\Slices\User\Repository\MySql\MySqlStoreUserCommand;
use App\Slices\User\Repository\MySql\MySqlUpdateUserCommand;
use App\Slices\User\UseCase\DeleteUserUseCase;
use App\Slices\User\UseCase\GetAllUserUseCase;
use App\Slices\User\UseCase\GetByUuidUserUseCase;
use App\Slices\User\UseCase\IDeleteUserUseCase;
use App\Slices\User\UseCase\IGetAllUserUseCase;
use App\Slices\User\UseCase\IGetByUuidUserUseCase;
use App\Slices\User\UseCase\IStoreUserUseCase;
use App\Slices\User\UseCase\IUpdateUserUseCase;
use App\Slices\User\UseCase\StoreUserUseCase;
use App\Slices\User\UseCase\UpdateUserUseCase;
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
        $this->app->bind(IGetByUuidUserQuery::class, MySqlGetByUuidUserQuery::class);
        $this->app->bind(IUpdateUserCommand::class, MySqlUpdateUserCommand::class);
        $this->app->bind(IDeleteUserCommand::class, MySqlDeleteUserCommand::class);
        $this->app->bind(IGetAllPublicationQuery::class, MySqlGetAllPublicationQuery::class);
        $this->app->bind(IStorePublicationCommand::class, MySqlStorePublicationCommand::class);
        $this->app->bind(IGetByUuidPublicationQuery::class, MySqlGetByUuidPublicationQuery::class);
        $this->app->bind(IGetAllPublicationAuthorQuery::class, MySqlGetAllPublicationAuthorQuery::class);
        $this->app->bind(IGetAllPublicationReviewQuery::class, MySqlGetAllPublicationReviewQuery::class);
        $this->app->bind(IGetAllPublicationTagQuery::class, MySqlGetAllPublicationTagQuery::class);

        // Use Case

        $this->app->bind(IGetAllTagUseCase::class, GetAllTagUseCase::class);
        $this->app->bind(IStoreTagUseCase::class, StoreTagUseCase::class);
        $this->app->bind(IGetByUuidTagUseCase::class, GetByUuidTagUseCase::class);
        $this->app->bind(IDeleteTagUseCase::class, DeleteTagUseCase::class);
        $this->app->bind(IUpdateTagUseCase::class, UpdateTagUseCase::class);
        $this->app->bind(IGetAllUserUseCase::class, GetAllUserUseCase::class);
        $this->app->bind(IStoreUserUseCase::class, StoreUserUseCase::class);
        $this->app->bind(IGetByUuidUserUseCase::class, GetByUuidUserUseCase::class);
        $this->app->bind(IUpdateUserUseCase::class, UpdateUserUseCase::class);
        $this->app->bind(IDeleteUserUseCase::class, DeleteUserUseCase::class);
        $this->app->bind(IGetAllPublicationUseCase::class, GetAllPublicationUseCase::class);
        $this->app->bind(IStorePublicationUseCase::class, StorePublicationUseCase::class);
        $this->app->bind(IGetByUuidPublicationUseCase::class, GetByUuidPublicationUseCase::class);
    }
}
