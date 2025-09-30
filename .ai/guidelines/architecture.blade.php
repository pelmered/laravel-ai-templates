
## Architecture Overview

This is a Laravel 12 application built with Domain-Driven Design (DDD) principles and multi-tenancy support. The application manages recruitment processes, candidate assessments, and occupational data integration.

### Code Organization

#### Domain Layer (`src/Domain/`)

The application is organized into bounded contexts under `src/Domain/`, for example:

- **Users**: Multi-tenant user management with organizations, roles, and permissions
- **Occupations**: O*NET occupational data management (40+ specialized models)
- **Recruitments**: Recruitment process workflows with skills matching
- **Candidates**: Candidate management with state tracking
- **Tests**: Assessment system with multi-section tests and submissions
- **ActivityLog**: System-wide audit trail

Each domain follows consistent structure and typically contains these folders:

- `Actions` - Business logic. A single action for each use case.
- `Commands ` - Custom artisan commands
- `Data ` - Laravel Data objects
- `Database ` - Database, contains the following subfolders: `Factories`, `Migrations`, `Seeders`
- `Enums` - Domain-specific enums
- `Models` - Domain models
- `Policies` - Authorization policies
- `Tests` - Domain specific tests

#### Application Layer (`src/App/`)
- Controllers, middleware, and HTTP-related concerns
- Filament admin panels and resources
- Livewire components for frontend interactions
- Keep controllers thin. Controller delegates validation to Data objects and business logic to domain actions.

#### Support Layer (`src/Support/`)
- Shared base classes and traits
- Common utilities and helpers
- Value objects and contracts

#### Integration Layer (`src/Integrations/`)
- External service integrations (O*NET, etc.)
- Third-party API clients

### Key Architectural Patterns

#### Domain-Driven Design (DDD)
- Bounded contexts organized by business domain
- Rich domain models with business logic encapsulation
- Actions contain single-use business logic
- Data objects handle validation and transformation
- Repository pattern for data persistence (through Eloquent)

#### Multi-Tenancy
- Organization-based tenancy using Filament's tenant system
- Models use `BelongsToOrganization` trait for automatic scoping
- Context management via Laravel's Context facade
- Tenant-specific data isolation and security policies

#### ULID Primary Keys
- All models use ULIDs for globally unique, sortable identifiers
- Domain-specific prefixes for entity identification:
  - `eu_` for users
  - `t_` for tests  
  - `r_` for recruitments
  - `c_` for candidates
- URL-safe and time-ordered for better database performance

#### Authorization & Security
- Policy-based authorization for all resources
- Multi-tenant security enforcement at model level
- Rate limiting on sensitive endpoints
- Input validation through Laravel Data objects
- XSS and SQL injection prevention via Laravel's built-in protections

#### Performance Optimization
- Strategic database indexing for search queries
- Eager loading to prevent N+1 queries
- Database query optimization with proper relationships
- Caching strategies for frequently accessed data

#### Testing Strategy
- Pest-based test suite with comprehensive coverage
- Multi-tenant test isolation and verification
- Browser testing for end-to-end validation
- Policy and authorization testing
- Performance and security testing

#### Event-Driven Architecture
- Domain events for cross-boundary communication
- Activity logging for audit trails
- Queue-based processing for heavy operations
- Event sourcing for critical business events
