# Considerations

## Design Patterns

To ensure a proper separation of concerns, I have implemented a few design patterns:

- **Repository**: Responsible for abstracting the data layer, providing a clean interface for querying and persisting data.
- **Factory**: Implements the Factory design pattern to encapsulate the instantiation logic of complex domain objects.

Potential patterns to consider:

- **Observer**: Useful for logging or triggering events based on entity actions (e.g., when an entity is created or updated).
- **Decorator**: Could be applied for task-related logic, especially when combining it with Redis to manage caching more efficiently.

This separation allows controllers to focus solely on delegating work to services, keeping them lightweight and focused.

---

## Exception Handling

Within `App/Exceptions/Handler`, I added custom exceptions based on specific error types. This improves error clarity and helps standardize how we handle failures across the application.

More custom exceptions could be added, but due to time and scope constraints, I implemented only the most relevant ones for this assessment.

---

## API Documentation

For API documentation, I would typically use **OpenAPI (Swagger)** to define and visualize endpoints, parameters, and responses. However, given the limited scope and time, I included a `postman/` folder at the project root with a ready-to-use Postman collection for testing the API and inspecting responses.

---

## Enums

To avoid issues caused by **typos**, I created an `enums/` folder under `app/`, where all enumerated types are registered. This reduces the use of hardcoded strings, enforces consistency, and prevents subtle bugs caused by incorrect values.

---

## Testing

I usually follow a **Test-Driven Development (TDD)** approach to ensure that edge cases are covered and the code remains clean and maintainable. Tests often guide future refactors.

The two types of tests I included are:

- **Unit Tests**: To validate individual methods and isolated logic.
- **Feature Tests**: To verify full user flows, such as creating a task.

I didn’t cover every possible case to keep the assessment concise, but I included a mix of successful and failing scenarios. Ideally, we would cover both for every feature.

---

## API Performance

To improve performance under the assumption of large data volumes:

- I added **indexes** to commonly searched fields.
- Implemented **pagination** to reduce payload size and DB load.
- Suggested possible use of **caching** (e.g., Redis) or **rate limiting** in high-traffic scenarios.

On the frontend, using **debounce** when typing prevents excessive requests per keystroke, further optimizing performance.

---

## Query Scopes

I utilized **Laravel scopes** in the `Task` model to handle filtering logic. This helps separate responsibilities and keeps the query code clean and readable.

```php
return $this->model->with(self::RELATIONS)
    ->category($filters['category_id'] ?? null)
    ->priority($filters['priority'] ?? null)
    ->isCompleted($filters['is_completed'] ?? null)
    ->paginate($perPage);
```
