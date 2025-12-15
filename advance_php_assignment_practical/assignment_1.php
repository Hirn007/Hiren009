<?php
class BankAccount {
    private $balance;

    public $accountHolder;

    public function __construct($accountHolder, $initialBalance) {
        $this->accountHolder = $accountHolder;
        $this->balance = $initialBalance;
    }

    public function deposit($amount) {
        if ($amount > 0) {
            $this->balance += $amount;
            echo "Deposited $$amount. New balance: $$this->balance\n";
        } else {
            echo "Deposit amount must be positive.\n";
        }
    }

    public function withdraw($amount) {
        if ($amount > 0 && $amount <= $this->balance) {
            $this->balance -= $amount;
            echo "Withdrew $$amount. New balance: $$this->balance\n";
        } else {
            echo "Insufficient balance or invalid amount.\n";
        }
    }

    public function getBalance() {
        return $this->balance;
    }
}

$account = new BankAccount("Alice", 1000);

echo "Account Holder: " . $account->accountHolder . "\n";

$account->deposit(500);
$account->withdraw(200);
echo "Current Balance: $" . $account->getBalance() . "\n";
?>
