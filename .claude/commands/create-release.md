---
allowed-tools: Bash, Read, Write, Edit, Glob, Grep
description: Create a new GitHub release with automatic changelog generation
model: claude-opus-4-1
---

# Create Release Command

Create a comprehensive GitHub release with automatic changelog generation and semantic versioning.

## Workflow
1. **Checkout main branch** and ensure it's up-to-date
2. **Check for existing draft releases** - if found, ask whether to update existing draft or create new release
3. **Determine version bump** (patch/minor/major) based on commit analysis
4. **Generate changelog** from commits since last release/tag
5. **Show changelog** 
6. **Update CHANGELOG.md** with date, new version and changes
7. **Create/update draft GitHub release** using `gh` CLI
8. **Tag the release** appropriately

## Changelog Format
Uses Keep a Changelog format with the following sections:
- **Added** for new features
- **Changed** for changes in existing functionality  
- **Deprecated** for soon-to-be removed features
- **Removed** for now removed features
- **Fixed** for any bug fixes
- **Security** for vulnerabilities

## Version Determination
Analyzes commits since last release using conventional commits:
- **MAJOR** (x.0.0): Breaking changes, major refactors
- **MINOR** (x.y.0): New features, significant additions
- **PATCH** (x.y.z): Bug fixes, small improvements

## Commit Analysis Keywords
- **Breaking changes**: `BREAKING CHANGE`, `breaking:`, major refactoring
- **Features**: `feat:`, `feature:`, new functionality
- **Fixes**: `fix:`, `bugfix:`, resolved issues
- **Improvements**: `perf:`, `refactor:`, `style:`, `chore:`

## Behavior
- Creates CHANGELOG.md if it doesn't exist
- Checks for existing draft releases and asks whether to update or create new
- If no previous release exists, just write "Initial release" and tag it as 1.0.0 if the user didn't specify anything else. 
- Uses semantic versioning (semver) format
- Creates draft GitHub releases by default
- Creates both git tag and GitHub release
- Includes commit details in release notes

## Error Handling
- Verifies GitHub CLI is authenticated
- Checks for uncommitted changes
- Ensures main branch is current and up-to-date
- Validates version format
- Handles API rate limits gracefully
