---
allowed-tools: mcp__linear__get_issue, mcp__linear__list_comments,  mcp__linear__get_document mcp__linear__list_documents, mcp__linear__list_issue_statuses, mcp__linear__list_projects, mcp__linear__get_project,mcp__linear__get_issue_status
description: Start working on a linear issue.
---
## Start working on a linear issue. Usage: /linear_issue RAD-15

1. Make sure the linear MCP server is running. 
2. If it isn't running, prompt the user to run it. If it is running, look up the issue $ARGUMENTS. 
3. If the issue is assigned to someone else, assign the issue to my linear user and set the state to in progress. 
4. Read the title, the description and the comments of the issue and the parent issue if there is one. 
5. Make sure you understand the problem. Gather information by reading any links in the issue and by searching the codebase for relevant files. If the issue does not contain enough information, please ask for more relevant information and clarifications. It is better to ask for clarifications than going in the wrong direction.
6. When you have enough information about the issue, Make a plan where you propose how this can be addressed and fixed, and present it to me. 
7. When the plan is approved, make a new branch with the appropriate linear encoded branch name for the issue. The branch name should be something like: `rad-111-issue-title`
8. Continue solving the issue like normal. 
