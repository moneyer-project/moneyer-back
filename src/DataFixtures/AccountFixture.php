<?php

namespace App\DataFixtures;

use App\Entity\Bank\Account;
use App\Entity\Bank\Charge\Expense;
use App\Entity\Bank\Charge\Income;
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
            $user = $this->getReference($value['user']);

            if ($user instanceof User && null !== $user->getAccount()) {
                $user->getAccount()
                    ->setName($value['name']);

                foreach ($value['incomes'] as $incomeData) {
                    $income = (new Income())
                        ->setName($incomeData['name'])
                        ->setAmount($incomeData['amount'])
                        ->setDate($this->getDate($incomeData['date']));

                    $user->getAccount()->addIncome($income);

                    $this->addReference(sprintf('%s%s%s', $value['user'], $incomeData['name'], $incomeData['date']), $income);
                }

                foreach ($value['expenses'] as $expenseData) {
                    $expense = (new Expense())
                        ->setName($expenseData['name'])
                        ->setAmount($expenseData['amount'])
                        ->setDate($this->getDate($expenseData['date']));

                    $user->getAccount()->addExpense($expense);

                    $this->addReference(sprintf('%s%s%s', $value['user'], $expenseData['name'], $expenseData['date']), $expense);
                }
            }

            $manager->persist($user->getAccount());

            $this->addReference($key, $user->getAccount());
        }

        $manager->flush();
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
