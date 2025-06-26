# Hospital Management System (HMS) Project

## Overview

The Hospital Management System (HMS) is a web-based application developed using PHP and MySQL. It allows administrators, doctors, and patients to manage appointments, schedules, and personal information efficiently.

## Features

### Admin

- Add, edit, and delete doctors
- Schedule new doctor sessions and remove sessions
- View patient details
- View patient bookings

### Doctors

- View their appointments
- View their scheduled sessions
- View patient details
- Delete account
- Edit account settings

### Patients (Clients)

- Make appointments online
- Create accounts themselves
- View their old bookings
- Delete account
- Edit account settings

## Dashboards
 Admins:
- **1000000000** | Password: `123` | Role: `admin`
- **1100000000** | Password: `456` | Role: `super_admin`

 Doctors:
- **2000000000** | Password: `123`
- **2200000000** | Password: `123

 Patients:
- **3000000000** | Password: `123`
- **3300000000** | Password: `123`


## Database Schema

The database schema includes the following tables:

- `admin`: Stores admin user information
- `appointment`: Stores appointment details
- `doctor`: Stores doctor information
- `patient`: Stores patient information
- `schedule`: Stores scheduling information
- `specialties`: Stores medical specialties
- `webuser`: Stores general user information

## Installation

1. Clone the repository to your local machine.
2. Import the `hospital.sql` file into your MySQL database.
3. Update the database connection settings in `connection.php`.
4. Start your web server and navigate to `http://localhost/HMS`.

## Usage

1. Log in using the provided credentials for admin, doctor, or patient.
2. Use the respective dashboards to manage appointments, schedules, and personal information.

