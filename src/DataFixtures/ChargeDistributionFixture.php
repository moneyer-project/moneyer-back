<?php

namespace App\DataFixtures;

use App\Entity\Bank\Account;
use App\Entity\Bank\Charge\Expense;
use App\Entity\Bank\Charge\Income;
use App\Entity\Bank\PaymentDistribution;
use App\Entity\User;
use App\Enum\Bank\DistributionType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Yaml\Yaml;

class ChargeDistributionFixture extends Fixture implements DependentFixtureInterface
{
    public function __construct(
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $key => $value) {
            $account = $this->getReference($key);

            if ($account instanceof Account) {

                foreach ($value['expenses'] as $expenseData) {
                    /** @var Expense $expense */
                    $expense = $this->getReference(sprintf('%s%s%s', $key, $expenseData['name'], $expenseData['date']));

                    $distribution = (new PaymentDistribution())
                        ->setType(DistributionType::get($expenseData['distribution']['type']));

                    foreach ($expenseData['distribution']['payers'] as $payerData) {
                        $distribution->addPayer($this->getReference($payerData));
                    }

                    $expense->setDistribution($distribution);
                }
            }

            $manager->persist($account);
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
            AccountFixture::class,
        ];
    }
}
