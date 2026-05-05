# 📊 DataBazaar

DataBazaar is a modern, premium Market Databank Generation and Sharing Platform built with the Laravel framework. It empowers users to submit, explore, and analyze market pricing data across various locations with real-time visualizations and a sophisticated administrative moderation workflow.



## 🚀 Features

### For Users
- **Modern Dashboard**: Real-time stats and personalized price trend charts using Chart.js.
- **Market Explorer**: Advanced filtering and searching of market data by category, location, and date.
- **Interactive Visualizations**: Dynamic line and doughnut charts for price trends and category distributions.
- **Data Contribution**: Seamlessly submit new market insights with automated validation.
- **Bulk Import**: Support for CSV bulk uploads for large-scale data entry.
- **Favorites & Bookmarks**: Save specific data entries for quick access later.
- **Public Sharing**: Generate secure, unique tokens to share specific data insights publicly.
- **Dark Mode**: Premium dark mode support with system preference detection.

### For Admins
- **Moderation Panel**: Centralized control center to approve or reject user submissions.
- **User Management**: Comprehensive tools to manage user roles, block/unblock users, and monitor activity.
- **Platform Analytics**: High-level overview of submission trends and category health.

## 🛠️ Tech Stack

- **Backend**: Laravel 12.x (PHP 8.2+)
- **Database**: MySQL / PostgreSQL
- **Frontend**: Tailwind CSS (Modern SaaS Design System)
- **Interactivity**: Alpine.js
- **Charts**: Chart.js 4.x
- **Authentication**: Laravel Breeze (Customized)

## 📦 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/DataBazaar.git
   cd DataBazaar
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   Configure your database settings in the `.env` file, then run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

5. **Build Assets**
   ```bash
   npm run build
   ```

6. **Start the Server**
   ```bash
   php artisan serve
   ```

## 🔐 Credentials (Seed Data)

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@databazaar.com | password |
| **User** | user@databazaar.com | password |

## 📄 License

The DataBazaar platform is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
