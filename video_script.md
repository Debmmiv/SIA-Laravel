# Video Script: Laravel Beyond CRUD — Search, Pagination & PDF Export
**Duration: ~4 minutes**

---

## INTRO (0:00 – 0:20)

> "Hi! In this video, I'll be walking you through how I enhanced my Laravel CRUD application with three advanced features: **search filtering**, **pagination**, and **PDF generation**. These features were added to my existing **Customer Management** page. Let me show you each part."

---

## PART 1: Customer Model & Factory (0:20 – 0:50)

**(Open `app/Models/Customer.php`)**

> "First, let's start with the **Customer Model**. I added the `HasFactory` trait so we can use a factory to generate sample data."

**(Open `database/factories/CustomerFactory.php`)**

> "Then I created a **CustomerFactory** that uses Faker to generate realistic fake data — names, addresses, a random gender of Male or Female, and a date of birth."

**(Open `database/seeders/DatabaseSeeder.php`)**

> "In the **DatabaseSeeder**, I added `Customer::factory(20)->create()` which seeds 20 sample customers into our database. This gives us enough data to properly test our pagination."

---

## PART 2: Controller — Search & Pagination (0:50 – 1:50)

**(Open `app/Http/Controllers/CustomerController.php`)**

> "Now for the main logic. In the **CustomerController**, I updated the `index` method. Instead of fetching all customers with `Customer::all()`, I now use a query builder."

> "It checks if there's a `search` parameter in the request. If there is, it filters records where the **name**, **address**, or **gender** matches the search term using `LIKE`. Then it paginates the results — **5 records per page** — and appends the search query to the pagination links so the search is preserved when navigating between pages."

> "I also added a new method called `exportPdf`. This method applies the **same search filter**, but instead of paginating, it fetches **all matching records** and loads them into a PDF view using the `barryvdh/laravel-dompdf` package. It then returns the PDF as a download called `customers-report.pdf`."

---

## PART 3: Routes (1:50 – 2:10)

**(Open `routes/web.php`)**

> "For routing, I added a new GET route: `customers/export-pdf` that points to our `exportPdf` method. One important thing — this route is placed **before** the resource route. That's because if we placed it after, Laravel would try to match `export-pdf` as a customer ID parameter, and it would throw an error."

---

## PART 4: The View — Search Bar, Table & Pagination (2:10 – 3:10)

**(Open `resources/views/customers/index.blade.php`)**

> "The biggest visual change is in the **index view**. At the top, I have a bar with an **Add Customer** button in green, an **Export PDF** button in red, and a **search form** with an input field and search button."

> "The search form uses a GET method, so the search term appears in the URL and can be bookmarked. There's also a **Clear** button that appears when a search is active."

> "The table itself has styled **Edit** and **Delete** buttons — green and red pill-style buttons. And if no results are found, it shows a friendly empty state message."

> "At the bottom, there's a **pagination footer**. On the left, it shows 'Showing 1 to 5 of 20 results', and on the right are the **page navigation links** — you can click through pages and the search filter stays active."

---

## PART 5: PDF Template (3:10 – 3:30)

**(Open `resources/views/customers/pdf.blade.php`)**

> "For the PDF, I created a clean, print-friendly template. It has a header with the title and generation date. If a search filter was active when you exported, it shows what filter was applied. The table lists all matching customers with numbered rows, and at the bottom it shows the total record count."

---

## DEMO (3:30 – 3:50)

**(Switch to browser — show the customer page)**

> "Let me do a quick demo. Here's the customer list with pagination. I can search for a customer… the results filter instantly. I can navigate between pages… and if I click Export PDF, it downloads a report with all the filtered data."

---

## OUTRO (3:50 – 4:00)

> "And that's it! We've successfully added **search**, **pagination**, and **PDF export** to our Laravel application. Thank you for watching!"

---
