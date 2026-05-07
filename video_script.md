# Activity 15 – Video Script
# Role-Based Access Control (RBAC) for Functionality in Laravel
# Target Duration: ~4 Minutes

---

## [INTRO — 0:00 to 0:30]

📺 SCREEN: Open `http://127.0.0.1:8000` in the browser — show the Laravel login page or dashboard.

"Hello everyone. In this video, I will be demonstrating **Activity 15** — Role-Based Access Control in Laravel, but this time focused on **functionality** — specifically, controlling CRUD operations based on a user's role.

In our previous activity, we used RBAC to control which **pages** a user can visit.
In this activity, it's different — **all users access the same page**, but what they are **allowed to do** on that page depends on their role.

We have three roles in our system:
- **Admin** — full access: Create, Read, Update, and Delete
- **Staff** — partial access: can only Update
- **User** — read-only: can only View"

---

## [PART 1: DATABASE & SEEDER — 0:30 to 1:00]

📺 SCREEN: Switch to VS Code. Open this file:
👉 `database/migrations/2026_04_27_000001_add_role_to_users_table.php`
Highlight line: `$table->string('role')->default('user')->after('avatar');`

"Let's start with the database. Our `users` table has a `role` column added through this migration — it stores either `admin`, `staff`, or `user`. This single column is the foundation of our entire RBAC system."

📺 SCREEN: Stay in VS Code. Switch to this file:
👉 `database/seeders/DatabaseSeeder.php`
Highlight the three User::factory() blocks (lines 20–38).

"In our seeder, we have three pre-configured test accounts:
- **John Dave** — role: `admin`
- **Bruce Bilar** — role: `staff`
- **Denzel Aliwate** — role: `user`

These represent the three levels of access we will demonstrate."

---

## [PART 2: ROUTES & CONTROLLER — 1:00 to 1:55]

📺 SCREEN: Stay in VS Code. Open this file:
👉 `routes/web.php`
Highlight the comment block: `// Customers: all authenticated users can access the page.`
and the two lines below it: `Route::get('customers/export-pdf'...)` and `Route::resource('customers'...)`.

"Now let's look at how RBAC is enforced in the backend.

First, in `web.php`, I moved the Customers routes **out** of the admin-only middleware group. This means all authenticated users can now navigate to the Customers page.

However, this does NOT mean they can do everything. The real protection happens inside the **controller**."

📺 SCREEN: Stay in VS Code. Switch to this file:
👉 `app/Http/Controllers/CustomerController.php`
Scroll to the `create()` method — highlight lines:
```php
if (auth()->user()->role !== 'admin') {
    abort(403, 'Unauthorized. Only admins can add customers.');
}
```

"Here is the **core concept of this activity**. Inside each method, we check the user's role before allowing the action.

For `create` and `store` — adding a new customer — only **Admin** is allowed. If anyone else tries to access it, they get a 403 Forbidden error immediately."

📺 SCREEN: Scroll down to the `edit()` method — highlight:
```php
if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
    abort(403, 'Unauthorized. Only admins and staff can edit customers.');
}
```

"For `edit` and `update`, both **Admin and Staff** are allowed.

And for `destroy` — delete is **Admin only**."

📺 SCREEN: Scroll down to the `destroy()` method to show its guard briefly.

"This is the most important point: **backend validation is essential**. Hiding a button in the interface is not enough — the controller must enforce the rules as well."

---

## [PART 3: BLADE UI CONTROL — 1:55 to 2:30]

📺 SCREEN: Stay in VS Code. Open this file:
👉 `resources/views/customers/index.blade.php`
Scroll to and highlight the role access banner block (the `@php $bannerStyle = match($role)...` and the `<div style="...">` below it).

"Now let's see how this is reflected in the user interface using Blade directives.

At the top of the Customers page, we have a dynamic role banner that clearly shows what access level the current user has."

📺 SCREEN: Scroll down to the `Add Customer` button block — highlight:
```blade
@if(auth()->user()->role === 'admin')
    <a href="...">Add Customer</a>
    <a href="...">Export PDF</a>
@endif
```

"The Add Customer and Export PDF buttons are wrapped in a role check — **Admin only** sees these."

📺 SCREEN: Scroll to the table rows section. Highlight the Edit button block:
```blade
@if(in_array(auth()->user()->role, ['admin', 'staff']))
    <a href="...">Edit</a>
@endif
```

"The Edit button is visible to both **Admin and Staff**."

📺 SCREEN: Highlight the Delete button block just below:
```blade
@if(auth()->user()->role === 'admin')
    <button>Delete</button>
@endif
```

"Delete is **Admin only**. And if the role is `user`, they simply see the text 'View only' — no buttons at all."

---

## [PART 4: LIVE DEMONSTRATION — 2:30 to 3:50]

📺 SCREEN: Switch to the browser. Go to `http://127.0.0.1:8000/login`

---

### 👤 Admin Login (2:30 – 3:00)

📺 SCREEN: Fill in the login form:
- Email: `johndave@admin.com`
- Password: `password`
Click Login.

"First, let's log in as the **Admin** — John Dave."

📺 SCREEN: After login, look at the top navigation bar — point out the purple **ADMIN** badge next to the username.

"Notice the purple Admin badge next to the name in the navigation bar."

📺 SCREEN: Click the **Customers** link in the top nav. URL becomes `http://127.0.0.1:8000/customers`.

"On the Customers page, the banner reads: 'Admin — Full access: View, Add, Edit, Delete.'"

📺 SCREEN: Slowly scroll and point to the green **Add Customer** button, the red **Export PDF** button, and the **Edit** and **Delete** buttons on each row.

"All buttons are visible — Add Customer, Export PDF, Edit, and Delete on every row."

📺 SCREEN: Click **Add Customer**, fill in a name and details, click Submit. A success message appears.

"Let me quickly add a new customer — successfully added."

📺 SCREEN: Click **Edit** on any row, change one field, click Update Record.

"Edit works too. Now let me delete one."

📺 SCREEN: Click **Delete** on any row, click OK on the confirmation dialog.

"Deleted. The Admin has complete control."

📺 SCREEN: Click the username dropdown (top right) → click **Log Out**.

---

### 👤 Staff Login (3:00 – 3:25)

📺 SCREEN: On the login page, fill in:
- Email: `bruce@willis`
- Password: `password`
Click Login.

"Now let's switch to the **Staff** account — Bruce Bilar."

📺 SCREEN: Look at the top nav — point out the blue **STAFF** badge.

"Notice the blue Staff badge."

📺 SCREEN: Click the **Customers** link. URL becomes `http://127.0.0.1:8000/customers`.

"The banner reads: 'Staff — Limited access: View and Edit only.'"

📺 SCREEN: Slowly scroll the top bar area — the Add Customer and Export PDF buttons are gone. Scroll down the table rows — only green Edit buttons are visible, no red Delete buttons.

"Add Customer is gone. Export PDF is gone. And Delete buttons are gone from every row."

📺 SCREEN: Click **Edit** on any row, update a field, click Update Record.

"Only Edit works. Staff can update existing records, but cannot create or delete."

📺 SCREEN: In the browser address bar, manually type `http://127.0.0.1:8000/customers/create` and press Enter.

"Now, what if Staff tries to access the create page directly through the URL?"

📺 SCREEN: The browser shows a **403 Forbidden / Unauthorized** error page.

"403 — Forbidden. The backend blocks it immediately. This proves that hiding buttons in the UI alone is not enough — the controller enforces the rule too."

📺 SCREEN: Click the username dropdown → click **Log Out**.

---

### 👤 User Login (3:25 – 3:45)

📺 SCREEN: On the login page, fill in:
- Email: `denzel@denzel`
- Password: `password`
Click Login.

"Finally, the regular **User** — Denzel Aliwate."

📺 SCREEN: Look at the top nav — point out the dark gray **USER** badge.

"The gray User badge appears."

📺 SCREEN: Click the **Customers** link. URL becomes `http://127.0.0.1:8000/customers`.

"The banner reads: 'User — Read-only access: View only.'"

📺 SCREEN: Slowly scroll — the top bar has no Add or Export buttons. Scroll through the table rows — each row's Actions column shows only the small gray 'View only' text.

"There are no action buttons anywhere — only the 'View only' label. The user can see the data, but cannot make any changes whatsoever."

📺 SCREEN: Click the username dropdown → click **Log Out**.

---

## [CLOSING — 3:50 to 4:00]

📺 SCREEN: Switch back to VS Code. Show `app/Http/Controllers/CustomerController.php` with both the `abort(403)` guard and the Blade `@if` snippet side by side — or simply scroll slowly through CustomerController.php.

"And that concludes our demonstration of **Activity 15 — RBAC for Functionality**.

To summarize:
- **Same page**, **different capabilities** — based on role
- **Blade directives** control the UI visibility
- **Controller abort(403)** guards enforce backend security
- Both layers working together is what makes the system truly secure.

Thank you."

---

*End of Script*
*Total estimated time: ~4 minutes*
