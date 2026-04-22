# Chatway Poll System

Real-time polling app built with Laravel. Admins create polls, users vote, results update live via Pusher WebSockets.

Auth and UI scaffolding uses [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze).

---

## Requirements

- PHP 8.1+
- Composer
- Node.js 18+
- MySQL
- [Pusher](https://pusher.com) account (free tier works)

---

## Installation

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database and Pusher credentials:

```env
DB_DATABASE=chatway_poll_db
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=pusher

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

ADMIN_SIGNUP_KEY=your-secret-key
```

Run migrations and seed roles:

```bash
php artisan migrate
php artisan db:seed --class=RoleSeeder
```

Build assets:

```bash
npm run dev
```

Start the server:

```bash
php artisan serve
```

---

## Admin signup

Register as an admin by visiting:

```
http://localhost:8000/register?admin_key=chatway-poll-admin-key
```

The `admin_key` must match `ADMIN_SIGNUP_KEY` in your `.env`. After login, admins land on `/admin/polls` where they can create polls, view results, and copy shareable links.

---

## Real-time updates

Uses Pusher — no local WebSocket server needed. When a vote is submitted, the results on every open browser tab update instantly without a page reload.

---

## Tests

Run the full test suite:

```bash
php artisan test
```

To run only the voting test cases:

```bash
php artisan test --filter=VotingTest
```
