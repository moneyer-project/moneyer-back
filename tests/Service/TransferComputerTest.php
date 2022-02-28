<?php

namespace App\Tests\Service;

use App\Entity\Bank\Account;
use App\Entity\Bank\Charge\Expense;
use App\Entity\Bank\Charge\Income;
use App\Entity\Bank\PaymentDistribution;
use App\Enum\Bank\DistributionType;
use App\Service\TransferComputer;
use PHPUnit\Framework\TestCase;

class TransferComputerTest extends TestCase
{
    private TransferComputer $transferComputer;

    protected function setUp(): void
    {
        $this->transferComputer = new TransferComputer();
    }

    public function testBalanceOfMonth(): void
    {
        $account1 = (new Account());
        $account2 = (new Account());

        $income1 = (new Income())
            ->setDate(new \DateTime('2020-01-01'))
            ->setAmount(1000)
        ;

        $income2 = (new Income())
            ->setDate(new \DateTime('2020-01-01'))
            ->setAmount(2000)
        ;

        $expense1 = (new Expense())
            ->setDate(new \DateTime('2020-01-01'))
            ->setAmount(100)
        ;

        $expense2 = (new Expense())
            ->setDate(new \DateTime('2020-01-01'))
            ->setAmount(200)
            ->setDistribution((new PaymentDistribution())
                ->setType(DistributionType::FiftyFifty)
                ->addPayer($account1)
                ->addPayer($account2)
            )
        ;

        $expense3 = (new Expense())
            ->setDate(new \DateTime('2020-01-01'))
            ->setAmount(300)
            ->setDistribution((new PaymentDistribution())
                ->setType(DistributionType::FiftyFifty)
                ->addPayer($account1)
                ->addPayer($account2)
            )
        ;

        $account1
            ->addIncome($income1)
            ->addExpense($expense1)
            ->addExpense($expense2)
            ->addExpense($expense3)
        ;

        $account2
            ->addIncome($income2)
        ;

        $transfers = $this->transferComputer->compute($account1);

        $this->assertCount(1, $transfers);
    }
}
