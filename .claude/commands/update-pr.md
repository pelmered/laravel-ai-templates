---
allowed-tools: 
description: Commit all local changes and update Pull Request for current branch
model: claude-opus-4-1
---

# Update Existing Pull Request Command

Commit changes and update the pull request for the current branch

## Behavior
- Check the code with `composer run check`
- Analyzes changes and automatically splits into logical commits when appropriate
- Each commit focuses on a single logical change or feature
- Creates descriptive commit messages for each logical unit
- Pushes branch to remote. Use `--no-verify` when pushing. 
- Update the pull request summary, test plan and (if it makes sense) usage examples to reflect the new changes that was added. DO NOT add any ads such as "Generated with [Claude Code](https://claude.ai/code)"

## Guidelines for Automatic Commit Splitting
- Split commits by feature, component, or concern
- Keep related file changes together in the same commit
- Separate refactoring from feature additions
- Ensure each commit can be understood independently
- Multiple unrelated changes should be split into separate commits
- DO NOT add any ads such as "Generated with [Claude Code](https://claude.ai/code)" or "Co-Authored-By..."

