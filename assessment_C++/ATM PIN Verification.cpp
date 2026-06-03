#include <iostream>
#include <ctime>
#include <iomanip>

using namespace std;

class ATM
{
private:
    int pin;
    double balance;

public:
    ATM(); // Constructor

    void welcomeScreen();
    bool login();
    void menu();
    void deposit();
    void withdraw();
    void checkBalance();
};

// Constructor Definition using Scope Resolution Operator
ATM::ATM()
{
    pin = 12345;
    balance = 20000;
}

// Welcome Screen
void ATM::welcomeScreen()
{
    time_t now = time(0);
    char* dt = ctime(&now);

    cout << "\n========================================";
    cout << "\n       WELCOME TO ATM BANKING";
    cout << "\n========================================";
    cout << "\nCurrent Date & Time : " << dt;
}

// PIN Verification
bool ATM::login()
{
    int enteredPin;
    int attempts = 3;

    while (attempts > 0)
    {
        cout << "\nEnter ATM PIN : ";
        cin >> enteredPin;

        if (enteredPin == pin)
        {
            cout << "\nPIN Verified Successfully!\n";
            return true;
        }
        else
        {
            attempts--;
            cout << "Wrong PIN! Attempts Left: "
                 << attempts << endl;
        }
    }

    cout << "\nNo More Attempts Allowed!!";
    cout << "\nThank You...\n";
    return false;
}

// Deposit Function
void ATM::deposit()
{
    double amount;

    cout << "\nCurrent Balance : Rs. " << balance;
    cout << "\nEnter Amount To Deposit : ";
    cin >> amount;

    balance += amount;

    cout << "\nDeposit Successful!";
    cout << "\nNew Balance : Rs. " << balance << endl;
}

// Withdraw Function
void ATM::withdraw()
{
    double amount;

    cout << "\nCurrent Balance : Rs. " << balance;
    cout << "\nEnter Amount To Withdraw : ";
    cin >> amount;

    if (amount <= balance)
    {
        balance -= amount;

        cout << "\nWithdrawal Successful!";
        cout << "\nRemaining Balance : Rs. "
             << balance << endl;
    }
    else
    {
        cout << "\nInsufficient Balance!" << endl;
    }
}

// Balance Inquiry
void ATM::checkBalance()
{
    cout << "\nAvailable Balance : Rs. "
         << balance << endl;
}

// Main Menu
void ATM::menu()
{
    int choice;

    do
    {
        cout << "\n\n================================";
        cout << "\n         ATM MAIN MENU";
        cout << "\n================================";
        cout << "\n1. Deposit Cash";
        cout << "\n2. Withdraw Cash";
        cout << "\n3. Balance Inquiry";
        cout << "\n0. Exit";
        cout << "\n\nEnter Your Choice : ";
        cin >> choice;

        switch (choice)
        {
        case 1:
            deposit();
            break;

        case 2:
            withdraw();
            break;

        case 3:
            checkBalance();
            break;

        case 0:
            cout << "\nThank You For Using ATM.\n";
            break;

        default:
            cout << "\nInvalid Choice!";
        }

    } while (choice != 0);
}

// Main Function
int main()
{
    ATM user;

    user.welcomeScreen();

    if (user.login())
    {
        user.menu();
    }

    return 0;
}
