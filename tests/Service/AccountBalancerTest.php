<?php

namespace App\Tests\Service;

use App\Entity\Bank\Account;
use App\Entity\Bank\Charge\Expense;
use App\Entity\Bank\Charge\Income;
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
            ->addExpense((new Expense())->setDate(new \DateTime('2020-01-03'))->setAmount(300))
            ->addIncome((new Income())->setDate(new \DateTime('2020-01-04'))->setAmount(1000))
            ->addIncome((new Income())->setDate(new \DateTime('2020-02-05'))->setAmount(2000))
            ->addIncome((new Income())->setDate(new \DateTime('2020-01-06'))->setAmount(3000))
        ;

        $this->assertEquals(4000, $this->accountBalancer->getIncomeOfMonth($account, new \DateTime('2020-01-01')));
        $this->assertEquals(400, $this->accountBalancer->getExpanseOfMonth($account, new \DateTime('2020-01-01')));
        $this->assertEquals(3600, $this->accountBalancer->getBalanceOfMonth($account, new \DateTime('2020-01-01')));
    }
}
