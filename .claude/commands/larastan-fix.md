
## Run Larastan (PHPStan) and fix reported issues

This workflow outlines the steps to analyze your PHP code using Larastan and address any identified problems.

1. **Run Larastan Analysis:**
Execute the Larastan analysis command from the project's root directory:
```bash
./vendor/bin/phpstan analyse
```
    
2. **Write a TODO**
Write all the errors to Markdown checklist to this file: `reports/larastan-errors.md`. Include the error, filename, line number and anything else that is relevant to later fix the issue. 

3. **Fix the Issues:**
Read the checklist at `reports/larastan-errors.md`.
Address each issue one by one. Fix and verify before checking the item off and move to the next one. Common fixes include:
* Adding or correcting PHPStan Attributes See: vendor/php-static-analysis/attributes/src
* No PHPDoc type hints unless required by PHPStan but prefer PHPStan Attributes
* Refactoring code to improve type safety.
* Correcting logic errors or potential bugs identified by PHPStan.

If you need more information about the issue check the link that is provided with the error in the command output. 

If you still need more information, you think an error is a false positive, or you have a valid reason to ignore it, you can skip it for now and save it for last. 

4. **Re-check unchecked items**
When you are done with the checklist, go back to all items that are unchecked. Write a short motivation with your reasoning and ask for confirmation before you continue. For ignoring a line use `@phpstan-ignore-next-line`.

5.  **Re-run Larastan:**
After making fixes, re-run the analysis command from step 1:
```bash
./vendor/bin/phpstan analyse 
```

6.  **Repeat if Necessary:**
If new errors appear or some were not fully resolved, go back to step 2 and repeat the process until Larastan reports "No errors".

7.  **You are done:**
Once all issues are resolved and Larastan passes, you are done.
