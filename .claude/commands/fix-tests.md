---
allowed-tools: Grep, LS, Read, Edit, MultiEdit, Write, NotebookEdit, WebFetch, TodoWrite, WebSearch, BashOutput, KillBash, ListMcpResourcesTool, ReadMcpResourceTool, Bash, Glob
description: Run test suite. Review and fix all failing tests.
model: claude-opus-4-1
---

## Fix GitHub PR based on comments. Usage: /fix-tests

OBJECTIVE:
Use the qa-expert agent to run the whole test suite and comprehensively review any failures. Then make a plan to fix the failures amd then implement the fix. Report back the detected test failures and whether they were fixed or not. Your final reply must contain the markdown report and nothing else.

1. Run the test suite: `php artisan test`

2. **Write a TODO**
   Write all the errors to Markdown checklist to this file: `reports/test-errors.md`. Include the error, filename, line number and anything else that is relevant to later fix the issue.

3. **Make a plan:**
   Read the checklist at `reports/test-errors.md` and make a detailed plan to fix each item on the list one by one. 
   If there are similar failures, you may group them together as one item. 
   If there are too many failing tests. Select the first 10 failing tests that has not been checked off.

4. **Fix the failing tests:** 
   Execute the plan and address each failing test one by one. Fix and verify before checking the item off and move to the next one.
   Many times failing tests is because the application has changed deliberately. Try to find out if that is the case or not. If so, update the tests rather than the code. If you are unsure, please ask for confirmation if the test or the code should be updated. 

5. After all items on the list has been checked off, summarize what you did, and if something needs more attention.
