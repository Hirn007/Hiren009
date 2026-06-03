#include <stdio.h>

int main()
{
    int choice, qty;
    float amount, totalBill = 0;
    char more;

    do
    {
        // Display Menu
        printf("\n--------- MENU ---------\n");
        printf("1. Pizza   \tPrice = 180 Rs/Pcs\n");
        printf("2. Burger  \tPrice = 100 Rs/Pcs\n");
        printf("3. Dosa    \tPrice = 120 Rs/Pcs\n");
        printf("4. Idli    \tPrice = 50 Rs/Pcs\n");

        printf("\nPlease Enter Your Choice : ");
        scanf("%d", &choice);

        printf("Enter Quantity : ");
        scanf("%d", &qty);

        // Calculate amount based on choice
        switch(choice)
        {
            case 1:
                amount = 180 * qty;
                printf("\nYou have selected Pizza.\n");
                break;

            case 2:
                amount = 100 * qty;
                printf("\nYou have selected Burger.\n");
                break;

            case 3:
                amount = 120 * qty;
                printf("\nYou have selected Dosa.\n");
                break;

            case 4:
                amount = 50 * qty;
                printf("\nYou have selected Idli.\n");
                break;

            default:
                printf("\nInvalid Choice!\n");
                amount = 0;
        }

        printf("Amount : %.2f\n", amount);

        // Add to total bill
        totalBill += amount;

        printf("Total Amount is = %.2f\n", totalBill);

        printf("\nDo you want to place more orders ? (y/n) : ");
        scanf(" %c", &more);

    } while(more == 'y' || more == 'Y');

    // Final Bill
    printf("\n============================");
    printf("\nFinal Bill = %.2f Rs", totalBill);
    printf("\n============================\n");

    printf("\nThank You! Visit Again.\n");

    return 0;
}
