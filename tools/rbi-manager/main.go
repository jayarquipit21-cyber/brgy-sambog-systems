package main

import (
    "bufio"
    "fmt"
    "os"
    "os/exec"
    "path/filepath"
    "strings"
)

func main() {
    // default project dir: executable directory
    exePath, err := os.Executable()
    if err != nil {
        fmt.Fprintln(os.Stderr, "unable to resolve executable path:", err)
        os.Exit(2)
    }

    exeDir := filepath.Dir(exePath)

    // allow optional --project-dir flag as first arg
    projectDir := exeDir
    args := os.Args[1:]
    if len(args) >= 2 && args[0] == "--project-dir" {
        projectDir = args[1]
        args = args[2:]
    }

    if len(args) == 0 {
        interactiveMenu(projectDir)
        return
    }

    // Forward to php artisan rbi:manage with given args
    runCommand(projectDir, args...)
}

func interactiveMenu(projectDir string) {
    reader := bufio.NewReader(os.Stdin)
    for {
        fmt.Println("\nRBI Manager — choose an action:")
        fmt.Println("  1) Import CSV file                     — Import residents and households from a CSV file")
        fmt.Println("  2) Truncate residents                  — Remove all rows from the `residents` table")
        fmt.Println("  3) Truncate residents + households    — Remove `residents` and `households` (destructive)")
        fmt.Println("  4) Delete rows from table             — Delete rows using a simple where clause")
        fmt.Println("  5) Delete ALL data (residents + households) — Equivalent to option 3, with stronger warning")
        fmt.Println("  6) Exit")
        fmt.Println("  h) Help / details")
        fmt.Print("Select an option (1-6 or h): ")
        choice, _ := reader.ReadString('\n')
        choice = strings.TrimSpace(choice)

        switch choice {
        case "1":
            fmt.Print("Enter CSV file path: ")
            file, _ := reader.ReadString('\n')
            file = strings.TrimSpace(file)
            if file == "" {
                fmt.Println("No file provided, aborting action.")
                continue
            }
            runCommand(projectDir, "import", file)
        case "2":
            if confirmPrompt(reader, "This will permanently delete all residents. Continue? (y/n): ") {
                runCommand(projectDir, "truncate")
            }
        case "3":
            if confirmPrompt(reader, "This will permanently delete residents and households. Continue? (y/n): ") {
                runCommand(projectDir, "truncate", "--all")
            }
        case "4":
            fmt.Print("Enter table name (e.g. residents): ")
            table, _ := reader.ReadString('\n')
            table = strings.TrimSpace(table)
            if table == "" {
                fmt.Println("Table required.")
                continue
            }
            fmt.Print("Enter where clause (column=value): ")
            where, _ := reader.ReadString('\n')
            where = strings.TrimSpace(where)
            if where == "" {
                fmt.Println("Where clause required.")
                continue
            }
            if confirmPrompt(reader, fmt.Sprintf("Delete from %s where %s ? (y/n): ", table, where)) {
                runCommand(projectDir, "delete", fmt.Sprintf("--table=%s", table), fmt.Sprintf("--where=%s", where))
            }
        case "5":
            if confirmPrompt(reader, "THIS WILL PERMANENTLY DELETE ALL DATA (residents + households). Continue? (y/n): ") {
                runCommand(projectDir, "truncate", "--all")
            }
        case "6":
            fmt.Println("Exiting.")
            return
        case "h", "?":
            fmt.Println("\nDetailed help:")
            fmt.Println("  1 - Import CSV file: Provide a path to a CSV. Columns are mapped by header names (lowercased). Households are created when a household_no is present. Residents require first_name and last_name.")
            fmt.Println("  2 - Truncate residents: Deletes all records from the residents table. This is irreversible.")
            fmt.Println("  3 - Truncate residents + households: Deletes residents then households. Use with caution.")
            fmt.Println("  4 - Delete rows from table: Prompts for a table name and a where clause in the form column=value. Performs a simple delete query.")
            fmt.Println("  5 - Delete ALL data: Strong confirmation then runs truncate --all (residents + households).")
            fmt.Println("  You can also run the underlying artisan command directly: php artisan rbi:manage <action> [file] [--all] [--table=] [--where=]")
        default:
            fmt.Println("Invalid choice")
        }
    }
}

func confirmPrompt(r *bufio.Reader, prompt string) bool {
    fmt.Print(prompt)
    ans, _ := r.ReadString('\n')
    ans = strings.TrimSpace(strings.ToLower(ans))
    return ans == "y" || ans == "yes"
}

func runCommand(projectDir string, args ...string) {
    cmdArgs := append([]string{"artisan", "rbi:manage"}, args...)
    cmd := exec.Command("php", cmdArgs...)
    cmd.Dir = projectDir
    cmd.Stdout = os.Stdout
    cmd.Stderr = os.Stderr
    cmd.Stdin = os.Stdin

    if err := cmd.Run(); err != nil {
        // if exit error, propagate exit code
        if exitErr, ok := err.(*exec.ExitError); ok {
            if status, ok := exitErr.Sys().(interface{ ExitStatus() int }); ok {
                os.Exit(status.ExitStatus())
            }
        }
        fmt.Fprintln(os.Stderr, "failed to execute php artisan:", err)
        // do not exit the whole program when running interactive; just return
    }
}
