---
allowed-tools: Grep, LS, Read, Edit, MultiEdit, Write, NotebookEdit, WebFetch, TodoWrite, WebSearch, BashOutput, KillBash, ListMcpResourcesTool, ReadMcpResourceTool, Bash, Glob
description: Create an Architecture Decision Record for the current changes if necessary
model: claude-opus-4-1
---

Run the following commands to analyze all changes made in this branch.

```
!`git status`
```

FILES MODIFIED:

```
!`git diff --name-only origin/HEAD...`
```

COMMITS:

```
!`git log --no-decorate origin/HEAD...`
```

DIFF CONTENT:

```
!`git diff --merge-base origin/HEAD`
```

**Your task:**
1. Review the COMPLETE diff output to understand what was implemented
2. Create a TODO list of files/functions to investigate further if the diff doesn't show enough context
3. Execute those TODOs - read additional files as needed for full understanding
4. Determine if this is a significant architectural change (new service, caching layer, database integration, API changes, etc.)
5. If significant, create an Architecture Decision Record (ADR) that documents:
    - The technical decisions made in the code
    - Why this approach was chosen (inferred from the implementation)
    - Trade-offs and alternatives (based on what you see in the code)

**Skip ADR creation if:**
- Only minor bug fixes or refactoring
- Documentation or test-only changes
- Configuration tweaks without architectural impact

**Instructions:**
- Use the ADR template from `docs/templates/architecture-decision-record.md` if it exists
- Create the ADR in `docs/architecture-decision-records/` folder (create folders if needed)
- Use a name that describes the architectural decision, for example: `locator-pattern.md` or `` (or other descriptive name based on the change)
- Focus on WHAT you see in the code, not hypotheticals
- Include specific technical details: libraries used, data structures, algorithms, actual values
- Document actual configuration values and thresholds you find in the code
- **Prioritize accuracy**: Read as many files as needed to fully understand the change
- If you see references to functions/classes not in the diff, investigate them

The ADR should help reviewers understand the architectural decisions without needing to dig through all the code changes.
