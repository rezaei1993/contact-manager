# Contact Manager

In this project, the service layer and repository are separated, and tests have been written as well.

## Installation and Setup

1. Clone the Git repository:

    ```bash
    git clone https://github.com/rezaei1993/contact-manager.git
    ```

2. Navigate to the project directory:

    ```bash
    cd contact-manager
    ```

3. Install dependencies using Composer:

    ```bash
    composer install
    ```

4. Generate application key:

    ```bash
    php artisan key:generate
    ```

5. Run migrations and seed the database:

    ```bash
    php artisan migrate --seed
    ```

## Running Tests

To run the tests, execute the following command:

```bash
php artisan test
