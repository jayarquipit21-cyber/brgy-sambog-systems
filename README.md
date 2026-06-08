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

## 🧰 RBI Manager CLI wrappers

This repository includes simple executable wrappers that forward commands to the built-in Artisan command `rbi:manage` for importing CSVs and managing RBI data.

- Windows batch: `rbi-manager.bat`
- PowerShell: `rbi-manager.ps1`
- POSIX shell: `rbi-manager` (make executable with `chmod +x rbi-manager`)

Examples:

```powershell
.\rbi-manager.bat import data/rbi.csv
.\rbi-manager.ps1 truncate --all
```

```bash
./rbi-manager import path/to/file.csv
./rbi-manager delete --table=residents --where="purok_no=3"
```

The wrappers assume `php` is in your PATH and will run the project's `artisan` command from the repository root. Use with caution for destructive operations and back up your database first.

### Optional: native executable (Go)

If you'd like a single native executable (for Windows `.exe`), there's a small Go program included at `tools/rbi-manager/main.go` that forwards arguments to `php artisan rbi:manage`.

Build instructions (requires Go installed):

```bash
cd tools/rbi-manager
go build -o rbi-manager.exe main.go
```

Place the built `rbi-manager.exe` in the project root and run:

```powershell
.\rbi-manager.exe import data/rbi.csv
```

You can also build cross-platform binaries using Go's `GOOS`/`GOARCH` environment variables. The program accepts an optional `--project-dir <path>` flag to point to the Laravel project if the executable is stored elsewhere.

### CSV Schema (Export / Import)

The `rbi:manage export` and `rbi:manage import` commands work with a CSV containing household + resident columns. The exported header includes the following fields (in this order):

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

When importing, columns that are empty will be treated as `NULL`. The importer will create households (by `household_no` + `purok_no`) as needed and associate residents with the created household. Back up your database before running destructive operations like `truncate`.


