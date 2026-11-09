## Prompt 01 – Project inspection and architecture planning

I am building a web application called **Resume Screener Assistant** as part of an AI Product Engineer candidate assessment for Synthweb.

The project is already initialized using Laravel 13.

Your task is to inspect the existing Laravel project and prepare a proper implementation plan before writing any code.

### Project Requirements

The application will allow HR users to:

1. Enter or paste a job description.
2. Enter or paste a candidate's resume.
3. Submit the information for AI-powered analysis.
4. Receive a structured candidate match report containing:
   - Match score (0–100).
   - Top 5 matching skills.
   - Top 3 skill gaps.
   - 3 suggested interview questions.
5. Save every completed analysis in an SQLite database.
6. View previous analyses through a History page.
7. Search historical analyses by candidate name.
8. Filter historical analyses by minimum and maximum match score.

### Technical Requirements

- Laravel 13.
- PHP compatible with Laravel 13.
- SQLite database.
- Laravel Blade templates.
- Bootstrap 5 or clean custom CSS.
- Laravel HTTP Client for LLM API communication.
- OpenAI API for AI-powered resume analysis.
- Laravel validation.
- Service-oriented backend architecture.
- PHPUnit or Pest for automated tests.

### Architecture Guidelines

Follow these principles:

1. Keep controllers lightweight.
2. Place AI-related business logic inside dedicated service classes.
3. Use Laravel Form Requests where appropriate.
4. Use Eloquent models for database operations.
5. Use reusable Blade components.
6. Keep API credentials inside environment variables.
7. Never expose API keys in frontend code or logs.
8. Validate AI-generated JSON before displaying or saving the report.
9. Handle API errors and malformed responses gracefully.
10. Follow Laravel 13 conventions and avoid outdated implementation patterns.

### Instructions

First, inspect:

- Laravel version and PHP requirements.
- Existing folder structure.
- Existing routes.
- Existing database configuration.
- Installed frontend dependencies.
- Existing authentication or middleware, if any.

Then provide:

1. A proposed application architecture.
2. A recommended folder and file structure.
3. A proposed database schema.
4. A list of controllers, models, services, requests and Blade views.
5. A list of implementation phases.
6. Any dependencies that need installation.

**Important:** Do not modify or generate any files yet. First provide the architecture and implementation plan. Wait for my approval before proceeding.

## Prompt 02 – SQLite configuration and database migration

The project inspection is complete.

The existing project has:
- Laravel 13.
- SQLite configured as the default database.
- DB_CONNECTION=sqlite in .env.
- database/database.sqlite already exists.
- config/database.php uses database/database.sqlite when DB_DATABASE is unset.

Now implement the resume_analyses database migration.

### Create migration

Run:

php artisan make:migration create_resume_analyses_table

Create the following schema:

- id: primary key
- candidate_name: string, required
- match_score: unsigned tiny integer, required
- matching_skills: JSON, required
- skill_gaps: JSON, required
- interview_questions: JSON, required
- timestamps

### Database constraints

- Add an index on candidate_name.
- Add an index on match_score.
- Add a SQLite-compatible CHECK constraint ensuring match_score is between 0 and 100 inclusive.
- Ensure the migration supports SQLite correctly.

### Instructions

1. Use the existing SQLite configuration.
2. Do not unnecessarily modify .env.
3. Update .env.example only if necessary.
4. Run php artisan migrate.
5. Run php artisan migrate:status.
6. Verify that the new table exists.
7. Do not modify unrelated files.
8. Do not create models, controllers, services, or views yet.

You have permission to create and edit project files and execute the required terminal commands.

Report the exact files modified and the actual command results. Do not claim success if a command fails.

## Prompt 03 – Create Eloquent model


Prompt 02 has been completed successfully.

Now implement Phase 2: Create the Eloquent model for the Resume Screener Assistant.

### Task

Create the following model:

app/Models/ResumeAnalysis.php

Use Laravel 13 Eloquent conventions.

### Model requirements

1. Configure the model to use the existing resume_analyses table.
2. Define the appropriate fillable attributes:
   - candidate_name
   - match_score
   - matching_skills
   - skill_gaps
   - interview_questions

3. Configure Eloquent casts:
   - match_score: integer
   - matching_skills: array
   - skill_gaps: array
   - interview_questions: array

4. Ensure JSON columns are automatically converted into PHP arrays when retrieving records and converted back into JSON when saving records.

### Additional requirements

- Use modern Laravel 13 conventions.
- Avoid unnecessary custom methods.
- Do not introduce relationships that are not required by the current database schema.
- Do not add unnecessary dependencies.
- Do not modify the existing migration or database structure.

### Verification

After creating the model:

1. Inspect the model for correctness.
2. Use Laravel Tinker to verify that the model can retrieve existing database records.
3. Verify that the JSON attributes are returned as PHP arrays.
4. Verify that match_score is returned as an integer.
5. Do not insert dummy production records into the database.

### Restrictions

Do not create controllers, services, requests, routes, or Blade views yet.

Report the file created, implementation details, and actual verification results.


## Prompt 04 – Build the application layout and reusable Blade components

The database migration and ResumeAnalysis model have been completed and verified.

Now implement Phase 3: Application layout and reusable Blade components.

### Design direction

Build a modern, professional SaaS dashboard for an internal HR tool called:

Resume Screener Assistant

The UI should look like a polished HR recruitment product, not a basic Laravel starter template.

### Design requirements

**Overall layout:**
- Responsive application layout.
- Fixed or sticky left sidebar on desktop.
- Main content area on the right.
- Mobile-friendly collapsible navigation.
- Clean white/light-gray background.
- Professional typography.
- Consistent spacing, borders, shadows and border radius.
- Modern SaaS dashboard appearance.

**Color palette:**
- Primary: Indigo (#4F46E5).
- Sidebar: Dark navy (#111827).
- Main background: Light gray (#F9FAFB).
- Cards: White.
- Primary text: Dark gray (#111827).
- Secondary text: Gray (#6B7280).
- Success: Green.
- Warning: Amber.
- Error: Red.

### Sidebar navigation

Include:

1. Dashboard
2. New Analysis
3. Analysis History

At the bottom, include:
- Application branding.
- A small version indicator if appropriate.

Use appropriate icons. Lucide icons or inline SVG are acceptable.

### Header

Include:
- Current page title.
- Short contextual description.
- A simple profile/avatar placeholder labelled HR.
- Responsive mobile navigation toggle.

Do not implement authentication or user account management.

### Reusable Blade components

Create reusable components under:

resources/views/components/

Suggested components:

- `app-layout.blade.php`
- `sidebar.blade.php`
- `header.blade.php`
- `page-heading.blade.php`
- `stat-card.blade.php`
- `empty-state.blade.php`
- `alert.blade.php`

You may adjust the component structure if another approach is more maintainable.

### Technical requirements

1. Use Laravel Blade components.
2. Use the existing Tailwind CSS 4 and Vite setup.
3. Inspect existing CSS and JavaScript configuration before modifying anything.
4. Do not install Bootstrap or another CSS framework.
5. Keep styles consistent and reusable.
6. Use semantic HTML.
7. Ensure mobile responsiveness.
8. Avoid unnecessary JavaScript dependencies.
9. Use accessible buttons and navigation.
10. Preserve existing Laravel functionality.

### Layout implementation

Create:

resources/views/layouts/app.blade.php

The layout should provide:
- HTML document structure.
- Responsive viewport.
- Page title support.
- Vite CSS and JavaScript integration.
- Sidebar.
- Header.
- Main content slot.
- Flash message area.
- CSRF support where required.

Use reusable components rather than duplicating layout markup.

### Important restrictions

- Do not create the dashboard page yet.
- Do not create the analysis form.
- Do not create controllers or services.
- Do not implement business logic.
- Do not modify the database.

### Verification

After implementation:

1. Run npm run build.
2. Check for Tailwind or Vite compilation errors.
3. Inspect the Blade component structure.
4. Verify that the layout renders without Blade errors using a temporary test route if necessary.
5. Remove any temporary test route afterward.

Report all files created or modified and the actual verification results.

Do not proceed to the next phase.

## Prompt 05 – Dashboard UI

The application layout and reusable Blade components have been implemented and verified.

Now implement Phase 4: Create the Resume Screener Assistant dashboard UI.

### Objective

Build a polished SaaS dashboard that gives HR users an overview of candidate screening activity and provides quick access to resume analysis.

### Dashboard route

The dashboard will eventually be available at:

/

For now, implement the Blade view and a minimal route that renders it.

View:

resources/views/dashboard/index.blade.php

Use the existing reusable application layout and components.

### Dashboard sections

#### 1. Welcome section

Display:

Heading: Welcome to Resume Screener Assistant

Description: Analyze resumes against job descriptions, identify relevant skills, and discover candidate suitability with AI-powered insights.

Include a prominent button:

"Start New Analysis"

This should eventually navigate to the resume analysis form.

#### 2. Statistics cards

Display four cards:

- Total Analyses
- Average Match Score
- High Matches (80–100)
- Low Matches (0–49)

For this initial UI implementation, use clearly identifiable temporary placeholder values.

Important: Structure the cards so they can later receive dynamic values from the controller. Do not hardcode statistics into reusable components.

#### 3. Quick action section

Create a prominent card encouraging HR users to start a new resume screening.

Include:
- A document/resume icon.
- Short description.
- Start Analysis button.

#### 4. Recent activity section

Create a recent analyses table with:

- Candidate Name
- Match Score
- Matching Skills
- Date
- Action

Display 3–5 realistic-looking sample rows strictly as temporary UI placeholders.

Use color-coded score indicators:

- 80–100: Green.
- 50–79: Amber.
- 0–49: Red.

Do not insert placeholder data into the database.

#### 5. Empty-state support

Create an appropriate empty state for when there are no previous analyses.

### UI expectations

- Professional HR SaaS dashboard.
- Consistent with the existing sidebar and header.
- Responsive desktop, tablet and mobile layouts.
- Good typography and visual hierarchy.
- Subtle borders and shadows.
- Accessible buttons and table elements.
- Avoid excessive animations or unnecessary decorative elements.

### Technical requirements

1. Use Blade templates and reusable components.
2. Use the existing Tailwind CSS 4 setup.
3. Reuse existing layout components.
4. Keep the dashboard view separate from business logic.
5. Use dynamic Blade variables for statistics and recent analyses.
6. Use sensible fallback values when data is unavailable.
7. Avoid introducing new dependencies.

### Routing

Add a temporary dashboard route to routes/web.php.

Do not create the analysis form or history functionality yet.

### Verification

1. Open the dashboard in a browser if browser preview is available.
2. Verify responsive behavior.
3. Run npm run build.
4. Run php artisan test.
5. Check for Blade errors.

Report files created or modified and actual verification results.

Do not proceed to the next phase.