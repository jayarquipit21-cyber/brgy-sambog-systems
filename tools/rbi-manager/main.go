package main

import (
	"bufio"
	"encoding/json"
	"fmt"
	"os"
	"os/exec"
	"os/signal"
	"path/filepath"
	"runtime"
	"sort"
	"strings"
	"sync"
	"syscall"
	"time"
)

// ─── Version ────────────────────────────────────────────────────────────────

const version = "2.0.0"

// ─── ANSI Colors ────────────────────────────────────────────────────────────

var noColor bool

func color(code string) string {
	if noColor {
		return ""
	}
	return code
}

var (
	reset     = func() string { return color("\033[0m") }
	bold      = func() string { return color("\033[1m") }
	dim       = func() string { return color("\033[2m") }
	italic    = func() string { return color("\033[3m") }
	underline = func() string { return color("\033[4m") }

	red     = func() string { return color("\033[31m") }
	green   = func() string { return color("\033[32m") }
	yellow  = func() string { return color("\033[33m") }
	blue    = func() string { return color("\033[34m") }
	magenta = func() string { return color("\033[35m") }
	cyan    = func() string { return color("\033[36m") }
	white   = func() string { return color("\033[97m") }

	bgBlue    = func() string { return color("\033[44m") }
	bgGreen   = func() string { return color("\033[42m") }
	bgRed     = func() string { return color("\033[41m") }
	bgYellow  = func() string { return color("\033[43m") }
	bgMagenta = func() string { return color("\033[45m") }
	bgCyan    = func() string { return color("\033[46m") }
)

// ─── Command History ────────────────────────────────────────────────────────

type historyEntry struct {
	action string
	time   time.Time
	ok     bool
}

var (
	cmdHistory   []historyEntry
	historyMutex sync.Mutex
)

func addHistory(action string, ok bool) {
	historyMutex.Lock()
	defer historyMutex.Unlock()
	cmdHistory = append(cmdHistory, historyEntry{action: action, time: time.Now(), ok: ok})
	if len(cmdHistory) > 5 {
		cmdHistory = cmdHistory[len(cmdHistory)-5:]
	}
}

// ─── Output Helpers ─────────────────────────────────────────────────────────

func printSuccess(msg string) {
	fmt.Printf("  %s✓%s %s%s%s\n", green(), reset(), green(), msg, reset())
}

func printError(msg string) {
	fmt.Printf("  %s✗%s %s%s%s\n", red(), reset(), red(), msg, reset())
}

func printWarning(msg string) {
	fmt.Printf("  %s⚠%s %s%s%s\n", yellow(), reset(), yellow(), msg, reset())
}

func printInfo(msg string) {
	fmt.Printf("  %sℹ%s %s\n", cyan(), reset(), msg)
}

func printDivider() {
	fmt.Printf("  %s%s%s\n", dim(), strings.Repeat("─", 50), reset())
}

// ─── Spinner ────────────────────────────────────────────────────────────────

type spinner struct {
	frames  []string
	msg     string
	done    chan struct{}
	stopped bool
	mu      sync.Mutex
}

func newSpinner(msg string) *spinner {
	return &spinner{
		frames: []string{"⠋", "⠙", "⠹", "⠸", "⠼", "⠴", "⠦", "⠧", "⠇", "⠏"},
		msg:    msg,
		done:   make(chan struct{}),
	}
}

func (s *spinner) start() {
	go func() {
		i := 0
		for {
			select {
			case <-s.done:
				return
			default:
				frame := s.frames[i%len(s.frames)]
				fmt.Printf("\r  %s%s%s %s", cyan(), frame, reset(), s.msg)
				i++
				time.Sleep(80 * time.Millisecond)
			}
		}
	}()
}

func (s *spinner) stop(success bool) {
	s.mu.Lock()
	defer s.mu.Unlock()
	if s.stopped {
		return
	}
	s.stopped = true
	close(s.done)

	// Clear the spinner line
	fmt.Printf("\r%s\r", strings.Repeat(" ", len(s.msg)+10))

	if success {
		printSuccess(s.msg)
	} else {
		printError(s.msg)
	}
}

// ─── Banner ─────────────────────────────────────────────────────────────────

func printBanner() {
	fmt.Println()
	b := bold()
	c := cyan()
	bl := blue()
	d := dim()
	rs := reset()

	fmt.Printf("%s%s  ══════════════════════════════════════════════════%s\n", b, c, rs)
	fmt.Printf("%s%s   ██████  ██████  ██    ██████%s\n", b, bl, rs)
	fmt.Printf("%s%s   ██   █  ██   █  ██    ██   █%s\n", b, bl, rs)
	fmt.Printf("%s%s   ██████  ██████  ██    ██████%s   [ %sManager%s ]\n", b, bl, rs, b+c, rs)
	fmt.Printf("%s%s   ██   █  ██   █  ██    ██%s\n", b, bl, rs)
	fmt.Printf("%s%s   ██   █  ██████  ██    ██%s       v%s\n", b, bl, rs, version)
	fmt.Printf("%s%s  ──────────────────────────────────────────────────%s\n", b, c, rs)
	fmt.Printf("   %sRegistry of Barangay Inhabitants Manager%s\n", d, rs)
	fmt.Printf("%s%s  ══════════════════════════════════════════════════%s\n", b, c, rs)
	fmt.Println()
}

// ─── Menu ───────────────────────────────────────────────────────────────────

func printMenu() {
	w := white()
	b := bold()
	c := cyan()
	g := green()
	y := yellow()
	r := red()
	d := dim()
	rs := reset()
	m := magenta()

	fmt.Printf("  %s%s📊 DATA%s\n", b, c, rs)
	fmt.Printf("    %s%s1%s) %sView Statistics%s          %s— Dashboard with counts & breakdowns%s\n", b, g, rs, w, rs, d, rs)
	fmt.Printf("    %s%s2%s) %sSearch Residents%s         %s— Find residents by name or purok%s\n", b, g, rs, w, rs, d, rs)
	fmt.Printf("    %s%s3%s) %sExport to CSV%s            %s— Download data as spreadsheet%s\n", b, g, rs, w, rs, d, rs)
	fmt.Println()

	fmt.Printf("  %s%s📥 IMPORT%s\n", b, c, rs)
	fmt.Printf("    %s%s4%s) %sImport CSV / XLSX File%s    %s— Load residents from a file%s\n", b, y, rs, w, rs, d, rs)
	fmt.Println()

	fmt.Printf("  %s%s🗑  MANAGE%s\n", b, c, rs)
	fmt.Printf("    %s%s5%s) %sTruncate Residents%s       %s— Remove all resident records%s\n", b, r, rs, w, rs, d, rs)
	fmt.Printf("    %s%s6%s) %sTruncate All%s             %s— Remove residents + households%s\n", b, r, rs, w, rs, d, rs)
	fmt.Printf("    %s%s7%s) %sDelete Rows by Condition%s %s— Delete with a where clause%s\n", b, r, rs, w, rs, d, rs)
	fmt.Println()

	fmt.Printf("  %s%s⚙  SYSTEM%s\n", b, c, rs)
	fmt.Printf("    %s%s8%s) %sClear Application Cache%s  %s— Flush caches & restart workers%s\n", b, m, rs, w, rs, d, rs)
	fmt.Printf("    %s%s9%s) %sCommand History%s          %s— Show recent actions this session%s\n", b, m, rs, w, rs, d, rs)
	fmt.Printf("    %s%sh%s) %sHelp%s                     %s— Detailed usage guide%s\n", b, m, rs, w, rs, d, rs)
	fmt.Printf("    %s%s0%s) %sExit%s\n", b, m, rs, w, rs)
	fmt.Println()
}

// ─── Main ───────────────────────────────────────────────────────────────────

func main() {
	// Handle --no-color flag
	for _, arg := range os.Args[1:] {
		if arg == "--no-color" {
			noColor = true
		}
	}

	// Detect if output is not a terminal (piped)
	if fi, err := os.Stdout.Stat(); err == nil {
		if (fi.Mode() & os.ModeCharDevice) == 0 {
			noColor = true
		}
	}

	// Graceful Ctrl+C handling
	sigChan := make(chan os.Signal, 1)
	signal.Notify(sigChan, os.Interrupt, syscall.SIGTERM)
	go func() {
		<-sigChan
		fmt.Printf("\n\n  %s%sInterrupted. Goodbye!%s\n\n", bold(), yellow(), reset())
		os.Exit(0)
	}()

	// Resolve project directory
	exePath, err := os.Executable()
	if err != nil {
		printError("Unable to resolve executable path: " + err.Error())
		os.Exit(2)
	}
	exeDir := filepath.Dir(exePath)

	// allow optional --project-dir flag
	projectDir := exeDir
	// If artisan doesn't exist in projectDir, check the parent directory
	if _, err := os.Stat(filepath.Join(projectDir, "artisan")); os.IsNotExist(err) {
		parentDir := filepath.Dir(projectDir)
		if _, err := os.Stat(filepath.Join(parentDir, "artisan")); err == nil {
			projectDir = parentDir
		}
	}
	args := os.Args[1:]
	filteredArgs := []string{}
	for i := 0; i < len(args); i++ {
		if args[i] == "--project-dir" && i+1 < len(args) {
			projectDir = args[i+1]
			i++ // skip value
		} else if args[i] == "--no-color" {
			// already handled
		} else {
			filteredArgs = append(filteredArgs, args[i])
		}
	}

	if len(filteredArgs) > 0 {
		// Drag-and-drop detection: if the sole argument looks like a file path
		// (ends with a supported extension), treat it as a file import.
		firstArg := filteredArgs[0]
		extLower := strings.ToLower(filepath.Ext(firstArg))
		isFileDrop := len(filteredArgs) == 1 && (extLower == ".xlsx" || extLower == ".xls" || extLower == ".csv" || extLower == ".txt")

		if isFileDrop {
			printBanner()
			fmt.Printf("  %s📂 File dropped:%s %s\n\n", bold(), reset(), firstArg)

			if !authenticateUser(projectDir) {
				fmt.Printf("\n  %sPress Enter to close...%s", dim(), reset())
				bufio.NewReader(os.Stdin).ReadString('\n')
				os.Exit(1)
			}

			clearScreen()
			printBanner()
			printInfo("Starting import for: " + filepath.Base(firstArg))
			fmt.Println()

			err := runCommand(projectDir, true, "import", firstArg)

			fmt.Println()
			if err != nil {
				printError("Import failed. See errors above.")
			} else {
				printSuccess("Import completed successfully!")
			}

			fmt.Printf("\n  %sPress Enter to close...%s", dim(), reset())
			bufio.NewReader(os.Stdin).ReadString('\n')
			return
		}

		// Non-interactive mode: forward to php artisan
		runCommand(projectDir, false, filteredArgs...)
		return
	}

	// Interactive mode
	printBanner()
	if !authenticateUser(projectDir) {
		os.Exit(1)
	}
	interactiveMenu(projectDir)
}

func interactiveMenu(projectDir string) {
	reader := bufio.NewReader(os.Stdin)
	for {
		clearScreen()
		printBanner()
		printMenu()
		fmt.Printf("  %s%s❯%s Select an option: ", bold(), cyan(), reset())
		choice, _ := reader.ReadString('\n')
		choice = strings.TrimSpace(choice)
		fmt.Println()

		if choice == "0" || choice == "q" || choice == "Q" {
			fmt.Printf("  %s%sGoodbye! 👋%s\n\n", bold(), cyan(), reset())
			return
		}

		if choice == "" {
			continue
		}

		// Clear menu and show clean action screen
		clearScreen()
		printBanner()

		switch choice {
		case "1":
			handleViewStats(projectDir)
		case "2":
			handleSearchResidents(projectDir, reader)
		case "3":
			handleExportCSV(projectDir, reader)
		case "4":
			handleImportCSV(projectDir, reader)
		case "5":
			handleTruncateResidents(projectDir, reader)
		case "6":
			handleTruncateAll(projectDir, reader)
		case "7":
			handleDeleteRows(projectDir, reader)
		case "8":
			handleCacheClear(projectDir)
		case "9":
			handleShowHistory()
		case "h", "H", "?":
			handleHelp()
		default:
			printError(fmt.Sprintf("Invalid choice: %q. Enter 0-9 or h.", choice))
		}

		fmt.Println()
		fmt.Printf("  %sPress Enter to return to menu...%s", dim(), reset())
		_, _ = reader.ReadString('\n')
	}
}

// ─── Menu Handlers ──────────────────────────────────────────────────────────

func handleViewStats(projectDir string) {
	sp := newSpinner("Fetching database statistics...")
	sp.start()

	output, err := runCommandCapture(projectDir, "stats", "--format=json")
	sp.stop(err == nil)

	if err != nil {
		printError("Failed to fetch stats: " + err.Error())
		addHistory("View Statistics", false)
		return
	}

	// Parse JSON and display nicely
	var stats map[string]interface{}
	if jsonErr := json.Unmarshal([]byte(output), &stats); jsonErr != nil {
		// Fallback: just print raw output
		fmt.Println(output)
		addHistory("View Statistics", true)
		return
	}

	displayStats(stats)
	addHistory("View Statistics", true)
}

func displayStats(stats map[string]interface{}) {
	b := bold()
	c := cyan()
	g := green()
	y := yellow()
	w := white()
	d := dim()
	rs := reset()

	// Main counts
	totalR := getFloat(stats, "total_residents")
	totalH := getFloat(stats, "total_households")
	male := getFloat(stats, "male_count")
	female := getFloat(stats, "female_count")

	divider := "  " + b + c + strings.Repeat("─", 65) + rs
	dividerAge := "  " + b + c + strings.Repeat("─", 78) + rs

	fmt.Println()
	fmt.Printf("  %s%s  RBI Database Statistics%s\n", b, c, rs)
	fmt.Println(divider)
	fmt.Printf("    %sTotal Residents:%s   %s%s%.0f%s\n", d, rs, b, g, totalR, rs)
	fmt.Printf("    %sTotal Households:%s  %s%s%.0f%s\n", d, rs, b, g, totalH, rs)
	fmt.Printf("    %sMale:%s              %s%.0f%s\n", d, rs, w, male, rs)
	fmt.Printf("    %sFemale:%s            %s%.0f%s\n", d, rs, w, female, rs)

	lastImport := getStr(stats, "last_import")
	if lastImport == "" {
		lastImport = "Never"
	}
	fmt.Printf("    %sLast Import:%s       %s%s%s\n", d, rs, d, lastImport, rs)

	// Purok breakdown
	if purokData, ok := stats["residents_by_purok"].(map[string]interface{}); ok && len(purokData) > 0 {
		fmt.Println()
		fmt.Printf("  %s%s  Residents by Purok%s\n", b, y, rs)
		fmt.Println(divider)

		// Get sorted purok keys
		purokKeys := make([]string, 0, len(purokData))
		for k := range purokData {
			purokKeys = append(purokKeys, k)
		}
		sort.Strings(purokKeys)

		// Find max count to scale the bar chart
		maxPurok := 0.0
		for _, count := range purokData {
			if cv, ok := count.(float64); ok && cv > maxPurok {
				maxPurok = cv
			}
		}

		for _, purok := range purokKeys {
			countVal := 0.0
			if cv, ok := purokData[purok].(float64); ok {
				countVal = cv
			}
			bar := renderBar(countVal, maxPurok, 40)
			fmt.Printf("    Purok %-4s %s %s%4.0f%s\n", purok, bar, w, countVal, rs)
		}
	}

	// Age distribution
	if ageData, ok := stats["age_groups"].(map[string]interface{}); ok && len(ageData) > 0 {
		fmt.Println()
		fmt.Printf("  %s%s  Age Distribution%s\n", b, y, rs)
		fmt.Println(dividerAge)

		// Defined order to keep age groups chronological
		ageOrder := []string{
			"0-5 (Infant/Toddler)",
			"6-12 (Child)",
			"13-17 (Teen)",
			"18-30 (Young Adult)",
			"31-59 (Adult)",
			"60+ (Senior)",
			"Unknown",
		}

		// Find max age count to scale
		maxAge := 0.0
		for _, count := range ageData {
			if cv, ok := count.(float64); ok && cv > maxAge {
				maxAge = cv
			}
		}

		for _, group := range ageOrder {
			if count, exists := ageData[group]; exists {
				countVal := 0.0
				if cv, ok := count.(float64); ok {
					countVal = cv
				}
				bar := renderBar(countVal, maxAge, 40)
				fmt.Printf("    %-24s %s %s%4.0f%s\n", group, bar, w, countVal, rs)
			}
		}
	}

	fmt.Println(dividerAge)
}

func renderBar(value, total float64, width int) string {
	if total == 0 {
		return strings.Repeat("░", width)
	}
	filled := int((value / total) * float64(width))
	if filled > width {
		filled = width
	}
	return green() + strings.Repeat("█", filled) + dim() + strings.Repeat("░", width-filled) + reset()
}

func getFloat(m map[string]interface{}, key string) float64 {
	if v, ok := m[key]; ok {
		if f, ok := v.(float64); ok {
			return f
		}
	}
	return 0
}

func getStr(m map[string]interface{}, key string) string {
	if v, ok := m[key]; ok {
		if s, ok := v.(string); ok {
			return s
		}
	}
	return ""
}

func handleSearchResidents(projectDir string, reader *bufio.Reader) {
	fmt.Printf("  %s🔍 Enter search query%s %s(name, purok, or household #)%s: ", bold(), reset(), dim(), reset())
	query, _ := reader.ReadString('\n')
	query = strings.TrimSpace(query)

	if query == "" {
		printWarning("No query provided, returning to menu.")
		return
	}

	sp := newSpinner(fmt.Sprintf("Searching for \"%s\"...", query))
	sp.start()

	output, err := runCommandCapture(projectDir, "search", fmt.Sprintf("--query=%s", query), "--format=json")
	sp.stop(err == nil)

	if err != nil {
		printError("Search failed: " + err.Error())
		addHistory("Search: "+query, false)
		return
	}

	// Parse and display results
	var result map[string]interface{}
	if jsonErr := json.Unmarshal([]byte(output), &result); jsonErr != nil {
		fmt.Println(output)
		addHistory("Search: "+query, true)
		return
	}

	count := getFloat(result, "count")
	if count == 0 {
		printWarning(fmt.Sprintf("No results found for \"%s\"", query))
		addHistory("Search: "+query+" (0 results)", true)
		return
	}

	results, ok := result["results"].([]interface{})
	if !ok {
		fmt.Println(output)
		addHistory("Search: "+query, true)
		return
	}

	fmt.Printf("\n  %s%sFound %.0f result(s):%s\n\n", bold(), green(), count, reset())

	// Table header
	fmt.Printf("  %s%-5s %-30s %-5s %-8s %-8s %-12s%s\n",
		bold()+underline(), "ID", "Full Name", "Age", "Sex", "Purok", "Household #", reset())

	for _, r := range results {
		row, ok := r.(map[string]interface{})
		if !ok {
			continue
		}
		id := getFloat(row, "id")
		name := getStr(row, "full_name")
		age := getFloat(row, "age")
		sex := getStr(row, "sex")
		purok := getStr(row, "purok_no")
		hh := getStr(row, "household_no")

		ageStr := "-"
		if age > 0 {
			ageStr = fmt.Sprintf("%.0f", age)
		}

		fmt.Printf("  %-5.0f %-30s %-5s %-8s %-8s %-12s\n", id, name, ageStr, sex, purok, hh)
	}

	addHistory(fmt.Sprintf("Search: %s (%.0f results)", query, count), true)
}

func handleExportCSV(projectDir string, reader *bufio.Reader) {
	fmt.Printf("  %s📁 Export path%s %s(press Enter for default)%s: ", bold(), reset(), dim(), reset())
	file, _ := reader.ReadString('\n')
	file = strings.TrimSpace(file)

	args := []string{"export"}
	exportTarget := "default location"
	if file != "" {
		args = append(args, file)
		exportTarget = file
	}

	sp := newSpinner("Exporting residents to CSV...")
	sp.start()

	err := runCommand(projectDir, true, args...)
	sp.stop(err == nil)

	if err != nil {
		printError("Export failed.")
		addHistory("Export to "+exportTarget, false)
	} else {
		printSuccess("Export complete.")
		addHistory("Export to "+exportTarget, true)
	}
}

func handleImportCSV(projectDir string, reader *bufio.Reader) {
	fmt.Printf("  %s📄 Enter file path %s(.csv or .xlsx, press Enter for default 'RBI 2025 all.xlsx'):%s ", bold(), dim(), reset())
	file, _ := reader.ReadString('\n')
	file = strings.TrimSpace(file)

	if file == "" {
		// Scan projectDir for any .xlsx or .xls file (excluding temp files starting with ~$)
		pattern := filepath.Join(projectDir, "*")
		matches, _ := filepath.Glob(pattern)
		var targetFile string
		for _, m := range matches {
			base := filepath.Base(m)
			ext := strings.ToLower(filepath.Ext(m))
			if !strings.HasPrefix(base, "~$") && (ext == ".xlsx" || ext == ".xls") {
				targetFile = m
				break
			}
		}

		if targetFile != "" {
			file = targetFile
			printInfo("No file provided. Automatically using: " + filepath.Base(file))
		} else {
			printWarning("No file path provided, and no Excel (.xlsx/.xls) file was found in the project root folder. Returning to menu.")
			return
		}
	}

	// Check if file exists
	if _, err := os.Stat(file); os.IsNotExist(err) {
		printError(fmt.Sprintf("File not found: %s", file))
		return
	}

	printInfo(fmt.Sprintf("File: %s", file))

	if !confirmPrompt(reader, fmt.Sprintf("  %s%sImport this file?%s (y/n): ", bold(), yellow(), reset())) {
		printInfo("Import cancelled.")
		return
	}

	fmt.Println()
	err := runCommand(projectDir, true, "import", file)

	if err != nil {
		addHistory("Import: "+filepath.Base(file), false)
	} else {
		addHistory("Import: "+filepath.Base(file), true)
	}
}

func handleTruncateResidents(projectDir string, reader *bufio.Reader) {
	fmt.Printf("  %s%s⚠  WARNING: This will permanently delete ALL resident records.%s\n", bold(), red(), reset())

	if !confirmPrompt(reader, fmt.Sprintf("  %sType 'yes' to confirm: %s", yellow(), reset())) {
		printInfo("Aborted.")
		return
	}

	// Auto-backup
	performBackup(projectDir)

	err := runCommand(projectDir, true, "truncate")
	if err != nil {
		addHistory("Truncate Residents", false)
	} else {
		addHistory("Truncate Residents", true)
	}
}

func handleTruncateAll(projectDir string, reader *bufio.Reader) {
	fmt.Printf("  %s%s⚠  DANGER: This will permanently delete ALL residents AND households.%s\n", bold(), red(), reset())
	fmt.Printf("  %s%s   This action cannot be undone!%s\n", bold(), red(), reset())

	if !confirmPrompt(reader, fmt.Sprintf("  %sType 'yes' to confirm: %s", red(), reset())) {
		printInfo("Aborted.")
		return
	}

	// Double confirmation for destructive operation
	if !confirmPrompt(reader, fmt.Sprintf("  %s%sAre you ABSOLUTELY sure? Type 'yes' again: %s", bold(), red(), reset())) {
		printInfo("Aborted.")
		return
	}

	// Auto-backup
	performBackup(projectDir)

	err := runCommand(projectDir, true, "truncate", "--all")
	if err != nil {
		addHistory("Truncate All", false)
	} else {
		addHistory("Truncate All", true)
	}
}

func handleDeleteRows(projectDir string, reader *bufio.Reader) {
	fmt.Printf("  %sTable name%s %s(e.g. residents, households)%s: ", bold(), reset(), dim(), reset())
	table, _ := reader.ReadString('\n')
	table = strings.TrimSpace(table)
	if table == "" {
		printWarning("Table name required.")
		return
	}

	fmt.Printf("  %sWhere clause%s %s(column=value, e.g. purok_no=3)%s: ", bold(), reset(), dim(), reset())
	where, _ := reader.ReadString('\n')
	where = strings.TrimSpace(where)
	if where == "" {
		printWarning("Where clause required.")
		return
	}

	if !strings.Contains(where, "=") {
		printError("Invalid where clause. Use column=value format.")
		return
	}

	fmt.Printf("\n  %sWill delete from %s%s%s where %s%s%s%s\n",
		dim(), bold()+white(), table, reset()+dim(), bold()+white(), where, reset()+dim(), reset())

	if !confirmPrompt(reader, fmt.Sprintf("  %sContinue? (y/n): %s", yellow(), reset())) {
		printInfo("Aborted.")
		return
	}

	err := runCommand(projectDir, true, "delete", fmt.Sprintf("--table=%s", table), fmt.Sprintf("--where=%s", where))
	desc := fmt.Sprintf("Delete from %s where %s", table, where)
	if err != nil {
		addHistory(desc, false)
	} else {
		addHistory(desc, true)
	}
}

func handleCacheClear(projectDir string) {
	sp := newSpinner("Clearing application cache...")
	sp.start()

	err := runCommand(projectDir, true, "cache-clear")
	sp.stop(err == nil)

	if err != nil {
		addHistory("Clear Cache", false)
	} else {
		addHistory("Clear Cache", true)
	}
}

func handleShowHistory() {
	historyMutex.Lock()
	defer historyMutex.Unlock()

	if len(cmdHistory) == 0 {
		printInfo("No commands run yet this session.")
		return
	}

	fmt.Printf("  %s%s📋 Recent Commands%s\n\n", bold(), cyan(), reset())

	for i, entry := range cmdHistory {
		status := green() + "✓" + reset()
		if !entry.ok {
			status = red() + "✗" + reset()
		}
		timeStr := entry.time.Format("15:04:05")
		fmt.Printf("    %s %s%d.%s %s  %s%s%s\n", status, dim(), i+1, reset(), entry.action, dim(), timeStr, reset())
	}
}

func handleHelp() {
	b := bold()
	c := cyan()
	d := dim()
	w := white()
	rs := reset()

	fmt.Printf("  %s%s══════════════════════════════════════════════════%s\n", b, c, rs)
	fmt.Printf("  %s%s  📖 RBI Manager Help%s\n", b, c, rs)
	fmt.Printf("  %s%s══════════════════════════════════════════════════%s\n\n", b, c, rs)

	fmt.Printf("  %s%s1) View Statistics%s\n", b, w, rs)
	fmt.Printf("     %sShows a dashboard with total residents, households, gender%s\n", d, rs)
	fmt.Printf("     %sbreakdown, per-purok counts, and age distribution.%s\n\n", d, rs)

	fmt.Printf("  %s%s2) Search Residents%s\n", b, w, rs)
	fmt.Printf("     %sSearch by first name, last name, middle name, purok number,%s\n", d, rs)
	fmt.Printf("     %sor household number. Returns up to 50 results in a table.%s\n\n", d, rs)

	fmt.Printf("  %s%s3) Export to CSV%s\n", b, w, rs)
	fmt.Printf("     %sExport all residents with household info to a CSV file.%s\n", d, rs)
	fmt.Printf("     %sDefaults to storage/app/exports/ if no path given.%s\n\n", d, rs)

	fmt.Printf("  %s%s4) Import CSV / XLSX File%s\n", b, w, rs)
	fmt.Printf("     %sProvide a path to a .csv or .xlsx file. Columns are mapped%s\n", d, rs)
	fmt.Printf("     %sby header names (lowercased). For XLSX files with multiple%s\n", d, rs)
	fmt.Printf("     %ssheets, you can choose which sheet to import.%s\n\n", d, rs)

	fmt.Printf("  %s%s5) Truncate Residents%s\n", b, w, rs)
	fmt.Printf("     %sDeletes all records from the residents table.%s\n", d, rs)
	fmt.Printf("     %sA CSV backup is automatically created before deletion.%s\n\n", d, rs)

	fmt.Printf("  %s%s6) Truncate All%s\n", b, w, rs)
	fmt.Printf("     %sDeletes all residents AND households. Requires double%s\n", d, rs)
	fmt.Printf("     %sconfirmation. A backup is created automatically.%s\n\n", d, rs)

	fmt.Printf("  %s%s7) Delete Rows by Condition%s\n", b, w, rs)
	fmt.Printf("     %sPrompts for a table name and a where clause (column=value).%s\n", d, rs)
	fmt.Printf("     %sPerforms a targeted delete query on the specified table.%s\n\n", d, rs)

	fmt.Printf("  %s%s8) Clear Application Cache%s\n", b, w, rs)
	fmt.Printf("     %sFlushes all Laravel caches (config, route, view, app)%s\n", d, rs)
	fmt.Printf("     %sand restarts queue workers.%s\n\n", d, rs)

	fmt.Printf("  %s%sCLI Usage:%s\n", b, c, rs)
	fmt.Printf("     %srbi-manager.exe                    %s— Interactive menu%s\n", w, d, rs)
	fmt.Printf("     %srbi-manager.exe stats              %s— Print stats%s\n", w, d, rs)
	fmt.Printf("     %srbi-manager.exe import file.xlsx   %s— Import CSV/XLSX%s\n", w, d, rs)
	fmt.Printf("     %srbi-manager.exe search --query=X   %s— Search%s\n", w, d, rs)
	fmt.Printf("     %srbi-manager.exe export             %s— Export CSV%s\n", w, d, rs)
	fmt.Printf("     %srbi-manager.exe --no-color         %s— Disable colors%s\n", w, d, rs)
}

// ─── Auto-Backup ────────────────────────────────────────────────────────────

func performBackup(projectDir string) {
	printInfo("Creating automatic backup before destructive operation...")
	sp := newSpinner("Backing up data to CSV...")
	sp.start()

	_, err := runCommandCapture(projectDir, "export")
	sp.stop(err == nil)

	if err != nil {
		printWarning("Backup may have failed. Proceeding anyway...")
	} else {
		printSuccess("Backup saved to storage/app/exports/")
	}
}

// ─── Confirmation ───────────────────────────────────────────────────────────

func confirmPrompt(r *bufio.Reader, prompt string) bool {
	fmt.Print(prompt)
	ans, _ := r.ReadString('\n')
	ans = strings.TrimSpace(strings.ToLower(ans))
	return ans == "y" || ans == "yes"
}

// ─── Command Execution ─────────────────────────────────────────────────────

// runCommand executes php artisan rbi:manage with the given args.
// If silent is true, output goes to /dev/null (used when we capture separately).
// Returns an error if the command failed.
func runCommand(projectDir string, passthrough bool, args ...string) error {
	cmdArgs := append([]string{"artisan", "rbi:manage"}, args...)
	cmd := exec.Command("php", cmdArgs...)
	cmd.Dir = projectDir

	if passthrough {
		cmd.Stdout = os.Stdout
		cmd.Stderr = os.Stderr
		cmd.Stdin = os.Stdin
	} else {
		// When not passthrough, discard output
		cmd.Stdin = os.Stdin
	}

	if err := cmd.Run(); err != nil {
		if exitErr, ok := err.(*exec.ExitError); ok {
			// For non-interactive mode, propagate exit code
			if !passthrough {
				if status := exitErr.ExitCode(); status >= 0 {
					os.Exit(status)
				}
			}
		}
		return err
	}
	return nil
}

// runCommandCapture runs the artisan command and captures stdout as a string.
func runCommandCapture(projectDir string, args ...string) (string, error) {
	cmdArgs := append([]string{"artisan", "rbi:manage"}, args...)
	cmd := exec.Command("php", cmdArgs...)
	cmd.Dir = projectDir
	cmd.Stderr = os.Stderr

	// On Windows, hide the console window for background commands
	if runtime.GOOS == "windows" {
		cmd.SysProcAttr = &syscall.SysProcAttr{HideWindow: true}
	}

	out, err := cmd.Output()
	if err != nil {
		return "", err
	}
	return strings.TrimSpace(string(out)), nil
}

func authenticateUser(projectDir string) bool {
	reader := bufio.NewReader(os.Stdin)
	b := bold()
	c := cyan()
	y := yellow()
	r := red()
	g := green()
	rs := reset()

	fmt.Printf("  %s%s🔑 Authentication Required%s\n", b, c, rs)
	fmt.Printf("  %s%s──────────────────────────────────────────────────%s\n", b, c, rs)

	for attempt := 1; attempt <= 3; attempt++ {
		fmt.Printf("   Email: ")
		email, _ := reader.ReadString('\n')
		email = strings.TrimSpace(email)

		fmt.Printf("   Password: ")
		password, err := readPassword()
		fmt.Println() // print newline since echo was disabled

		if err != nil {
			fmt.Printf("  %sError reading password: %s%s\n\n", r, err.Error(), rs)
			continue
		}

		if email == "" || password == "" {
			fmt.Printf("  %sEmail and password cannot be empty. (%d/3)%s\n\n", y, attempt, rs)
			continue
		}

		sp := newSpinner("Verifying credentials...")
		sp.start()

		// Run PHP artisan rbi:manage auth --email="..." --password="..."
		_, err = runCommandCapture(projectDir, "auth", "--email="+email, "--password="+password)
		sp.stop(err == nil)

		if err != nil {
			fmt.Printf("  %sInvalid credentials or unauthorized role. (%d/3)%s\n\n", r, attempt, rs)
		} else {
			fmt.Printf("  %sAccess Granted. Welcome back!%s\n\n", g, rs)
			time.Sleep(600 * time.Millisecond) // short pause to let the user see the success message
			clearScreen()
			return true
		}
	}

	fmt.Printf("  %sToo many failed attempts. Exiting.%s\n\n", r, rs)
	return false
}

func readPassword() (string, error) {
	if runtime.GOOS == "windows" {
		msvcrt := syscall.NewLazyDLL("msvcrt.dll")
		procGetch := msvcrt.NewProc("_getch")

		var password []byte
		for {
			r, _, _ := procGetch.Call()
			char := byte(r)

			if char == 13 || char == 10 { // Enter key (CR or LF)
				break
			}
			if char == 8 { // Backspace
				if len(password) > 0 {
					password = password[:len(password)-1]
					// Erase last character on screen: backspace, space, backspace
					fmt.Print("\b \b")
				}
			} else if char == 3 { // Ctrl+C
				fmt.Println()
				os.Exit(0)
			} else if char >= 32 && char <= 126 { // Printable ASCII characters
				password = append(password, char)
				fmt.Print("*")
			}
		}
		return string(password), nil
	}

	// Fallback for non-Windows (disable echo)
	// On non-Windows, we can use stty if available
	cmd := exec.Command("stty", "-echo")
	cmd.Stdin = os.Stdin
	_ = cmd.Run()

	defer func() {
		cmd := exec.Command("stty", "echo")
		cmd.Stdin = os.Stdin
		_ = cmd.Run()
	}()

	return readPasswordDefault()
}

func readPasswordDefault() (string, error) {
	reader := bufio.NewReader(os.Stdin)
	pass, err := reader.ReadString('\n')
	if err != nil {
		return "", err
	}
	return strings.TrimSpace(pass), nil
}

func clearScreen() {
	if runtime.GOOS == "windows" {
		cmd := exec.Command("cmd", "/c", "cls")
		cmd.Stdout = os.Stdout
		_ = cmd.Run()
	} else {
		fmt.Print("\033[H\033[2J")
	}
}
