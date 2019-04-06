<?php

namespace Spatie\EventProjector\Tests\TestClasses\AggregateRoots;

use Spatie\EventProjector\AggregateRoot;
use Spatie\EventProjector\AggregateRoots\AggregateRootBehaviour;
use Spatie\EventProjector\Tests\TestClasses\AggregateRoots\DomainEvents\MoneyAdded;
use Spatie\EventProjector\Tests\TestClasses\AggregateRoots\Projectors\AccountProjector;
use Spatie\EventProjector\Tests\TestClasses\AggregateRoots\Reactors\SendMailReactor;

final class AccountAggregateRoot extends AggregateRoot
{
    protected $projectors = [
        AccountProjector::class,
    ];

    protected $reactors = [
        SendMailReactor::class,
    ];

    public $balance = 0;

    public function addMoney(int $amount): self
    {
        $this->recordThat(new MoneyAdded($amount));

        return $this;
    }

    public function applyMoneyAdded(MoneyAdded $event)
    {
        $this->balance += $event->amount;
    }
}