# Home Page CMS Management Guide

## Overview

The home page is fully editable through the CMS system. All content, including hero sections, features, team members, FAQs, and contact information, can be updated without touching code.

## How to Edit the Home Page

### Method 1: Quick Edit Button (Recommended)
1. Navigate to **Admin Panel → CMS → Pages**
2. Click the **"Edit Home Page"** button at the top right (green button with home icon)
3. This takes you directly to the home page editor

### Method 2: From Pages List
1. Navigate to **Admin Panel → CMS → Pages**
2. Find the page with slug `home` (highlighted in green with a home icon)
3. Click the **Edit** button for that page

## Home Page Structure

The home page uses the **CMS Page** system with the following configuration:

- **Slug**: `home` (cannot be changed)
- **Template**: `landing`
- **Status**: `published`
- **Multi-language**: Supports English, Arabic, Turkish

### Content Sections

The home page content is stored in the `meta_data` JSON field with the following sections:

#### 1. Hero Section (`meta_data.hero`)
```json
{
    "title": {"en": "...", "ar": "...", "tr": "..."},
    "subtitle": {"en": "...", "ar": "...", "tr": "..."},
    "description": {"en": "...", "ar": "...", "tr": "..."},
    "cta_text": {"en": "...", "ar": "...", "tr": "..."},
    "cta_url": "/register",
    "image": "path/to/hero/image.png"
}
```

#### 2. Features Section (`meta_data.features`)
Contains:
- Badge text
- Title and description
- Array of feature items (each with icon, title, description)

#### 3. Team Section (`meta_data.team`)
Contains:
- Badge text
- Title and description
- Array of team members (name, position, avatar)

#### 4. Contact Section (`meta_data.contact`)
Contains:
- Badge text
- Title and description
- Email and phone

#### 5. CTA Section (`meta_data.cta`)
Call-to-action section with:
- Title and subtitle
- Button text and URL

#### 6. FAQ Section (`meta_data.faq`)
Contains:
- Badge text
- Title and description
- Array of FAQ items (question and answer in multiple languages)

## Editing Content

### Through CMS Interface

**Basic Content (Title, Excerpt, Content)**:
- Edit in the main content tabs (EN/AR/TR)
- Use Quill editor for rich text formatting

**Advanced Content (meta_data sections)**:
Currently edited through the database or by updating the seeder:
```bash
php artisan db:seed --class=Modules\\CMS\\Database\\Seeders\\LandingPageSeeder
```

### Programmatically

**Get Home Page**:
```php
use Modules\CMS\Actions\Page\GetHomePageAction;

public function index(GetHomePageAction $action)
{
    $homePage = $action->handleOrFail();
    $sections = $homePage->meta_data;
}
```

**Update Home Page**:
```php
use Modules\CMS\Actions\Page\UpdateHomePageAction;

public function update(PageRequest $request, UpdateHomePageAction $action)
{
    $homePage = $action->handle($request);
}
```

**Using Repository**:
```php
use Modules\CMS\Repository\Page\PageInterface;

public function __construct(private PageInterface $pages) {}

public function getHome()
{
    return $this->pages->getHomePage();
}
```

## Security Features

- The home page **cannot be deleted** from the CMS (protected with lock icon)
- Requires authentication (`auth:doctor`)
- Requires admin permissions (`admin-enabled`, `authorize`)
- All actions are logged for audit purposes

## Seeding/Resetting Home Page

To reset the home page to default content:

```bash
php artisan db:seed --class=Modules\\CMS\\Database\\Seeders\\LandingPageSeeder
```

This will update or create the home page with default multi-language content.

## File Locations

### Controllers
- **CMS Controller**: `Modules/CMS/app/Http/Controllers/CMSController.php` (lines 55-62 - edit method)
- **Landing Controller**: `Modules/Website/app/Http/Controllers/LandingPageController.php` (lines 13-25)

### Actions
- **GetHomePageAction**: `Modules/CMS/app/Actions/Page/GetHomePageAction.php`
- **UpdateHomePageAction**: `Modules/CMS/app/Actions/Page/UpdateHomePageAction.php`

### Repository
- **PageRepository**: `Modules/CMS/app/Repository/Page/PageRepository.php`
  - `getHomePage()` method (line 128-131)
  - `findBySlug()` method (line 120-126)

### Views
- **Home Page Template**: `Modules/Website/resources/views/newLanding/home.blade.php`
- **CMS Edit Form**: `Modules/CMS/resources/views/pages/edit.blade.php`
- **CMS Pages Index**: `Modules/CMS/resources/views/pages/index.blade.php` (line 22-25 - quick edit button)

### Models & Migrations
- **Page Model**: `Modules/CMS/app/Models/Page.php`
- **Pages Table**: `cms_pages`

### Seeders
- **LandingPageSeeder**: `Modules/CMS/database/seeders/LandingPageSeeder.php`

## Architecture Pattern

The home page follows the project's clean architecture:

```
Request → Controller (thin) → Action → Repository → Model → Database
                                ↓
                            View (home.blade.php)
```

### Code Flow
1. **User visits "/"** → Routes to `LandingPageController@home`
2. **Controller** injects `GetHomePageAction`
3. **Action** calls `PageRepository->getHomePage()`
4. **Repository** queries database for page with slug 'home'
5. **Controller** returns view with page data
6. **View** renders sections from `meta_data`

### Benefits
- **Thin controllers** - Only 4 lines in home() method
- **Reusable logic** - Actions can be used anywhere
- **Testable** - Each layer can be tested independently
- **Maintainable** - Clear separation of concerns

## Tips

1. **Multi-language**: Always update content for all languages (EN, AR, TR)
2. **Images**: Store images in `public/assets/img/` or use media library
3. **URLs**: Use relative URLs for internal links (e.g., `/register` instead of full URL)
4. **Status**: Keep status as "Published" and set publish date to enable the page
5. **Template**: Always keep template as "Landing" for the home page

## Troubleshooting

**Home page not found (404)**:
```bash
# Run the seeder to create it
php artisan db:seed --class=Modules\\CMS\\Database\\Seeders\\LandingPageSeeder
```

**Changes not showing**:
- Clear cache: `php artisan cache:clear`
- Check page status is "Published"
- Check publish date is in the past

**Cannot find edit button**:
- Make sure you're on the CMS Pages index (/cms)
- Home page should be highlighted in green with home icon
- Look for "Edit Home Page" button at top right
