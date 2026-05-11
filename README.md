# 📊 DataBazaar

DataBazaar is a modern, premium Market Databank Generation and Sharing Platform built with the Laravel framework. It empowers users to submit, explore, and analyze market pricing data across various locations with real-time visualizations and a sophisticated administrative moderation workflow.

![DataBazaar Hero](https://via.placeholder.com/1200x600.png?text=DataBazaar+Market+Intelligence+Platform)

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

### 🌗 Premium UI/UX
- **Glassmorphism Design**: Modern, translucent interface elements with smooth transitions.
- **Global Dark Mode**: A unified theme store that syncs preferences across the entire application (including mobile).
- **Responsive Layout**: A mobile-first design approach ensuring full functionality on all devices.
- **Inter Typography**: Uses the professional Inter typeface for maximum readability.

---

## 🛠️ Tech Stack
- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Tailwind CSS 4.0, Alpine.js 3.x
- **Database**: SQLite (Dev) / MySQL or PostgreSQL (Prod)
- **Charts**: Chart.js 4.x
- **Icons**: Heroicons
- **Asset Bundling**: Vite 7.x

---

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM

### Setup Steps
1. **Clone the Repository**
   ```bash
   git clone https://github.com/yourusername/databazaar.git
   cd databazaar
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. **Build Assets**
   ```bash
   npm run build
   ```

6. **Start the Application**
   ```bash
   php artisan serve
   ```

---

## 📖 Usage Guide

### 1. Contributing Data
Navigate to the **Submit** tab. You can either fill out the individual form for a single observation or use the **Upload CSV** feature for bulk data. All data submitted will appear as "Pending" until an administrator approves it.

### 2. Exploring Market Insights
Use the **Explore** tab to browse approved market data. Use the filters in the header to narrow down by category (e.g., Grains, Vegetables) or specific cities (e.g., Delhi, Mumbai).

### 3. Bookmarking & Sharing
If you find a valuable data point, click the **Bookmark** icon. You can view all saved items in your Bookmarks tab. To share data, click the **Share** icon to generate a unique public link.

### 4. Admin Moderation
Admins can access the **Admin Panel** via the navigation bar. From there, go to **Data Moderation** to review submissions. Click **Approve** to publish them to the platform.

---

## 📜 License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

Built with ❤️ by the DataBazaar Team.
