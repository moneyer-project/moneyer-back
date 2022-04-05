<?php

namespace App\DataFixtures;

use App\Entity\Bank\Account;
use App\Entity\Bank\Charge;
use App\Entity\Bank\Charge\Expense;
use App\Entity\Bank\Charge\Income;
use App\Entity\Bank\ChargeGroup\IncomeGroup;
use App\Entity\Bank\ChargeGroup\ExpenseGroup;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Yaml\Yaml;

class AccountFixture extends Fixture implements DependentFixtureInterface
{
    public function __construct(
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $key => $value) {
            $account = isset($value['user']) && $this->getReference($value['user']) instanceof User
                ? $this->getReference($value['user'])->getAccount()
                : new Account();

            $account
                ->setName($value['name']);

            if (isset($value['incomes'])) {
                foreach ($value['incomes'] as $incomeData) {
                    $income = (new Income())
                        ->setName($incomeData['name'])
                        ->setAmount($incomeData['amount'])
                        ->setDate($this->getDate($incomeData['date']));

                    $account->addIncome($income);

                    if (isset($incomeData['group'])) {
                        $this->manageGroup($key, $account, $income, $incomeData);
                    }

                    $this->addReference(sprintf('%s%s%s', $key, $incomeData['name'], $incomeData['date']), $income);
                }
            }

            if (isset($value['expenses'])) {
                foreach ($value['expenses'] as $expenseData) {
                    $expense = (new Expense())
                        ->setName($expenseData['name'])
                        ->setAmount($expenseData['amount'])
                        ->setDate($this->getDate($expenseData['date']));

                    $account->addExpense($expense);

                    if (isset($expenseData['group'])) {
                        $this->manageGroup($key, $account, $expense, $expenseData);
                    }

                    $this->addReference(sprintf('%s%s%s', $key, $expenseData['name'], $expenseData['date']), $expense);
                }
            }

            $manager->persist($account);

            $this->addReference($key, $account);
        }

        $manager->flush();
    }

    private function manageGroup(string $key, Account $account, Charge $charge, array $data): void
    {
        if ($this->hasReference($key . $data['group'])) {
            $group = $this->getReference($key . $data['group']);
        } else {
            $group = match(true) {
                $charge instanceof Income => new IncomeGroup(),
                $charge instanceof Expense => new ExpenseGroup(),
            };

            $group
                ->setAmount($data['amount'])
                ->setName($data['group']);

            $account->addChargeGroup($group);

            $this->addReference($key . $data['group'], $group);
        }

        $group?->addCharge($charge);
    }

    protected function getData()
    {
        return Yaml::parseFile(__DIR__ . '/../../assets/fixtures/accounts.yaml');
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
        ];
    }

    private function getDate($date)
    {
        $date = str_replace('Y', date('Y'), $date);
        $date = str_replace('M', date('m'), $date);
        $date = str_replace('D', date('d'), $date);

        $modify = null;
        if (str_contains($date, '::')) {
            $modify = substr($date, strpos($date, '::') + 2);
            $date = substr($date, 0, strpos($date, '::'));
        }

        $date = \DateTime::createFromFormat('Y-m-d', $date);
        $date->setTime(0, 0, 0);

        if (null !== $modify) {
            $date->modify($modify);
        }

        return $date;
    }
}
