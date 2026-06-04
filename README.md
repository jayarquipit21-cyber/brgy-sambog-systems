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
