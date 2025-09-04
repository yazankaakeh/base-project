# 🧩 Core Module - Shared Assets

The **Core module** provides shared static assets and utilities used across the application.

## 📦 Included Assets

- 🌍 Country flags in SVG format (named by ISO2 code)
- 📦 JS plugin: `intlTelInput`

## 📁 Folder Structure

Modules/Core/
└── Resources/
└── assets/
├── flags/
│ └── svg/
└── js/
└── intlTelInput/

## 🚀 Publishing Assets

To make the assets publicly accessible, run the following command:

```bash
   php artisan vendor:publish --tag=core-assets
   ```

This will copy the files to:

public/assets/flags/ ← from Core/Resources/assets/flags/svg/

public/intlTelInput/ ← from Core/Resources/assets/js/intlTelInput/

