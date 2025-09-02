# Email Notification Setup Guide

This guide will help you configure email notifications for your Laravel project management system.

## Features Implemented

✅ **Task Creation Notifications**: Team members receive emails when new tasks are created
✅ **Task Update Notifications**: Team members receive emails when tasks are modified
✅ **Team Member Addition Notifications**: Existing team members are notified when new members join
✅ **Change Tracking**: Email notifications show what specific fields were changed
✅ **Queue Support**: All notifications are queued for better performance

## Environment Configuration

Add these variables to your `.env` file:

```env
# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host.com
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Your Project Management System"

# Queue Configuration (for better performance)
QUEUE_CONNECTION=database
```

## Database Setup

1. **Create the jobs table for queued notifications:**
```bash
php artisan queue:table
php artisan migrate
```

2. **Start the queue worker:**
```bash
php artisan queue:work
```

## Email Service Providers

### Option 1: Gmail SMTP
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

### Option 2: Mailgun
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.mailgun.org
MAILGUN_SECRET=your-mailgun-secret
```

### Option 3: SendGrid
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
```

## Testing Email Notifications

### 1. Test with Log Driver (Development)
```env
MAIL_MAILER=log
```
Check `storage/logs/laravel.log` for email content.

### 2. Test with Mailtrap (Development)
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
```

## How It Works

### Task Creation Flow
1. User creates a new task
2. `TaskController@store` creates the task
3. `TaskNotificationService` sends notifications to:
   - All project team members (except the task creator)
   - The assigned user (if different from creator)

### Task Update Flow
1. User updates a task
2. `TaskController@update` or `TaskController@updateStatus` updates the task
3. `TaskNotificationService` tracks changes and sends notifications to:
   - All project team members (except the person who made the update)
   - The assigned user (if different from the person who made the update)

### Team Member Addition Flow
1. User adds a new team member to a project
2. `ProjectController@addMember` adds the member
3. `TaskNotificationService` notifies existing team members about the new addition

## Notification Types

### TaskCreatedNotification
- Subject: "New Task Created: [Task Title]"
- Includes: Task details, priority, due date, assigned user
- Action button: View Task

### TaskUpdatedNotification
- Subject: "Task Updated: [Task Title]"
- Includes: Changes made, current task details
- Action button: View Task

### TeamMemberAddedNotification
- Subject: "New Team Member Added to Project: [Project Name]"
- Includes: New member details, project information
- Action button: View Project

## Customization

### Modify Email Templates
Edit the notification classes in `app/Notifications/`:
- `TaskCreatedNotification.php`
- `TaskUpdatedNotification.php`
- `TeamMemberAddedNotification.php`

### Change Notification Logic
Edit `app/Services/TaskNotificationService.php` to modify:
- Who receives notifications
- When notifications are sent
- What information is included

### Add More Notification Types
1. Create new notification class: `php artisan make:notification YourNotification`
2. Add method to `TaskNotificationService`
3. Call the method from appropriate controller

## Troubleshooting

### Emails Not Sending
1. Check `.env` configuration
2. Verify SMTP credentials
3. Check Laravel logs: `tail -f storage/logs/laravel.log`
4. Ensure queue worker is running: `php artisan queue:work`

### Queue Issues
1. Check if jobs table exists: `php artisan migrate:status`
2. Check failed jobs: `php artisan queue:failed`
3. Retry failed jobs: `php artisan queue:retry all`

### Testing
1. Use log driver for development
2. Use Mailtrap for testing
3. Check notification classes for syntax errors
4. Verify database relationships are working

## Security Notes

- Never commit `.env` file to version control
- Use app-specific passwords for Gmail
- Consider rate limiting for email sending
- Validate email addresses before sending
- Use HTTPS in production

## Performance Tips

- Use queue workers for better performance
- Consider batching notifications for bulk operations
- Monitor queue performance
- Use database transactions for consistency