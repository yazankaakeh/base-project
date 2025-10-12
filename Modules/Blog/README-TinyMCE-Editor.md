# TinyMCE Post Editor Documentation

This document provides comprehensive information about the TinyMCE post editor components created for the Blog module.

## Overview

The TinyMCE post editor system provides three main components for creating and editing blog posts:

1. **Full Featured Post Editor** - Complete editor with all features
2. **Quick Post Editor** - Simplified editor for quick post creation
3. **Quick Post Widget** - Embeddable widget for anywhere post creation

## Components

### 1. Full Featured Post Editor (`tinymce-post-editor.blade.php`)

The most comprehensive editor with all available features.

#### Features:
- Multi-language support (EN, AR, TR)
- Rich text editing with TinyMCE
- SEO fields (title, description)
- Image upload
- Tags selection
- Post type selection
- Related posts selection
- Responsive design
- Dark/light mode support

#### Usage:
```blade
@include('blog::components.tinymce-post-editor', [
    'formId' => 'my-form',
    'isEdit' => false,
    'model' => null,
    'showSeo' => true,
    'showImage' => true,
    'showTags' => true,
    'showType' => true,
    'showRelatedPosts' => true,
    'tagOptions' => $tagOptions,
    'relatedPostsOptions' => $relatedPostsOptions,
    'selectedTags' => [],
    'selectedRelatedPosts' => [],
    'selectedType' => '',
    'imageUrl' => null
])
```

#### Parameters:
- `formId`: Unique form identifier
- `isEdit`: Boolean, true for edit mode
- `model`: The post model (for edit mode)
- `showSeo`: Show/hide SEO fields
- `showImage`: Show/hide image upload
- `showTags`: Show/hide tags selection
- `showType`: Show/hide post type selection
- `showRelatedPosts`: Show/hide related posts
- `tagOptions`: Array of available tags
- `relatedPostsOptions`: Array of related posts
- `selectedTags`: Array of selected tag IDs
- `selectedRelatedPosts`: Array of selected related post IDs
- `selectedType`: Selected post type
- `imageUrl`: Current image URL (for edit mode)

### 2. Quick Post Editor (`quick-post-editor.blade.php`)

Simplified editor for quick post creation with essential features only.

#### Features:
- Single language support
- Rich text editing with TinyMCE
- Optional image upload
- Optional tags selection
- Clean, minimal interface
- Form clearing functionality

#### Usage:
```blade
@include('blog::components.quick-post-editor', [
    'formId' => 'quick-form',
    'isEdit' => false,
    'model' => null,
    'showImage' => true,
    'showTags' => true,
    'tagOptions' => $tagOptions
])
```

### 3. Quick Post Widget (`quick-post-widget.blade.php`)

Embeddable widget that can be placed anywhere for quick post creation.

#### Features:
- Compact design
- Essential fields only
- Auto-save functionality (optional)
- Loading states
- Form validation

#### Usage:
```blade
@include('blog::components.quick-post-widget', [
    'formId' => 'widget-form',
    'showImage' => false,
    'showTags' => true,
    'tagOptions' => $tagOptions
])
```

## TinyMCE Configuration

### Blog-Specific Configuration (`blog-tinymce-config.js`)

The blog editor uses a specialized TinyMCE configuration with enhanced features:

#### Key Features:
- **Rich Toolbar**: Full set of formatting tools
- **Image Handling**: Upload, resize, and manage images
- **Table Support**: Create and edit tables
- **Templates**: Pre-built post templates
- **Auto-save**: Automatic draft saving
- **Word Count**: Real-time word and character counting
- **Spell Check**: Built-in spell checking
- **Theme Support**: Dark/light mode compatibility
- **RTL Support**: Right-to-left language support

#### Plugins Included:
- Advanced list management
- Auto-linking
- Image tools
- Table editing
- Code samples
- Templates
- Auto-save
- Word count
- Spell checker
- And many more...

## File Structure

```
Modules/Blog/
├── resources/
│   ├── views/
│   │   ├── components/
│   │   │   ├── tinymce-post-editor.blade.php
│   │   │   ├── quick-post-editor.blade.php
│   │   │   └── quick-post-widget.blade.php
│   │   ├── examples/
│   │   │   └── post-editor-examples.blade.php
│   │   ├── posts/
│   │   │   ├── create-new.blade.php
│   │   │   └── edit-new.blade.php
│   │   └── ...
│   └── assets/
│       └── js/
│           └── blog-tinymce-config.js
└── README-TinyMCE-Editor.md
```

## Integration

### 1. Include Required Assets

Make sure to include the necessary CSS and JavaScript files:

```blade
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'], 'build/modules/theme')
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js'], 'build/modules/theme')
@endsection

@section('page-script')
    @vite(['resources/assets/js/forms-editors.js','resources/assets/js/blog-tinymce-config.js'],'build/modules/theme')
@endsection
```

### 2. Form Setup

Ensure your form has the correct attributes:

```blade
<form action="{{ route('doctor.posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Editor components here -->
</form>
```

### 3. Controller Integration

The editors work with standard Laravel form handling. Make sure your controller can handle:

- Multi-language content arrays
- File uploads
- Tag relationships
- Related post relationships

## Customization

### 1. Custom TinyMCE Configuration

You can extend the blog configuration by modifying `blog-tinymce-config.js`:

```javascript
window.blogTinyMCEConfig = {
    // Your custom configuration
    height: 600,
    plugins: ['your-custom-plugin'],
    toolbar: 'your-custom-toolbar',
    // ... other options
};
```

### 2. Custom Templates

Add custom templates to the TinyMCE configuration:

```javascript
templates: [
    {
        title: 'Your Custom Template',
        description: 'Description of your template',
        content: '<h1>Your Template Content</h1>'
    }
]
```

### 3. Custom Styling

Override the default styles by adding custom CSS:

```css
.tinymce-post-editor .tox-tinymce {
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.quick-post-editor .card-header {
    background: linear-gradient(45deg, #your-color1, #your-color2);
}
```

## Best Practices

### 1. Performance
- Use lazy loading for large tag lists
- Implement pagination for related posts
- Optimize image uploads

### 2. User Experience
- Provide clear validation messages
- Implement auto-save functionality
- Show loading states during operations

### 3. Accessibility
- Ensure proper ARIA labels
- Support keyboard navigation
- Provide alternative text for images

### 4. Security
- Validate all form inputs
- Sanitize HTML content
- Implement CSRF protection

## Troubleshooting

### Common Issues

1. **TinyMCE not initializing**
   - Check if TinyMCE is loaded
   - Verify the selector is correct
   - Ensure the element exists in DOM

2. **Images not uploading**
   - Check upload route configuration
   - Verify CSRF token
   - Check file permissions

3. **Content not saving**
   - Ensure form submission handler
   - Check hidden input synchronization
   - Verify controller logic

### Debug Mode

Enable debug mode by adding to your configuration:

```javascript
window.blogTinyMCEConfig.debug = true;
```

## Examples

See `Modules/Blog/resources/views/examples/post-editor-examples.blade.php` for comprehensive usage examples.

## Support

For issues or questions:
1. Check the troubleshooting section
2. Review the example files
3. Check browser console for errors
4. Verify all dependencies are loaded

## Changelog

### Version 1.0.0
- Initial release
- Full featured post editor
- Quick post editor
- Quick post widget
- Multi-language support
- Dark/light mode support
- Image upload functionality
- SEO integration
