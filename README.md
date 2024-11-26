
# Lumen Users API

This project provides an API built with **Lumen** to manage users. It allows you to perform CRUD operations on users, including check existing users by ID.

## Endpoints

### Users

#### 1. Get all users
```http
GET /api/users
```
- Returns a list of all users.

#### 2. Get user by ID
```http
GET /api/users/{id}
```
- Returns a single user by its ID.

#### 3. Create a new user
```http
POST /api/users
```
- Request Body:
```json
{
  "email": "admin@admin.com",
  "name": "admin",
  "password": "adminadmin"
}
```
- Creates a new user with the provided data.

#### 4. Update a user by ID
```http
PUT /api/users/{id}
```
- Request Body:
```json
{
    "email": "admin2@admin.com",
    "name": "admin2",
    "password": "adminadmin2"
}
```
- Updates the user with the provided ID.

#### 5. Delete a user by ID
```http
DELETE /api/users/{id}
```
- Deletes the user with the specified ID.

#### 6. Check user existing by ID
```http
GET /api/users/check/{id}
```
- Returns boolean and message.
