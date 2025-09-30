
## Run Pest Type Coverage test and fix reported issues

This workflow outlines the steps to analyze your PHP code using PEST and address any identified problems.

1.  **Run Pest Type Coverage test:**
    Open your terminal and navigate to your project's root directory.
    Execute the Larastan analysis command. This is typically:
    ```bash
    ./vendor/bin/pest --type-coverage
    ```

2.  **Review the Output:**
    Pest will output a list of errors or warnings found in your code, along with the file path and line number.
    Carefully read each reported issue to understand what needs to be fixed.

3.  **Fix the Issues:**
    Open the reported files in your editor. 
    For example, `pa76` indicates a missing parameter type hint on line 76, 
    and `rt33` indicates a missing return type hint on line 33.

4.  **Re-run Pest Type Coverage test:**
    After making fixes, re-run the analysis command from step 1:
    ```bash
    ./vendor/bin/pest --type-coverage
    ```

5.  **Repeat if Necessary:**
    If new errors appear or some were not fully resolved, go back to step 2 and repeat the process until Pest reports "100 %" coverage.

6.  **Commit Changes:**
    Once all issues are resolved and Pest type coverage passes, you are done.
