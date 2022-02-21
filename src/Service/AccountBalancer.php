<?php

namespace App\Service;

use App\Entity\Bank\Account;

class AccountBalancer
{
    public function getIncomeOfMonth(Account $account, \DateTime $date): int
    {
        $total = 0;

        foreach ($account->getIncomes() as $income) {
            if ($income->getDate()->format('YYYY-MM') === $date->format('YYYY-MM')) {
                $total += $income->getAmount();
            }
        }

        return $total;
    }

    public function getExpanseOfMonth(Account $account, \DateTime $date): int
    {
        $total = 0;

        foreach ($account->getExpenses() as $expense) {
            if ($expense->getDate()->format('YYYY-MM') === $date->format('YYYY-MM')) {
                $total += $expense->getAmount();
            }
        }

        return $total;
    }

    public function getBalanceOfMonth(Account $account, \DateTime $date): int
    {
        $balance = 0;

        $balance += $this->getIncomeOfMonth($account, $date);
        $balance -= $this->getExpanseOfMonth($account, $date);

        return $balance;
    }
}
