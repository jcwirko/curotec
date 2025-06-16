# Assessment Guide

## Table of Contents

- [Assessment Guide](#assessment-guide)
  - [Table of Contents](#table-of-contents)
  - [Introduction](#introduction)
  - [Project Structure](#project-structure)
  - [Folder and File Descriptions](#folder-and-file-descriptions)
    - [1. `app/`](#1-app)
  - [Business Logic Modules](#business-logic-modules)
  - [Docker Configuration](#docker-configuration)
  - [Other Folders](#other-folders)
  - [Testing](#testing)

---

## Introduction

This document outlines the structure of our **Assessment Project**, built with Laravel 10, Vue, and Inertia.js.  
The design prioritizes modularity, scalability, and maintainability.

I won’t go into detail about Laravel’s default folder structure, as it's well known. Instead, I’ll focus on the custom parts of the implementation.

---

## Project Structure

```
project-root/
├── app/
│   ├── enums/
│   ├── exceptions/
│   ├── factories/
│   ├── http/
│   ├── repositories/
├── docker/
│   ├── nginx/
│   ├── php/
├── docs/
├── postman/
├── tests/
│   ├── Feature/
│   └── Unit/
```

---
## Folder and File Descriptions

### 1. `app/`

This folder contains the core business logic and application-specific components. It is structured to promote separation of concerns and maintainability.

---

## Business Logic Modules

Each subfolder inside `app/` represents a specific layer or concern within the business logic. These include:

- **`enums/`**: Defines enumerated types used across the application for enforcing consistent and restricted values.
- **`exceptions/`**: Contains custom exception classes used to handle domain-specific error scenarios in a clean and descriptive manner.
- **`factories/`**: encapsulate the creation logic of objects, 
- **`repositories/`**: Encapsulates data access logic, serving as an abstraction layer between the database and the rest of the application.

---

## Docker Configuration

Each folder inside `docker/` contains configuration files for setting up the development environment using Docker. These include:

- **`nginx/`**: Holds configuration files for the NGINX web server used as a reverse proxy and static file server.
- **`php/`**: Contains Docker-specific setup for the PHP environment, including extensions and runtime configuration.

---

## Other Folders

- **`docs/`**: Contains internal documentation related to architecture, processes, and any relevant project specifications.
- **`postman/`**: Includes Postman collections and environment files for testing and documenting API endpoints.

---

## Testing

The `tests/` directory contains the automated test suite for the application, structured as follows:

- **`Feature/`**: Contains high-level tests that verify the behavior of application features from the user's perspective (e.g., routes, controllers).
- **`Unit/`**: Contains low-level tests that focus on individual classes or functions in isolation, ensuring correctness of core logic.
