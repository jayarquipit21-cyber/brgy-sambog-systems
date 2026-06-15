🏛️ Barangay Sambog — Inhabitant Management System

A modern, web-based management system built for Barangay Sambog to digitize, secure, and streamline inhabitant records, household data, public health monitoring, local directory, and document pickup scheduling.

---

## 📋 Overview

This platform replaces traditional manual paper-based barangay administration with a secure, role-based digital system. Powered by **Laravel 12**, **Livewire v4**, and **Flux UI**, it enables Barangay Officials to manage the Record of Barangay Inhabitants (RBI), map household demographics across Purok zones, monitor community vaccination/health metrics, publish announcements, highlight community places, and schedule certificate/clearance collections.

---

## 👥 User Roles & Access Control

The system implements strict role-based access control (RBAC) to ensure resident data privacy:

| Role | Description & Access Rights |
| :--- | :--- |
| **Barangay Administrator (`admin`)** | Full read/write access to all resources: resident files, household structures, announcements, local directory, appointment queues, and blackout date settings. |
| **Public Health Officer (`health_admin`)** | View and update health monitoring profiles, vaccination stats, and vulnerable groups. Strict privacy scopes ensure private financial (income) and voter data are omitted from their queries. |
| **Household Head (`household_head`)** | Manage their own household profile and register/update members. Can book and track document pickup appointments. |
| **Resident Inhabitant (`resident`)** | Access personal profile dashboard and schedule document pickup appointments. |

---

## ✨ Features

### 1. Inhabitants Registry (RBI)
- **Searchable & Filterable Directory**: Quick lookup by name, age, sex, civil status, and educational status.
- **Purok Demographics**: Visual population distribution stats and listings sorted by Purok zones (Purok 1 to 7).

### 2. Household Management
- **Structured Households**: Organize residences using unique household numbers (`household_no`) and Purok assignments.
- **Member Directory**: Household heads can dynamically update member lists, register births, and declare relationships.

### 3. Public Health Module
- **Health Indicators**: Track chronic conditions, nutritional classifications, and vulnerable sectors (Seniors, PWD, Pregnant, etc.).
- **Vaccination Tracker**: Record COVID-19 vaccination status (Dose 1, Dose 2, boosters, vaccine brands) and PhilHealth membership details.
- **Pediatric & Senior Case Load Counters**: Specialized counters for health admins to monitor high-risk demographics.

### 4. Appointment & Clearance Scheduler
- **Appointment Booking**: Inhabitants can select preferred dates and times for document pickups (e.g., Barangay Clearance, Certificate of Indigency).
- **Date Closures**: Admins can declare "blackout dates" (e.g., national holidays, staff training days) to prevent scheduling on closed days.
- **Validation Rules**: Prevents weekend bookings, past date choices, or overlapping slots.

### 5. Community Announcements
- **Announcements Feed**: Dynamic board displaying general, health, and emergency advisories.
- **Pinned Announcements**: Admins can pin important updates to the top of the resident dashboards.

### 6. Recommended Places Directory
- **Local Attractions**: Showcases community spots, landmarks, and utility offices.
- **Purok Categorization**: Groups recommended places by Purok zone.

---

## 🛠️ Tech Stack

- **Backend Framework**: Laravel 12+
- **Frontend Interactivity**: Livewire v4
- **UI Components**: [Flux UI](https://fluxui.dev/) (livewire/flux v2)
- **Styling**: Tailwind CSS v4 with full light and dark mode capability
- **Authentication**: Laravel Fortify (supports secure session auth, Passkeys, and Two-Factor Authentication)
- **Database**: SQLite (Local development) / MySQL or PostgreSQL (Production)
- **Build System**: Vite

---

## 📁 Database Schema

The database consists of the following key tables:

- **`users`**: Manages credentials, roles (`admin`, `health_admin`, `household_head`, `resident`), and 2FA credentials.
- **`households`**: Stores household identifiers, address details, and geographic Purok zoning information.
- **`residents`**: Contains detailed personal, educational, employment, voter status, and health indicators for each resident.
- **`appointments`**: Handles scheduled document clearances, statuses (`pending`, `approved`, `completed`, `cancelled`), and admin notes.
- **`appointment_date_closures`**: Blacklisted calendar dates on which appointments cannot be booked.
- **`places`**: Geographic directory of local landmarks, utility buildings, and recommended spots.
- **`announcements`**: Broadcasted news, alerts, and emergency updates published by administrators.

---

## 🚀 Getting Started

### Requirements
- **PHP 8.3+**
- **Composer**
- **Node.js 20+** & **npm**
- **SQLite** (or MySQL)

### Installation
1. **Clone the repository**
   ```bash
   git clone https://github.com/jayarquipit21-cyber/brgy-sambog-systems.git
   cd brgy-sambog-systems
   ```

2. **Install PHP and JS Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run Database Migrations & Seeds**
   ```bash
   php artisan migrate --seed
   ```

5. **Build Frontend Assets**
   ```bash
   npm run build
   ```

6. **Run Locally**
   ```bash
   composer run dev
   ```
   *This starts the Laravel local server, background queues, and Vite asset compiler concurrently.*

---

## 🔒 Security & Privacy Compliance

This system handles sensitive resident data protected under the **Philippine Data Privacy Act of 2012 (RA 10173)**. 

- **Data Minimization**: SQL queries within the health officer dashboard strictly scope out highly private fields (e.g., `income`, `registered_national_voter`) using Eloquent selections.
- **Local Safety**: Never commit local database files (`.sqlite`), environment files (`.env`), or actual spreadsheet records containing real inhabitant data. Use synthetic data for testing.

## 🧰 Dedicated RBI Manager App

Rather than running complex terminal commands, this repository includes a dedicated, interactive desktop/terminal management application called **RBI Manager** (`tools/rbi-manager.exe` or `tools/rbi-manager/main.go`). It provides a clean, menu-driven interface to completely manage the inhabitant database.

### 💻 How to Open the App
You can launch the dedicated application directly:

* **Windows**: Double-click **`tools/rbi-manager.exe`** in your file manager.
* **Linux / macOS**: Run `./rbi-manager` in the project root folder (make executable first with `chmod +x rbi-manager`).

### 🔑 Authentication
The app requires an account with administrative or health officer privileges to secure sensitive resident records:
* **Username (Email)**: `admin@barangay.gov` (or `health@barangay.gov`)
* **Password**: `password`

---

### 📥 Importing the Updated Excel Files
There are two ways to import your registry spreadsheet:

#### ⚡ Quickest — Drag & Drop
Simply **drag your `.xlsx` / `.xls` / `.csv` file** from Windows Explorer and **drop it onto `tools/rbi-manager.exe`**. The app will:
1. Open automatically and show the file name.
2. Ask you to log in.
3. Start the import right away — no menu navigation needed.
4. Display the import results and wait for you to press Enter before closing.

#### 🖱️ Via the Interactive Menu
1. Place your spreadsheet file (any `.xlsx` or `.xls` file) in the project root folder.
2. Launch the **RBI Manager** app (`tools/rbi-manager.exe`).
3. Select option **`4) Import CSV / XLSX File`** from the interactive menu.
4. Press **Enter** (leave the path empty) — the app will auto-detect the Excel file in the project root. Or type a custom file path.
5. If the file contains multiple sheets (e.g., sheets for Purok 1 to Purok 8), the app lists them and lets you select a sheet or type `all` to import everything.

---

### 📊 App Features
Once logged in, the interactive menu offers the following options:
* **1) View Statistics**: Visualizes live population statistics, household counts, gender distribution, and graphical age/Purok population distributions directly in the terminal.
* **2) Search Residents**: Instantly lookup resident records by name, Purok, or household number.
* **3) Export to CSV**: Downloads the live registry into a CSV spreadsheet stored at `storage/app/exports/`.
* **4) Import CSV / XLSX File**: Reads and imports custom or default registry files.
* **5) Truncate Residents**: Cleans out resident records safely (automatically creates a backup beforehand).
* **6) Truncate All**: Cleans out both household and resident tables (with automatic backup).
* **7) Delete Rows by Condition**: Deletes records selectively based on criteria (e.g., clearing a specific Purok).
* **8) Clear Application Cache**: Flushes system caches and restarts workers to synchronize database changes with the web dashboard immediately.

---

### CSV Schema (Export / Import)

The import and export features expect or generate a spreadsheet with the following header layout (in order):

- id, household_no, purok_no, address, user_id, created_at, updated_at,
- population_no, family_no, relationship_to_head, is_house_owner, is_renter, renter_months,
- last_name, first_name, middle_name, extension, birthdate, place_of_birth, sex, gender_identity, civil_status,
- religion, citizenship, age, age_classification, blood_type, height, weight, complexion, mobile_number, email_address, social_media_account,
- educational_status, highest_educational_attainment, school_attended, course_completed, eligibility,
- primary_skills, secondary_skills, other_skills, work_status, occupation, is_farmer, income, days_work_per_week, last_period_of_unemployment, reason_of_unemployment,
- registered_sk_voter, registered_national_voter, attended_kk_assembly, kk_assembly_times, kk_assembly_no_reason,
- resident_voter, last_voted_year, has_philhealth, philhealth_id, philhealth_membership_type,
- unvaccinated, partially_vaccinated, fully_vaccinated, covid_dose_1_date, covid_dose_2_date, covid_brand, has_booster, booster_date, booster_brand,
- health_condition, nutritional_classification, vulnerable_sector, social_welfare_availed,
- water_source, sanitary_toilet, waste_management, has_blind_drainage

Empty columns will be treated as `NULL`. Back up your data before performing destructive operations.


