# John Long Design Portfolio 2025

A clean and unique UX Design Portfolio WordPress theme built with Bootstrap 5, featuring organized SCSS files that compile to minified CSS and JavaScript files within an "assets" folder.

## Features

### Homepage Sections
- **Hero Banner** - Featured foreground image with bold intro text
- **Featured Projects** - Showcase case studies with project cards
- **About Section** - Personal introduction and skills
- **What Clients Say** - Testimonial cards with ratings
- **Download Resume** - Call-to-action section
- **Let's Work Together** - Contact form

### Project Case Studies
- **Project Overview** - Detailed project description
- **The Problem** - Challenge identification
- **Research & Discovery** - User Interviews, Market Analysis, Usability Testing cards
- **Key Insights** - Research findings
- **The Solution** - 50-50 image/text sections with lightbox functionality
- **Design Process** - Colored numbered stages
- **Results & Impact** - Large statistics display
- **Testimonials** - Client feedback
- **Project Navigation** - Previous/Next project links

### Technical Features
- Bootstrap 5 responsive framework
- SCSS organization with proper compilation
- Minified CSS and JS files
- Custom post types (Projects, Testimonials)
- Custom fields for project metadata
- Lightbox image gallery
- Contact form with validation
- WordPress Customizer integration
- SEO-friendly structure

## File Structure

```
john-long-design-2025/
├── assets/
│   ├── scss/
│   │   ├── main.scss
│   │   ├── _variables.scss
│   │   ├── _mixins.scss
│   │   ├── _base.scss
│   │   ├── _layout.scss
│   │   ├── _components.scss
│   │   ├── _sections.scss
│   │   └── _utilities.scss
│   ├── css/
│   │   ├── main.min.css
│   │   └── lightbox.min.css
│   └── js/
│       ├── main.js
│       ├── main.min.js
│       ├── lightbox.js
│       └── lightbox.min.js
├── functions.php
├── style.css
├── index.php
├── header.php
├── footer.php
├── archive-project.php
├── single-project.php
├── package.json
└── README.md
```

## Installation

1. Upload the theme folder to `/wp-content/themes/`
2. Activate the theme in WordPress admin
3. Install Node.js dependencies (optional, for development):
   ```bash
   npm install
   ```

## Development

### SCSS Compilation
```bash
# Watch for changes and auto-compile
npm run sass:watch

# Single compilation
npm run sass
```

### JavaScript Build
```bash
# Build minified JS files
npm run js:build
npm run js:lightbox

# Watch all files
npm run watch
```

### Full Build Process
```bash
npm run build
```

## Customization

### Theme Customizer Options
- Hero section content (title, subtitle, description, image)
- Contact email
- Logo and site identity
- Colors and typography (via CSS custom properties)

### Custom Post Types
- **Projects** - Portfolio case studies with metadata
- **Testimonials** - Client feedback with ratings and author info

### Custom Fields
- Project URL, Client, Duration, Role, Featured status
- Testimonial rating, client name, position, company

## Browser Support
- Chrome (last 2 versions)
- Firefox (last 2 versions)  
- Safari (last 2 versions)
- Edge (last 2 versions)

## License
GPL-2.0-or-later

## Author
John Long - UX Designer & Developer
