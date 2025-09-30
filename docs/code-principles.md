# Enterprise-Grade Laravel Code Standards & Technical Excellence Checklist

## I. Core Engineering Philosophy

*   [ ] **Security First:** Every line of code must be written with security implications in mind
*   [ ] **Performance by Design:** Optimize from the start, not as an afterthought
*   [ ] **Scalability Built-In:** Code must handle 10x current load without architectural changes
*   [ ] **Maintainability Focus:** Code should be easier to modify than to write from scratch
*   [ ] **Test-Driven Quality:** No code without tests, no feature without coverage
*   [ ] **Domain Integrity:** Strict boundary enforcement between bounded contexts
*   [ ] **Zero-Tolerance for Technical Debt:** Fix issues immediately, not "later"
*   [ ] **Observability Required:** Every system behavior must be monitorable and traceable

## II. Security Standards (OWASP + Laravel)

### A. Authentication & Authorization
*   [ ] **Policy-Based Authorization:**
    *   [ ] Every model has a corresponding policy class
    *   [ ] All controller actions use `authorize()` or gate checks
    *   [ ] Resource controllers use `authorizeResource()`
    *   [ ] API endpoints validate permissions via Sanctum abilities
*   [ ] **Multi-Factor Authentication:**
    *   [ ] 2FA implementation for admin/sensitive accounts
    *   [ ] Time-based OTP (TOTP) compliance
    *   [ ] Recovery codes properly encrypted
*   [ ] **Session Security:**
    *   [ ] Secure session configuration (secure cookies, httpOnly, sameSite)
    *   [ ] Session regeneration on privilege escalation
    *   [ ] Proper session timeout implementation
    *   [ ] Device tracking and suspicious activity detection

### B. Input Validation & Sanitization
*   [ ] **Laravel Data Objects:**
    *   [ ] All input validated through Data objects, never raw request data
    *   [ ] Comprehensive validation rules (type, format, range, business logic)
    *   [ ] Custom validation messages for user clarity
    *   [ ] Nested data validation for complex structures
*   [ ] **SQL Injection Prevention:**
    *   [ ] NEVER use raw SQL without parameter binding
    *   [ ] Query builder used for all database operations
    *   [ ] Prepared statements for complex queries
    *   [ ] Input validation before database operations
*   [ ] **XSS Protection:**
    *   [ ] Blade's `{{ }}` for all user output (auto-escaping)
    *   [ ] `{!! !!}` only for trusted, sanitized content
    *   [ ] Content Security Policy (CSP) headers configured
    *   [ ] HTML Purifier for rich text content

### C. File Upload Security
*   [ ] **Validation Requirements:**
    *   [ ] MIME type validation (client and server-side)
    *   [ ] File extension whitelist enforcement
    *   [ ] Maximum file size limits
    *   [ ] Virus scanning integration for user uploads
*   [ ] **Storage Security:**
    *   [ ] Files stored outside web root
    *   [ ] UUID filenames to prevent enumeration
    *   [ ] Proper file permissions (644 for files, 755 for directories)
    *   [ ] Signed URLs for temporary access

### D. API Security
*   [ ] **Rate Limiting:**
    *   [ ] Throttle middleware on all public endpoints
    *   [ ] Different limits for authenticated vs public
    *   [ ] Per-user and per-IP rate limiting
    *   [ ] Exponential backoff for repeated failures
*   [ ] **API Authentication:**
    *   [ ] Sanctum tokens with expiration
    *   [ ] Ability-based permissions per token
    *   [ ] Token revocation capability
    *   [ ] API versioning strategy

### E. Sensitive Data Protection
*   [ ] **Encryption Standards:**
    *   [ ] Database encryption for PII fields
    *   [ ] Encrypted casts for sensitive model attributes
    *   [ ] Proper key management (rotation strategy)
    *   [ ] Transit encryption (HTTPS everywhere)
*   [ ] **Logging & Monitoring:**
    *   [ ] NEVER log passwords, tokens, or PII
    *   [ ] Structured logging with correlation IDs
    *   [ ] Audit trail for sensitive operations
    *   [ ] PCI/GDPR compliance where applicable

## III. Laravel 12 Best Practices

### A. Architecture & Domain-Driven Design
*   [ ] **Layer Separation:**
    *   [ ] Domain Layer: Pure business logic, no framework dependencies
    *   [ ] Application Layer: Controllers, middleware, HTTP concerns only
    *   [ ] Infrastructure Layer: External service integrations
    *   [ ] Support Layer: Shared utilities and base classes
*   [ ] **Bounded Contexts:**
    *   [ ] Clear domain boundaries (no cross-domain model relationships)
    *   [ ] Domain events for inter-context communication
    *   [ ] Separate database schemas per context where appropriate
    *   [ ] Anti-corruption layers for external integrations
*   [ ] **Action Pattern:**
    *   [ ] Single responsibility per action class
    *   [ ] Extends `Support\BaseClasses\BaseAction`
    *   [ ] Proper error handling and logging
    *   [ ] Queue-able for async processing
    *   [ ] Testable in isolation

### B. Eloquent & Database Optimization
*   [ ] **Query Optimization:**
    *   [ ] Eager loading to prevent N+1 queries
        ```php
        // Good
        User::with(['posts.comments', 'profile'])->get();
        
        // Bad
        $users = User::all();
        foreach ($users as $user) {
            $user->posts; // N+1 problem
        }
        ```
    *   [ ] Select only required columns
        ```php
        User::select(['id', 'name', 'email'])->get();
        ```
    *   [ ] Chunking for large datasets
        ```php
        User::chunk(1000, function ($users) {
            // Process users
        });
        ```
    *   [ ] Database indexing on all foreign keys and WHERE clause columns
*   [ ] **Model Best Practices:**
    *   [ ] ULID primary keys with proper prefixes
    *   [ ] Casts defined in `casts()` method, not property
    *   [ ] Global scopes for tenant isolation
    *   [ ] Model events for cross-cutting concerns
    *   [ ] Proper relationship definitions with return types

### C. Service Container & Dependency Injection
*   [ ] **Binding Strategies:**
    *   [ ] Interface bindings for swappable implementations
    *   [ ] Singleton for stateless services
    *   [ ] Contextual binding for different implementations
    *   [ ] Service providers for complex bootstrapping
*   [ ] **Dependency Injection:**
    *   [ ] Constructor injection over facades
    *   [ ] Method injection for optional dependencies
    *   [ ] Avoid service location anti-pattern
    *   [ ] Type-hint interfaces, not concrete classes

### D. Queue & Background Jobs
*   [ ] **Job Design:**
    *   [ ] Idempotent job execution
    *   [ ] Proper failure handling and retry logic
    *   [ ] Timeout configuration based on task
    *   [ ] Memory-efficient processing
*   [ ] **Queue Configuration:**
    *   [ ] Appropriate queue drivers (Redis for production)
    *   [ ] Queue priorities for different job types
    *   [ ] Horizon for monitoring and metrics
    *   [ ] Failed job handling strategy

### E. Caching Strategy
*   [ ] **Cache Layers:**
    *   [ ] Query result caching with proper invalidation
    *   [ ] Response caching for expensive operations
    *   [ ] View fragment caching for complex UI
    *   [ ] CDN integration for static assets
*   [ ] **Cache Keys:**
    *   [ ] Unique, predictable key generation
    *   [ ] Versioned keys for cache busting
    *   [ ] TTL appropriate to data volatility
    *   [ ] Cache tags for grouped invalidation

## IV. Performance Optimization

### A. Database Performance
*   [ ] **Indexing Strategy:**
    *   [ ] Primary key indexes (automatic with migrations)
    *   [ ] Foreign key indexes (manual addition required)
    *   [ ] Composite indexes for multi-column queries
    *   [ ] Covering indexes for read-heavy tables
    *   [ ] Regular EXPLAIN analysis for slow queries
*   [ ] **Query Optimization:**
    *   [ ] Avoid SELECT * queries
    *   [ ] Use database views for complex aggregations
    *   [ ] Implement query result caching
    *   [ ] Database connection pooling
    *   [ ] Read/write splitting for scalability

### B. Application Performance
*   [ ] **Code Optimization:**
    *   [ ] Lazy loading for expensive operations
    *   [ ] Collection methods over array functions
    *   [ ] Generator usage for memory efficiency
    *   [ ] Avoid premature optimization
*   [ ] **Asset Optimization:**
    *   [ ] Vite for asset bundling and versioning
    *   [ ] Image optimization and lazy loading
    *   [ ] Critical CSS inlining
    *   [ ] JavaScript code splitting

### C. API Performance
*   [ ] **Response Optimization:**
    *   [ ] Pagination for list endpoints (max 100 items)
    *   [ ] Field filtering capability
    *   [ ] Response compression (gzip)
    *   [ ] HTTP caching headers (ETag, Last-Modified)
*   [ ] **Resource Efficiency:**
    *   [ ] API resource classes for response shaping
    *   [ ] Conditional response inclusion
    *   [ ] Sparse fieldsets support
    *   [ ] Batch endpoint for multiple operations

## V. Testing Standards

### A. Test Coverage Requirements
*   [ ] **Coverage Metrics:**
    *   [ ] Minimum 80% code coverage
    *   [ ] 100% coverage for critical paths
    *   [ ] All public methods tested
    *   [ ] Edge cases and error conditions covered
*   [ ] **Test Types:**
    *   [ ] Unit tests for isolated logic
    *   [ ] Feature tests for user workflows
    *   [ ] Integration tests for external services
    *   [ ] Browser tests for critical UI flows

### B. Pest Testing Patterns
*   [ ] **Test Structure:**
    ```php
    it('performs specific behavior', function () {
        // Arrange
        $user = User::factory()->create();
        
        // Act
        $response = $this->actingAs($user)
            ->post('/api/posts', [...]);
        
        // Assert
        expect($response->status())->toBe(201);
        expect(Post::count())->toBe(1);
    });
    ```
*   [ ] **Factory Usage:**
    *   [ ] Factories for all models
    *   [ ] States for different scenarios
    *   [ ] Minimal data generation
    *   [ ] Faker for realistic test data

### C. Test Quality
*   [ ] **Test Isolation:**
    *   [ ] Database transactions for each test
    *   [ ] No test interdependencies
    *   [ ] Proper test data cleanup
    *   [ ] Mock external services
*   [ ] **Assertion Quality:**
    *   [ ] Multiple relevant assertions per test
    *   [ ] Test one behavior per test method
    *   [ ] Clear test names describing behavior
    *   [ ] Avoid brittle assertions

## VI. Multi-Tenancy Considerations

### A. Data Isolation
*   [ ] **Tenant Scoping:**
    *   [ ] Global scopes on all tenant-owned models
    *   [ ] BelongsToOrganization trait usage
    *   [ ] Middleware for tenant context setting
    *   [ ] Validation of tenant ownership
*   [ ] **Cross-Tenant Security:**
    *   [ ] Prevent tenant ID manipulation
    *   [ ] Validate tenant context in policies
    *   [ ] Audit cross-tenant access attempts
    *   [ ] Separate database connections per tenant (if required)

### B. Performance at Scale
*   [ ] **Tenant-Aware Caching:**
    *   [ ] Cache keys include tenant identifier
    *   [ ] Per-tenant cache pools where appropriate
    *   [ ] Cache warming strategies
    *   [ ] Tenant-specific TTLs
*   [ ] **Resource Limits:**
    *   [ ] Per-tenant rate limiting
    *   [ ] Storage quotas enforcement
    *   [ ] Concurrent user limits
    *   [ ] Fair resource allocation

## VII. Code Quality Metrics

### A. Complexity Metrics
*   [ ] **Method Complexity:**
    *   [ ] Cyclomatic complexity < 10
    *   [ ] Cognitive complexity < 15
    *   [ ] Maximum method length: 20 lines
    *   [ ] Maximum class length: 200 lines
*   [ ] **Dependency Metrics:**
    *   [ ] Maximum dependencies per class: 5
    *   [ ] Avoid circular dependencies
    *   [ ] Stable dependency principle
    *   [ ] Interface segregation

### B. SOLID Principles
*   [ ] **Single Responsibility:**
    *   [ ] One reason to change per class
    *   [ ] Clear, focused class purposes
    *   [ ] Avoid god objects
    *   [ ] Proper concern separation
*   [ ] **Open/Closed:**
    *   [ ] Extension through inheritance/composition
    *   [ ] Strategy pattern for variable behavior
    *   [ ] Plugin architectures where appropriate
    *   [ ] Minimal modification of existing code
*   [ ] **Liskov Substitution:**
    *   [ ] Subclasses truly substitutable
    *   [ ] No strengthened preconditions
    *   [ ] No weakened postconditions
    *   [ ] Consistent behavior contracts
*   [ ] **Interface Segregation:**
    *   [ ] Small, focused interfaces
    *   [ ] Client-specific interfaces
    *   [ ] No unused method implementations
    *   [ ] Role-based interface design
*   [ ] **Dependency Inversion:**
    *   [ ] Depend on abstractions
    *   [ ] High-level modules independent
    *   [ ] Dependency injection usage
    *   [ ] Inversion of control containers

## VIII. Development Workflow

### A. Code Review Requirements
*   [ ] **Pre-Commit Checks:**
    *   [ ] Laravel Pint formatting (PSR-12)
    *   [ ] PHPStan static analysis (level 8)
    *   [ ] Test suite passing
    *   [ ] No security vulnerabilities
*   [ ] **Review Checklist:**
    *   [ ] Security implications assessed
    *   [ ] Performance impact analyzed
    *   [ ] Test coverage verified
    *   [ ] Documentation updated
    *   [ ] Breaking changes documented

### B. Continuous Integration
*   [ ] **CI Pipeline:**
    *   [ ] Automated testing on all branches
    *   [ ] Code quality gates
    *   [ ] Security scanning
    *   [ ] Performance benchmarking
*   [ ] **Deployment Safety:**
    *   [ ] Zero-downtime deployments
    *   [ ] Database migration safety
    *   [ ] Feature flags for risky changes
    *   [ ] Rollback procedures documented

## IX. Documentation Standards

### A. Code Documentation
*   [ ] **PHPDoc Requirements:**
    *   [ ] Complex logic explanation
    *   [ ] Non-obvious parameter usage
    *   [ ] Return type clarification
    *   [ ] Exception documentation
    *   [ ] NO redundant documentation
*   [ ] **Inline Comments:**
    *   [ ] Explain "why", not "what"
    *   [ ] Complex algorithm explanation
    *   [ ] Business rule documentation
    *   [ ] TODO items with assignee and date

### B. API Documentation
*   [ ] **Endpoint Documentation:**
    *   [ ] Request/response examples
    *   [ ] Authentication requirements
    *   [ ] Rate limiting information
    *   [ ] Error response catalog
*   [ ] **Integration Guides:**
    *   [ ] SDK examples
    *   [ ] Webhook documentation
    *   [ ] Postman/OpenAPI collections
    *   [ ] Versioning strategy

## X. Error Handling & Observability

### A. Exception Handling
*   [ ] **Structured Exceptions:**
    *   [ ] Domain-specific exception classes
    *   [ ] Proper exception hierarchy
    *   [ ] User-friendly error messages
    *   [ ] Stack trace security
*   [ ] **Error Recovery:**
    *   [ ] Graceful degradation
    *   [ ] Retry strategies
    *   [ ] Circuit breaker patterns
    *   [ ] Fallback mechanisms

### B. Logging & Monitoring
*   [ ] **Log Levels:**
    *   [ ] DEBUG: Detailed diagnostic info
    *   [ ] INFO: General informational messages
    *   [ ] WARNING: Potential issues
    *   [ ] ERROR: Error conditions
    *   [ ] CRITICAL: System stability threats
*   [ ] **Monitoring Integration:**
    *   [ ] APM tool integration (New Relic, DataDog)
    *   [ ] Custom metrics collection
    *   [ ] Real-time alerting
    *   [ ] Performance baseline tracking

## XI. Laravel-Specific Anti-Patterns to Avoid

*   [ ] ❌ Using `env()` outside config files
*   [ ] ❌ Raw SQL queries without bindings
*   [ ] ❌ N+1 query problems
*   [ ] ❌ Fat controllers (business logic in controllers)
*   [ ] ❌ Direct model manipulation in views
*   [ ] ❌ Hardcoded configuration values
*   [ ] ❌ Missing database indexes
*   [ ] ❌ Synchronous processing of heavy tasks
*   [ ] ❌ Global helper function abuse
*   [ ] ❌ Service location instead of dependency injection
*   [ ] ❌ Missing validation on user input
*   [ ] ❌ Exposed sensitive information in responses
*   [ ] ❌ Inefficient collection operations
*   [ ] ❌ Missing authorization checks
*   [ ] ❌ Untested code paths

## XII. Performance Benchmarks

### Target Metrics
*   [ ] **Response Times:**
    *   [ ] API endpoints: < 200ms (p95)
    *   [ ] Page loads: < 1s (p95)
    *   [ ] Database queries: < 50ms (p95)
    *   [ ] Background jobs: < 30s (p95)
*   [ ] **Resource Usage:**
    *   [ ] Memory per request: < 128MB
    *   [ ] CPU utilization: < 70% sustained
    *   [ ] Database connections: < 100 concurrent
    *   [ ] Queue depth: < 1000 jobs
*   [ ] **Reliability:**
    *   [ ] Uptime: 99.9% minimum
    *   [ ] Error rate: < 0.1%
    *   [ ] Failed job rate: < 1%
    *   [ ] Cache hit rate: > 90%