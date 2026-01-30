# PetBacker Backend Technical Assessment

This repository contains my submission for the PetBacker Backend Developer Technical Assessment.

## Overview

The assessment consists of two main tasks:
1.  **SQL Query Challenge**: writing SQL queries to analyze user and order data.
2.  **PHP Matching Algorithm**: developing a logic to match pet owners with suitable service providers based on multiple criteria.

## File Structure

- **`query1.sql`**: SQL query to find the Top 5 Users by Total Order Amount.
- **`query2.sql`**: SQL query to find Users Who Haven't Placed Any Orders.
- **`matching_algorithm.php`**: The PHP function `matchRequestsToListings()` that matches user requests to service listings.

## Verification

I have included test scripts to verify the correctness of the solutions.

### 1. Verify PHP Matching Algorithm
To test the matching logic against the sample data provided in the assessment:

```bash
php test_matcher.php
```

**Expected Output:**
- `REQ001` matches compatible providers (checking distance, pet type, etc.).
- `REQ002` matches only providers who accept aggressive pets and last-minute bookings.

### 2. Verify SQL Queries
To simulate the database queries using a temporary in-memory database (requires Python & Pandas):

```bash
python simulate_sql.py
```

This script creates a temporary SQLite database with the seed data and runs the queries from `query1.sql` and `query2.sql` to display the results.

## Author
Adib
