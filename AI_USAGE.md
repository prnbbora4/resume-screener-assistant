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