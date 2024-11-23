# Laravel Public Surveys API

This is the **backend** repository for the Survey Application, built using **Laravel 11**. It provides the necessary APIs for managing surveys, authentication, and dashboard insights.

## ✨ Features

- **Authentication**: Login and Register using **Sanctum** for API authentication.
- **Survey Management**: CRUD operations for surveys.
- **Public Surveys**: Collect responses from the general public for public surveys.
- **Dashboard**: Insights and analytics for surveys.
- **Pagination**: Implemented pagination for survey lists and answers.
- **Clean Code**: Follows clean code principles for maintainability and scalability.
- **Enums**: Utilizes Enums for better code readability and structure.
- **Validation**: Separate request classes for validation of API requests.
- **Resources**: Uses **Laravel Resources** to send clean and consistent JSON responses.

## 🛠 Tech Stack

- **Laravel 11**: The latest stable version of Laravel.
- **Sanctum**: For secure API authentication using tokens.
- **Enums**: For cleaner, more manageable constants.
- **Laravel Resources**: For API response formatting and consistency.
- **Pagination**: To handle large datasets efficiently.

## 🖥 Installation and Setup

### Prerequisites
Ensure you have the following installed:
- PHP (v8.1+)
- Composer (v2+)
- MySQL or any other database

### Steps
1. Clone the repository:
   ```bash
   git clone https://github.com/Asad9299/laravel-public-surveys-api.git
   cd laravel-public-surveys-api

2. Install dependencies:
   ```bash
   composer install

3. Set up the environment file:
   ```bash
   cp .env.example .env

4. Generate the application key:
   ```bash
   php artisan key:generate

5. Set up the database:

   Configure your database connection in .env

   Run the migrations:
   ```bash
   php artisan migrate

6. Seed the database:
   ```bash
   php artisan db:seed

## Contributing

If you'd like to contribute to this project, please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/YourFeature`).
3. Make your changes and commit them (`git commit -am 'Add some feature'`).
4. Push to the branch (`git push origin feature/YourFeature`).
5. Create a new Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

 Happy coding! 🚀,

 Asad Mansuri
