# NSBM SportsHub

A sports club management system for the Web and Mobile Application Development final project (Topic 3). It uses **HTML, CSS, JavaScript, PHP and MySQL**, with Bootstrap 5 for responsive UI components.

## Included features

### Public
- Homepage with live club and fixture information
- Club search and sport filtering
- Club details and related training/fixtures
- Upcoming match fixtures
- Results and simple standings

### Student
- Registration, secure login and logout
- Request club membership
- View training schedules from approved clubs
- Register for tournaments and matches
- Withdraw event registrations
- Request facilities/equipment and cancel bookings
- View personal participation history

### Administrator
- Dashboard with pending work and key counts
- Full CRUD for clubs, training sessions, tournaments, matches and resources
- Approve/reject club memberships
- Record match scores and update match status
- Approve/reject booking requests with conflict checks
- Participation and performance reports
- Download club/student participation reports as CSV

## Technology and security

- PHP 8.1+ with PDO prepared statements
- MySQL 8 or MariaDB 10.6+
- `password_hash()` and `password_verify()` for passwords
- Session regeneration after login and basic login throttling
- CSRF tokens on state-changing forms
- Server-side validation and escaped HTML output
- Foreign keys and unique constraints in MySQL
- Bootstrap client-side validation as an additional layer

## Run with XAMPP (beginner-friendly)

1. Copy this folder into `xampp/htdocs/sportshub`.
2. Start **Apache** and **MySQL** in XAMPP.
3. Open `http://localhost/phpmyadmin` and import `database/sportshub.sql`.
4. The SQL creates the `sportshub` database, tables and sample data.
5. If your MySQL details are not `root` with no password, update `config/database.php` or set the environment variables shown in `.env.example`.
6. Open `http://localhost/sportshub/`.

### Demo accounts

| Role | Email | Password |
| --- | --- | --- |
| Student | `student@nsbm.lk` | `Student@123` |
| Admin | `admin@nsbm.lk` | `Admin@123` |

Change or remove demo accounts before a real production deployment.

## Run with Docker

Docker Compose runs Apache/PHP and MariaDB in one demo container and keeps database data in a named volume.

```bash
docker compose up --build
```

Open `http://localhost:8080`. To stop, press Ctrl+C. To remove the demo database volume as well:

```bash
docker compose down -v
```

The Dockerfile listens on port `3000` inside the container for platform compatibility. For normal shared PHP hosting, use the XAMPP/phpMyAdmin steps instead; Docker is not required.

## Deploy to PHP/MySQL shared hosting

1. Create a MySQL database and database user in the hosting control panel.
2. Import `database/sportshub.sql` using the host's phpMyAdmin. If the host does not allow `CREATE DATABASE`, remove those two statements and select the created database before importing.
3. Upload all project files to `public_html` (or a subfolder).
4. Set `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER` and `DB_PASS` in the hosting environment, or update the defaults in `config/database.php` locally before upload. Do not commit real passwords.
5. Test registration, login, admin CRUD and student requests over HTTPS.
6. Put the public URL in your project report. The preview supplied with this source is not a public deployment.

## Project structure

```text
admin/                 Admin dashboard and management pages
student/               Student dashboard and personal features
assets/css/            Custom responsive styling
assets/js/             Validation and confirmation behaviour
config/                PDO database connection
includes/              Sessions, authentication, helpers and layout
database/sportshub.sql Database schema and demo records
index.php              Public homepage
clubs.php              Club search/listing
fixtures.php           Upcoming fixtures
results.php            Results and standings
Dockerfile             Demo container build
CONTRIBUTING.md        Six-member GitHub workflow
```

## Team testing checklist

- Register a new student and log in.
- Request a club; approve it as admin; confirm training appears for the student.
- Create and edit a club, training session, tournament and match.
- Register for an event and verify it in participation history.
- Request a resource and approve/reject it as admin.
- Enter a score and check the public results/standings page.
- Download both CSV reports.
- Test at mobile and desktop widths.

## Third-party resources

- Bootstrap 5.3.3 (MIT) via jsDelivr
- Barlow Condensed (SIL Open Font License) and Inter (SIL Open Font License) via Google Fonts
- All SportsHub PHP, CSS, JavaScript and inline SVG illustrations were created for this project
