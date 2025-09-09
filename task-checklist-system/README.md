# TaskCheck - Flexible Task & Checklist Management System

A complete Laravel web application for managing tasks and checklists across any industry - cleaning, healthcare, logistics, retail, construction, and more.

## 🚀 Features

### Core Features
- **Role-based Access Control**: Admin (Manager) and Employee roles
- **Flexible Task Lists**: Create reusable templates and checklists
- **Sub-lists Support**: Organize complex workflows with nested lists
- **Rich Task Types**: Support for different proof types (photo, video, text, file)
- **Digital Signatures**: Optional signature requirements for compliance
- **Mobile-Friendly**: Responsive design works on all devices
- **API Ready**: REST endpoints for mobile app integration

### Admin (Manager) Features
- 📊 **Analytics Dashboard**: View completion rates, employee performance
- 📝 **Task List Management**: Create, edit, and organize checklists
- 👥 **Assignment System**: Assign lists to users, departments, or roles
- ✅ **Review System**: Approve or reject completed tasks with feedback
- 📈 **Reporting**: Track progress and identify improvement areas
- ⚙️ **User Management**: Manage employee accounts and permissions

### Employee Features
- 📱 **Mobile Dashboard**: View assigned tasks for today
- ✅ **Step-by-Step Completion**: Complete tasks with required proof
- 📸 **Media Upload**: Upload photos, videos, or files as proof
- ✍️ **Digital Signatures**: Sign off on completed checklists
- 🎉 **Celebration Popup**: Motivational feedback on completion
- 📊 **Progress Tracking**: See completion status in real-time

### Advanced Features
- 🔄 **Scheduling**: Daily, weekly, monthly, and custom recurring schedules
- 🏷️ **Categorization**: Organize lists by department, project, or type
- 🚨 **Priority System**: Urgent, high, medium, and low priority tasks
- 🌍 **Multilingual Ready**: Prepared for multiple language support
- 📱 **Offline Support**: (Coming soon) Work without internet connection
- 📊 **Analytics**: Comprehensive reporting and insights

## 🛠 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and NPM
- SQLite/MySQL/PostgreSQL

### Quick Setup

1. **Clone the repository**
```bash
git clone <repository-url>
cd task-checklist-system
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database setup**
```bash
php artisan migrate
php artisan db:seed
```

5. **Build assets**
```bash
npm run build
```

6. **Start the server**
```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## 👤 Default Login Credentials

### Admin Account
- **Email**: admin@example.com
- **Password**: password

### Employee Accounts
- **Email**: employee@example.com / **Password**: password
- **Email**: jane@example.com / **Password**: password

## 📖 Usage Guide

### For Admins

1. **Creating Task Lists**
   - Go to Admin Dashboard → Task Lists → Create New List
   - Add title, description, priority, and schedule type
   - Set up recurring schedules if needed
   - Save as template for reuse

2. **Adding Tasks to Lists**
   - Open a task list → Add Tasks
   - Set task title, description, and instructions
   - Choose required proof type (photo, video, text, file)
   - Set order and requirements

3. **Assigning Lists**
   - Individual assignment: Select specific employees
   - Department assignment: Assign to entire departments
   - Role-based assignment: Assign to all employees with specific roles

4. **Reviewing Submissions**
   - Dashboard shows pending submissions
   - Review each task individually
   - Approve ✅ or reject ❌ with comments
   - Track completion rates and performance

### For Employees

1. **Daily Workflow**
   - Login to see today's assigned tasks
   - Click "Start Checklist" to begin
   - Complete tasks step by step
   - Upload required proof (photos/videos/files)
   - Add notes where needed

2. **Completing Tasks**
   - Tasks must be completed in order
   - Required tasks must have proof uploaded
   - Save progress and continue later if needed
   - Submit for manager review when complete

3. **Digital Signatures**
   - If required, sign digitally before submission
   - Type your full name as confirmation
   - Add final notes about the checklist

## 🔌 API Endpoints

### Authentication
All API endpoints require Sanctum token authentication.

### Available Endpoints

```
GET /api/user - Get authenticated user info
GET /api/lists - Get assigned task lists
GET /api/lists/{id} - Get specific task list with tasks
GET /api/submissions - Get user's submissions
POST /api/submissions - Create new submission
GET /api/submissions/{id} - Get specific submission
PUT /api/submissions/{id} - Update submission
POST /api/submissions/{id}/complete - Complete submission
POST /api/submissions/{id}/tasks/{task} - Complete specific task
```

### Mobile App Integration
The API is designed for easy mobile app integration with:
- Token-based authentication
- JSON responses
- File upload support
- Offline sync capabilities (coming soon)

## 🏗 Database Schema

### Core Tables
- **users**: Admin and employee accounts
- **lists**: Task lists and checklists
- **tasks**: Individual tasks within lists
- **list_assignments**: Assignment relationships
- **submissions**: Employee checklist submissions
- **submission_tasks**: Individual task completions

### Key Relationships
- Users can have multiple assignments
- Lists can have sub-lists (parent-child relationship)
- Submissions track overall checklist progress
- Submission tasks track individual task completion

## 🎨 Customization

### Industry-Specific Templates
The system comes with sample templates for:
- **Cleaning**: Daily office cleaning, restroom maintenance
- **Safety**: Weekly safety inspections, equipment checks
- **Healthcare**: Patient care checklists, sanitation protocols
- **Retail**: Opening/closing procedures, inventory checks
- **Construction**: Safety inspections, quality checks

### Adding Custom Categories
1. Create new task lists with appropriate categories
2. Set up department-specific assignments
3. Configure recurring schedules as needed
4. Train employees on new procedures

### Branding Customization
- Update logo in navigation layouts
- Modify colors in Tailwind CSS configuration
- Customize email templates
- Add company-specific terminology

## 🔧 Configuration

### Environment Variables
```env
APP_NAME="TaskCheck"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskcheck
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
# Configure email settings for notifications
```

### File Storage
Configure storage for uploaded proof files:
```bash
php artisan storage:link
```

## 📊 Analytics & Reporting

### Available Metrics
- Employee completion rates
- Average time per checklist
- Most rejected tasks
- Department performance
- Daily/weekly/monthly trends

### Export Options
- CSV export for spreadsheet analysis
- PDF reports for management
- API data for custom dashboards

## 🚀 Deployment

### Production Checklist
- [ ] Set `APP_ENV=production`
- [ ] Configure proper database
- [ ] Set up file storage (S3/local)
- [ ] Configure email settings
- [ ] Set up SSL certificate
- [ ] Configure backups
- [ ] Set up monitoring

### Recommended Hosting
- **Shared Hosting**: Any Laravel-compatible host
- **VPS**: DigitalOcean, Linode, AWS EC2
- **Platform as a Service**: Laravel Forge, Vapor

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Submit a pull request

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🆘 Support

### Common Issues
- **File upload errors**: Check storage permissions and PHP upload limits
- **Email not sending**: Verify SMTP configuration
- **Performance issues**: Enable caching and optimize database queries

### Getting Help
- Check the documentation above
- Review Laravel documentation for framework-specific issues
- Open an issue on GitHub for bugs or feature requests

## 🔮 Roadmap

### Upcoming Features
- [ ] Mobile app (React Native/Flutter)
- [ ] Offline sync capabilities
- [ ] Advanced analytics dashboard
- [ ] Multi-language support
- [ ] Integration with external tools
- [ ] Automated scheduling
- [ ] Push notifications
- [ ] Barcode/QR code scanning
- [ ] GPS location tracking
- [ ] Team collaboration features

### Industry-Specific Enhancements
- [ ] Healthcare compliance features
- [ ] Construction safety protocols
- [ ] Retail inventory integration
- [ ] Cleaning service optimizations
- [ ] Manufacturing quality control

---

**Built with ❤️ using Laravel 12, Tailwind CSS, and modern web technologies.**