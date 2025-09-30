---
allowed-tools: 
description: Commit all local changes and create Pull Request
model: claude-opus-4-1
---

# Create Pull Request Command

Create a new branch, commit changes, and submit a pull request.

## Behavior
- Check the code with `composer run check`
- Analyzes changes and automatically splits into logical commits when appropriate
- Each commit focuses on a single logical change or feature
- Creates descriptive commit messages for each logical unit
- Pushes branch to remote. Use `--no-verify` when pushing. 
- Creates pull request with proper summary, test plan and (if it makes sense) usage examples. DO NOT add any ads such as "Generated with [Claude Code](https://claude.ai/code)"

## Guidelines for Automatic Commit Splitting
- Do not create a new branch by default
- If you are on main branch ask if a new branch should be created.
- If a PR already exists ask if that PR should be updated or if a new branch with a new PR should be created. 
- Split commits by feature, component, or concern
- Keep related file changes together in the same commit
- Separate refactoring from feature additions
- Ensure each commit can be understood independently
- Multiple unrelated changes should be split into separate commits
- DO NOT add any ads such as "Generated with [Claude Code](https://claude.ai/code)" or "Co-Authored-By..."

