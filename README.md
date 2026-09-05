# Traitz Chirps: Laravel Backend Internship Lab

Welcome to **Traitz Chirps**, a small Laravel application created by **Junior DCoder** for TraitzTech Laravel backend interns. This project follows the learning style of [Laravel Learn](https://laravel.com/learn): start with a working application, understand each layer, then improve it through focused exercises.

The application is intentionally unfinished in places. That gives you a safe, realistic codebase in which to practise Laravel fundamentals and submit meaningful improvements.

## What You Are Building

Traitz Chirps is a simple social feed where users can:

- Register and log in.
- Log out securely.
- Read the latest chirps.
- Create a chirp with a message of up to 255 characters.
- See the author and relative creation time for each chirp.

The next stage is yours: add editing, deletion, trash and restore workflows, authorization, tests, and other improvements.

## Technology Stack

- PHP 8.3 or newer
- Laravel 13
- SQLite by default, with Eloquent ORM
- Blade views and Laravel components
- Vite and Tailwind CSS / DaisyUI styling already included in the project
- Pest for automated tests
- Laravel Pint for PHP formatting
- Laravel Boost for Laravel-aware AI development guidance

## Project Map

```text
app/
  Http/Controllers/       Request handling and application actions
  Models/                 Eloquent models such as User and Chirp
database/
  migrations/             Database table definitions
  factories/              Test data factories
  seeders/                Sample database data
resources/views/          Blade pages and reusable components
routes/web.php            Browser routes and middleware
tests/                    Feature and unit tests
public/                   Public web entry point and built assets
```

Important files to read first:

- `routes/web.php`: the current browser routes.
- `app/Http/Controllers/ChirpController.php`: listing and creation logic, plus CRUD methods waiting to be completed.
- `app/Models/Chirp.php`: the chirp model and user relationship.
- `database/migrations/*create_chirps_table.php`: the chirps table structure.
- `resources/views/home.blade.php`: the feed and create form.
- `resources/views/components/chirp.blade.php`: the reusable chirp display component.

## Current Routes

| Method | URL         | Purpose                   | Authentication      |
| ------ | ----------- | ------------------------- | ------------------- |
| `GET`  | `/`         | Show the latest 50 chirps | Public              |
| `GET`  | `/register` | Show registration form    | Guests              |
| `POST` | `/register` | Create a user account     | Public              |
| `GET`  | `/login`    | Show login form           | Guests              |
| `POST` | `/login`    | Authenticate a user       | Public              |
| `POST` | `/logout`   | End the current session   | Authenticated users |
| `POST` | `/chirps`   | Create a chirp            | Authenticated users |

Run `php artisan route:list` whenever you add or change a route.

## Prerequisites

Install these tools before starting:

- PHP 8.3+
- Composer
- Node.js and npm
- Git
- A GitHub account

Check your versions:

```bash
php -v
composer -V
node -v
npm -v
git --version
```

## Fork and Clone the Repository

Each intern should work in their own fork. Do not push directly to the original repository.

1. Open the project on GitHub: <https://github.com/JuniorDCoder/traitz-backend-chirps>
2. Click **Fork** and create the fork under your GitHub account.
3. Clone your fork, replacing `YOUR_USERNAME` with your GitHub username:

```bash
git clone https://github.com/YOUR_USERNAME/traitz-backend-chirps.git
cd traitz-backend-chirps
```

4. Add the original repository as an upstream remote:

```bash
git remote add upstream https://github.com/JuniorDCoder/traitz-backend-chirps.git
git remote -v
```

5. Create a branch for your work:

```bash
git checkout -b feature/your-name-chirp-improvements
```

## Install and Run Locally

From the project directory:

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install
npm run build
```

Start the application:

```bash
php artisan serve
```

Open <http://127.0.0.1:8000> in your browser. During frontend development, use `npm run dev` in a second terminal instead of `npm run build`.

You can also use the project setup script after cloning:

```bash
composer run setup
```

If the database needs to be recreated during learning, remember that this deletes local data:

```bash
php artisan migrate:fresh --seed
```

## Understanding the Current Flow

When a user creates a chirp:

1. The form in `resources/views/home.blade.php` sends a `POST` request to `/chirps`.
2. The route applies the `auth` middleware and calls `ChirpController::store`.
3. The controller validates the message.
4. The authenticated user's ID is stored with the chirp.
5. Eloquent saves the record in the `chirps` table.
6. The user is redirected to the feed, where the new chirp is displayed.

Read this flow in the code before starting the exercises. Trace the request from route to controller to model to view.

## Exercises

Complete the exercises in order. For each exercise, explain your decisions in the pull request description and add tests where requested.

### 1. Add Edit and Update

Allow the owner of a chirp to edit its message.

Suggested tasks:

- Add `GET /chirps/{chirp}/edit` and `PUT/PATCH /chirps/{chirp}` routes.
- Implement `edit` and `update` in `ChirpController`.
- Create an edit Blade view or a reusable form component.
- Validate the updated message with the same 255-character limit.
- Show an Edit action only to the chirp owner.
- Redirect back with a success message after updating.

### 2. Add Delete

Allow the owner of a chirp to delete it.

Suggested tasks:

- Add a `DELETE /chirps/{chirp}` route.
- Implement `destroy` using route model binding.
- Add a delete form with CSRF protection in the chirp component.
- Prevent users from deleting other users' chirps.
- Add feature tests for successful deletion and unauthorized deletion.

### 3. Add Authorization with a Policy

Move ownership rules out of the controller and into a `ChirpPolicy`.

Suggested tasks:

- Generate a policy with Artisan.
- Add an `update` and `delete` policy method.
- Use `$this->authorize(...)` or route authorization in the controller.
- Confirm that guests cannot edit or delete chirps.
- Confirm that an authenticated user cannot modify another user's chirp.

Useful command:

```bash
php artisan make:policy ChirpPolicy --model=Chirp
```

### 4. Add Trash and Restore

Use Laravel soft deletes so deleted chirps can be recovered.

Suggested tasks:

- Add `deleted_at` with a migration using `$table->softDeletes()`.
- Add the `SoftDeletes` trait to the `Chirp` model.
- Change deletion to a soft delete.
- Add a private or authenticated trash page.
- Add a restore action for the owner or an administrator.
- Add a permanent delete action with an explicit confirmation step.
- Learn and demonstrate `withTrashed()`, `onlyTrashed()`, and `restore()`.

### 5. Improve Authentication Feedback

Complete the login controller and make authentication behavior consistent.

Suggested tasks:

- Validate email and password input.
- Authenticate with `Auth::attempt`.
- Regenerate the session after login.
- Redirect authenticated users away from guest pages.
- Return useful validation errors without revealing sensitive information.
- Add tests for successful login, failed login, logout, and session regeneration.

### 6. Add Search and Pagination

Make the feed easier to use as the number of chirps grows.

Suggested tasks:

- Add a search input for message or author name.
- Use Eloquent query building instead of filtering in Blade.
- Replace `take(50)->get()` with pagination.
- Display pagination links.
- Preserve search terms while navigating pages.
- Add feature tests for search and pagination.

### 7. Add Stronger Domain Features

Choose one or more:

- Character counter and clearer validation feedback.
- Hashtags with a searchable hashtag page.
- Likes or bookmarks with database relationships.
- User profile pages and a user's chirp history.
- Admin moderation tools.
- Report a chirp workflow.
- Rate limiting for chirp creation.
- Notifications when someone interacts with a chirp.
- API endpoints protected with authentication and feature tests.

Keep each feature focused. A small, well-tested feature is better than a large unfinished change.

## Quality Checklist

Before submitting, run:

```bash
php artisan test --compact
vendor/bin/pint --dirty --format agent
php artisan route:list
```

Also check manually that:

- A guest cannot create, edit, delete, restore, or permanently delete chirps.
- A user can manage only their own chirps.
- Validation errors are visible and do not lose the submitted form data.
- CSRF protection is present on state-changing forms.
- Empty states and success messages are understandable.
- Your changes work after `php artisan migrate:fresh --seed`.

## Commit and Submit Your Work

Use clear commits that describe the change:

```bash
git add .
git commit -m "Add chirp editing and deletion"
git push -u origin feature/your-name-chirp-improvements
```

Then open a pull request from your fork to `JuniorDCoder/traitz-backend-chirps:main`.

Your pull request should include:

- Your name and the exercise(s) completed.
- A short summary of the behavior you added.
- Screenshots or a short recording for UI changes.
- The tests and commands you ran.
- Any decisions, tradeoffs, or questions.
- A note about unfinished work, if applicable.

After opening the pull request, email **dcodertechie@gmail.com** with:

- Subject: `Traitz Chirps Internship Submission - Your Name`
- Your full name.
- Your GitHub username.
- The pull request URL.
- The exercise(s) completed.
- A short reflection on what you learned and what you would improve next.

## Learning References

- [Laravel Learn](https://laravel.com/learn)
- [Laravel Documentation](https://laravel.com/docs)
- [Routing](https://laravel.com/docs/routing)
- [Controllers](https://laravel.com/docs/controllers)
- [Eloquent Relationships](https://laravel.com/docs/eloquent-relationships)
- [Validation](https://laravel.com/docs/validation)
- [Authorization](https://laravel.com/docs/authorization)
- [Soft Deletes](https://laravel.com/docs/eloquent#soft-deleting)
- [Testing](https://laravel.com/docs/testing)
- [Laravel Boost](https://laravel.com/docs/boost)

## Maintainer

Created and maintained by **Junior DCoder** for the **TraitzTech Laravel backend internship learning program**.

The purpose of this repository is practice: read the existing code, make a small improvement, test it, explain it, and keep learning.
