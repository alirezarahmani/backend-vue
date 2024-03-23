Sample User Balance App:
=
Overview:
===
The User Balance Transaction App is a system designed to manage user transactions and account balances in a scalable and efficient manner. It utilizes a layered architecture combined with an event-driven approach to ensure modularity, flexibility, and maintainability.

Features:
===
- Event-Driven Architecture: Utilize events to trigger and handle asynchronous processes, ensuring scalability and responsiveness.
- Layered Architecture: Implement a structured architecture with distinct layers for separation of concerns and ease of maintenance.
- Value Object: Value objects are a programming concept that can be used to improve the design and quality of your code. They are small, immutable objects that represent a single value or concept. Value objects are often used in domain-driven design (DDD) to model the domain of the application.
- cached layer: use redis as cache layer.

Technologies Used:
===
- Programming Language: PHP 8.2
- Framework: No framework
- Database: Mysql, Redis
- Docker for database

Getting Started:
===
- first run start.sh
- database is on docker: 0.0.0.0 root root 3307
- run file `Query.sql` on your db
- make sure redis is running on your system

Commands:
===
 - populate Database, add 1 to 100 random users and transactions: `php console app:populate-users`
 - add single transaction to a user, 1200 euro to specific user id: `php console app:add-transaction 25760151-0ba3-4b86-b358-eeff7da832e3 1200`
 - get sum of transactions for a user on a date: `php console app:user-transactions 25760151-0ba3-4b86-b358-eeff7da832e3 2023-03-24`
 - get sum of transactions for all users on a date: `php console app:all-transactions 2023-03-24`