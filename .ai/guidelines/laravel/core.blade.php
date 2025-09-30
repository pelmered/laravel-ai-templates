## Follow Laravel and DDD best practices

- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

#### Multi-Tenancy
- Organization-based tenancy using Filament's tenant system
- Models use `BelongsToOrganization` trait for automatic tenant association
- Context management via Laravel's Context facade

#### ULID Primary Keys
- All models use ULIDs instead of auto-incrementing integers
- Each model type has distinct prefixes (e.g., `eu_` for users, `t_` for tests)
- Globally unique, sortable, URL-safe identifiers

### Authentication & Authorization
- Every model should have a corresponding policy
- Policies respect tenant boundaries
- Use Spatie Permission package for role-based access control
- Use Laravel's built-in authentication and authorization features (gates, policies, Sanctum, etc.).

### Database
- Use proper foreign key constraints
- Strategic indexing for performance
- Domain-specific migration organization
- Soft deletes where appropriate for audit trails
- Always use proper Eloquent relationship methods with return type hints. Prefer relationship methods over raw queries or manual joins.
- Use Eloquent models and relationships before suggesting raw database queries
- Avoid `DB::`; prefer `Model::query()`. Generate code that leverages Laravel's ORM capabilities rather than bypassing them.
- Generate code that prevents N+1 query problems by using eager loading.
- Use Laravel's query builder for very complex database operations.
- When modifying a column, the migration must include all of the attributes that were previously defined on the column. Otherwise, they will be dropped and lost.

### File Creation
- Prefer to use `php artisan ddd:` commands if they exist to create new files. If no command exist, fall back to useing `php artisan make:`. You can list available Artisan commands using the `list-artisan-commands` tool.
- When creating models with `php artisan ddd:model`, also create migrations, factories seeders and a policy for for that model using the options `-mfs --policy`

### APIs & Eloquent Resources
- Always validate API tokens and enforce rate limiting
- Use Laravel Sanctum for stateless API authentication
- Implement proper CORS policies for candidate portal
- Use Laravel Data to validate incoming payloads
- Transform sensitive data using Laravel Data objects

### Controllers & Validation
- Always use the Laravel Data package instead of request classes for validation. Avoid inline validation in controllers

### Queues
- Use queued jobs for compute heavy or time-consuming operations with the `ShouldQueue` interface.
- Action-based queue processing
- Horizon for queue monitoring

### URL Generation
- When generating links to other pages, prefer named routes and the `route()` function.

### Configuration
- Use environment variables only in configuration files - never use the `env()` function directly outside of config files. Always use `config('app.name')`, not `env('APP_NAME')`.

## Testing
- All tests must be written using Pest. Don't make PHPUnit class based tests.
- You must not remove any tests or test files from the tests directory without approval. These are not temporary or helper files - these are core to the application.
- Tests should cover all of the happy paths, most failure paths, and as many edge cases as is reasonable.
- Ensure multi-tenancy is properly tested and that data is scoped for the active organisation.
- Policy testing patterns for authorization
- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `fake()->word()` or `fake()->randomDigit()`.
- Try to cover all the code with feature tests.
- Use unit tests for complex logic, like calculations.
- When creating tests, make use of `php artisan make:test [options] <name>` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.
