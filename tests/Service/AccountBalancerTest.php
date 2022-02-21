<?php

namespace App\Tests\Service;

use App\Entity\Bank\Account;
use App\Entity\Bank\Expense;
use App\Entity\Bank\Income;
use App\Service\AccountBalancer;
use PHPUnit\Framework\TestCase;

class AccountBalancerTest extends TestCase
{
    private AccountBalancer $accountBalancer;

    protected function setUp(): void
    {
        $this->accountBalancer = new AccountBalancer();
    }

    public function testBalanceOfMonth(): void
    {
        $account = new Account();

        $account
            ->addExpense((new Expense())->setDate(new \DateTime('2020-01-01'))->setAmount(100))
            ->addExpense((new Expense())->setDate(new \DateTime('2020-02-02'))->setAmount(200))
            ->addIncome((new Income())->setDate(new \DateTime('2020-01-03'))->setAmount(2000))
        ;

        $this->assertEquals(2000, $this->accountBalancer->getIncomeOfMonth($account, new \DateTime('2020-01-01')));
        $this->assertEquals(100, $this->accountBalancer->getExpanseOfMonth($account, new \DateTime('2020-01-01')));
        $this->assertEquals(1900, $this->accountBalancer->getBalanceOfMonth($account, new \DateTime('2020-01-01')));
    }
}
