# laravel-livewire-poll

> **Note:** This repository is for **learning purposes only**. It is not intended for production use.

A simple poll application built with Laravel and Livewire, where users can create polls with multiple options and vote on them, with vote counts updating in real time.

## Tech Stack

- PHP 8.3+
- Laravel 13
- Livewire 4 (single-file components)
- MySQL
- Tailwind CSS

## What I Learned

### Laravel
- Creating **migrations** for related tables (`polls`, `options`, `votes`) and using `foreignIdFor()->constrained()` for foreign keys.
- Defining **Eloquent relationships** with `hasMany` and `belongsTo` (Poll → Options → Votes).
- Using **mass assignment** with `$fillable`.
- Creating related records in one go with `create()` and `createMany()` through a relationship.
- **Eager loading** nested relationships with `with('options.votes')` to avoid the N+1 query problem.
- Sorting records with `latest()`.

### Livewire
- Building **single-file components** (`⚡component-name.blade.php`) that keep the PHP class and the Blade template together.
- **Two-way data binding** with `wire:model.live`.
- Handling form submission with `wire:submit.prevent` and calling actions with `wire:click.prevent`.
- Working with **dynamic array inputs** (adding and removing poll options, and re-indexing with `array_values()`).
- **Validation** with `$rules`, custom `$messages`, nested array rules (`options.*`), and real-time validation with `validateOnly()` in the `updated()` hook.
- Resetting form state with `$this->reset()`.
- **Communicating between components with events**: `create-poll` dispatches `pollCreated` with `$this->dispatch()`, and `polls` listens with the `#[On('pollCreated')]` attribute, so a new poll shows up in the list right away.
- **Voting** with an action that takes a model as a parameter (`vote(Option $option)`). Livewire turns the ID from `wire:click="vote({{ $option->id }})"` into an `Option` model automatically.
- Recording a vote through a relationship with `$option->votes()->create()`, and showing vote counts with `$option->votes->count()`.
- Loading data from the database into a view:
  - `mount()` runs once and stores the data in a public property.
  - `with()` passes fresh data to the view on every render, so it's the better fit for data that changes, like vote counts.
- Why a class property can't be assigned a query directly (`public $polls = Poll::get();` is invalid PHP). Property defaults must be constant values.

### Blade
- Looping with `@foreach` and `@forelse` / `@empty`.
- Showing validation errors with `@error`.
- Using Tailwind's `@apply` to create reusable styles.

## Getting Started

```bash
git clone <repo-url>
cd livewire-poll

composer install
npm install

cp .env.example .env
php artisan key:generate

# Create a MySQL database named "livewire-poll" and update your .env credentials
php artisan migrate

composer run dev
```

Then open `http://localhost:8000` in your browser.
