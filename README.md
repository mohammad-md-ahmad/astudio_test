# API Documentation and Setup Guide

## Setup Instructions

1. Clone the repository:
   ```bash
   git clone <repository-url>
   ```

2. Install dependencies:
   - install kool.dev tool to manage the docker containers
        ```bash 
        curl -fsSL https://kool.dev/install | bash
        ```

3. Set up environment variables:
   - Inside the `.env.example` file in the root directory
   - Modify the following variables if necessary to set custom ports for the app and db containers:
     ```
     KOOL_APP_PORT
     KOOL_DATABASE_PORT
     ```
   - Modify the following variables if necessary to set db connection configs and credentials:
     ```
     DB_DATABASE
     DB_USERNAME
     DB_PASSWORD
     ```

4. Start the setup:
   ```bash
   kool run setup
   ```

5. Start the server:
   ```bash
   kool start
   ```

6. Create a Laravel Passport client:
   ```bash
   kool run artisan passport:client --personal
   ```

## API Documentation

### Base URL
```
http://localhost/api
```

### Authentication

The API uses Laravel Passport for authentication. All endpoints except login and register require authentication using Bearer token.

#### Authentication Endpoints

##### Register
- **Method:** POST
- **Endpoint:** `/register`
- **Description:** Register a new user
- **Authentication:** Not required

##### Login
- **Method:** POST
- **Endpoint:** `/login`
- **Description:** Login to get access token
- **Authentication:** Not required

##### Logout
- **Method:** POST
- **Endpoint:** `/logout`
- **Description:** Invalidate the current access token
- **Authentication:** Required

### Resource Endpoints

All the following endpoints require authentication with Bearer token.

#### Users

##### Get All Users
- **Method:** GET
- **Endpoint:** `/users`
- **Description:** Retrieve all users
- **Authentication:** Required

##### Get Single User
- **Method:** GET
- **Endpoint:** `/users/{user}`
- **Description:** Retrieve a specific user
- **Authentication:** Required

##### Create User
- **Method:** POST
- **Endpoint:** `/users`
- **Description:** Create a new user
- **Authentication:** Required

##### Update User
- **Method:** PUT
- **Endpoint:** `/users/{user}`
- **Description:** Update an existing user
- **Authentication:** Required

##### Delete User
- **Method:** DELETE
- **Endpoint:** `/users/{user}`
- **Description:** Delete a user
- **Authentication:** Required

#### Projects

##### Get All Projects
- **Method:** GET
- **Endpoint:** `/projects`
- **Description:** Retrieve all projects
- **Authentication:** Required

##### Get Single Project
- **Method:** GET
- **Endpoint:** `/projects/{project}`
- **Description:** Retrieve a specific project
- **Authentication:** Required

##### Create Project
- **Method:** POST
- **Endpoint:** `/projects`
- **Description:** Create a new project
- **Authentication:** Required

##### Update Project
- **Method:** PUT
- **Endpoint:** `/projects/{project}`
- **Description:** Update an existing project
- **Authentication:** Required

##### Delete Project
- **Method:** DELETE
- **Endpoint:** `/projects/{project}`
- **Description:** Delete a project
- **Authentication:** Required

#### Project Users

##### Get Project Users
- **Method:** GET
- **Endpoint:** `/projects/{project}/users`
- **Description:** Get users associated with a specific project
- **Authentication:** Required

##### Get All Project Users
- **Method:** GET
- **Endpoint:** `/projects/users`
- **Description:** Get all project-user associations
- **Authentication:** Required

##### Add User to Project
- **Method:** POST
- **Endpoint:** `/projects/{project}/users`
- **Description:** Associate a user with a project
- **Authentication:** Required

##### Remove User from Project
- **Method:** DELETE
- **Endpoint:** `/projects/{project}/users`
- **Description:** Remove a user from a project
- **Authentication:** Required

#### Timesheets

##### Get All Timesheets
- **Method:** GET
- **Endpoint:** `/timesheets`
- **Description:** Retrieve all timesheets
- **Authentication:** Required

##### Get Single Timesheet
- **Method:** GET
- **Endpoint:** `/timesheets/{timesheet}`
- **Description:** Retrieve a specific timesheet
- **Authentication:** Required

##### Create Timesheet
- **Method:** POST
- **Endpoint:** `/timesheets`
- **Description:** Create a new timesheet
- **Authentication:** Required

##### Update Timesheet
- **Method:** PUT
- **Endpoint:** `/timesheets/{timesheet}`
- **Description:** Update an existing timesheet
- **Authentication:** Required

##### Delete Timesheet
- **Method:** DELETE
- **Endpoint:** `/timesheets/{timesheet}`
- **Description:** Delete a timesheet
- **Authentication:** Required

#### Attributes

##### Get All Attributes
- **Method:** GET
- **Endpoint:** `/attributes`
- **Description:** Retrieve all attributes
- **Authentication:** Required

##### Get Single Attribute
- **Method:** GET
- **Endpoint:** `/attributes/{attribute}`
- **Description:** Retrieve a specific attribute
- **Authentication:** Required

##### Create Attribute
- **Method:** POST
- **Endpoint:** `/attributes`
- **Description:** Create a new attribute
- **Authentication:** Required

##### Update Attribute
- **Method:** PUT
- **Endpoint:** `/attributes/{attribute}`
- **Description:** Update an existing attribute
- **Authentication:** Required

##### Delete Attribute
- **Method:** DELETE
- **Endpoint:** `/attributes/{attribute}`
- **Description:** Delete an attribute
- **Authentication:** Required

## Example Requests/Responses

### Authentication

#### Login

**Request:**
```bash
curl -X POST \
  'http://localhost/api/login' \
  -H 'Content-Type: application/json' \
  -d '{
    "email": "mohammad@astudio.com",
    "password": "P@$$w0rdrand"
  }'
```

**Response:**
```json
{
  "message": "User has been logged in successfully!",
  "data": {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...",
    "user": {
      "id": 1,
      "first_name": "Mohammad",
      "last_name": "Ahmad",
      "email": "mohammad@astudio.com",
      "created_at": "2025-03-16T18:15:54.000000Z",
      "updated_at": "2025-03-16T18:17:48.000000Z",
      "tokens": [
        {
          "id": "1c22f0ea0e336c7d87d0064cbedf3546f7eaf29e42ea4160aa98cdb9f957b709db4cd679a49eb82b",
          "user_id": 1,
          "client_id": 1,
          "name": "apiAccessToken",
          "scopes": [],
          "revoked": true,
          "created_at": "2025-03-16T18:32:10.000000Z",
          "updated_at": "2025-03-16T19:07:04.000000Z",
          "expires_at": "2026-03-16T18:32:10.000000Z"
        }
      ]
    }
  }
}
```

### Create Project

**Request:**
```bash
curl -X POST \
  'http://localhost/api/projects' \
  -H 'Authorization: Bearer YOUR_ACCESS_TOKEN' \
  -H 'Content-Type: application/json' \
  -d '{
    "name": "project 4",
    "status": "Active"
  }'
```

**Response:**
```json
{
  "message": "Project has been created successfully!",
  "data": {
    "name": "project 4",
    "status": "Active",
    "updated_at": "2025-03-16T19:09:03.000000Z",
    "created_at": "2025-03-16T19:09:03.000000Z",
    "id": 6
  }
}
```

## Test Credentials

Use the following test credentials for development and testing purposes:

```
Test User: mohammad@astudio.com
Password: P@$$w0rdrand
```

**Note:** These credentials are for testing purposes only. In production, use secure credentials and never share API keys publicly.
