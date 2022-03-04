<?php

namespace App\Tests\Service;

use App\Entity\Bank\Account;
use App\Entity\Bank\Charge\Expense;
use App\Entity\Bank\PaymentDistribution;
use App\Enum\Bank\DistributionType;
use App\Service\Transfer\Distributor;
use App\Service\Transfer\PotRepartitor;
use App\Service\Transfer\Transfer;
use App\Service\TransferComputer;
use PHPUnit\Framework\TestCase;

class TransferComputerTest extends TestCase
{
    private TransferComputer $transferComputer;

    protected function setUp(): void
    {
        $this->transferComputer = new TransferComputer(new Distributor(), new PotRepartitor());
    }

    public function testBalanceOfMonth(): void
    {
        $date = new \DateTime('2020-01-01');

        $account1 = (new Account())->setName('Account 1');
        $account2 = (new Account())->setName('Account 2');
        $account3 = (new Account())->setName('Account 3');

        $expense10 = (new Expense())
            ->setDate(new \DateTime('2020-01-01'))
            ->setAmount(10)
            ->setDistribution((new PaymentDistribution())
                ->setType(DistributionType::FiftyFifty)
                ->addPayer($account1)
                ->addPayer($account2)
            )
        ;

        $expense12 = (new Expense())
            ->setDate(new \DateTime('2020-01-01'))
            ->setAmount(12)
            ->setDistribution((new PaymentDistribution())
                ->setType(DistributionType::FiftyFifty)
                ->addPayer($account1)
                ->addPayer($account2)
            )
        ;

        $expense20 = (new Expense())
            ->setDate(new \DateTime('2020-01-01'))
            ->setAmount(20)
            ->setDistribution((new PaymentDistribution())
                ->setType(DistributionType::FiftyFifty)
                ->addPayer($account1)
                ->addPayer($account2)
            )
        ;

        $expense40 = (new Expense())
            ->setDate(new \DateTime('2020-01-01'))
            ->setAmount(40)
            ->setDistribution((new PaymentDistribution())
                ->setType(DistributionType::FiftyFifty)
                ->addPayer($account1)
                ->addPayer($account2)
            )
        ;

        $expense800 = (new Expense())
            ->setDate(new \DateTime('2020-01-01'))
            ->setAmount(800)
            ->setDistribution((new PaymentDistribution())
                ->setType(DistributionType::FiftyFifty)
                ->addPayer($account1)
                ->addPayer($account2)
            )
        ;

        $expense200 = (new Expense())
            ->setDate(new \DateTime('2020-01-01'))
            ->setAmount(200)
            ->setDistribution((new PaymentDistribution())
                ->setType(DistributionType::FiftyFifty)
                ->addPayer($account1)
                ->addPayer($account2)
            )
        ;

        $expense100 = (new Expense())
            ->setDate(new \DateTime('2020-01-01'))
            ->setAmount(100)
            ->setDistribution((new PaymentDistribution())
                ->setType(DistributionType::FiftyFifty)
                ->addPayer($account1)
                ->addPayer($account2)
            )
        ;

        $expense30 = (new Expense())
            ->setDate(new \DateTime('2020-01-01'))
            ->setAmount(30)
            ->setDistribution((new PaymentDistribution())
                ->setType(DistributionType::FiftyFifty)
                ->addPayer($account1)
                ->addPayer($account2)
            )
        ;

        $account1
            ->addExpense($expense20)
            ->addExpense($expense40)
        ;

        $account2
            ->addExpense($expense10)
            ->addExpense($expense12)
        ;

        $account3
            ->addExpense($expense800)
            ->addExpense($expense200)
            ->addExpense($expense100)
            ->addExpense($expense30)
        ;

        $transfers = $this->transferComputer->computeForMonth($date, [
            $account1,
            $account2,
            $account3,
        ]);

        $this->assertCount(2, $transfers);

        $transfersAccount1 = $transfers->filter(function (Transfer $transfer) use ($account1) {
            return $transfer->getFrom() === $account1;
        });

        $this->assertCount(1, $transfersAccount1);
        $this->assertEquals(546, $transfersAccount1->first()->getAmount());

        $transfersAccount2 = $transfers->filter(function (Transfer $transfer) use ($account2) {
            return $transfer->getFrom() === $account2;
        });

        $this->assertCount(1, $transfersAccount2);
        $this->assertEquals(584, $transfersAccount2->first()->getAmount());
    }
}
