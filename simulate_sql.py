import sqlite3
import pandas as pd

# Create in-memory database
conn = sqlite3.connect(':memory:')
cursor = conn.cursor()

# 1. Setup Data
print("--- SETTING UP DATABASE ---")
cursor.executescript("""
CREATE TABLE users ( id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR(255), email VARCHAR(255) );
CREATE TABLE orders ( id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER, total DECIMAL(10, 2), FOREIGN KEY (user_id) REFERENCES users(id) );

INSERT INTO users (id, name, email) VALUES 
(1, 'Ahmad Hassan', 'ahmad@example.com'), 
(2, 'Siti Nurhaliza', 'siti@example.com'), 
(3, 'Wei Ming', 'weiming@example.com'), 
(4, 'Raj Kumar', 'raj@example.com'), 
(5, 'Lisa Tan', 'lisa@example.com'), 
(6, 'Farah Aini', 'farah@example.com'), 
(7, 'David Lim', 'david@example.com');

INSERT INTO orders (id, user_id, total) VALUES 
(1, 1, 150.00), (2, 1, 200.00), 
(3, 2, 300.00), 
(4, 3, 450.00), (5, 3, 100.00), 
(6, 4, 500.00), 
(7, 5, 250.00), 
(8, 1, 175.00); 
""")
conn.commit()
print("Database populated with sample data.\n")

# 2. Run Query 1
print("--- TASK 1, QUERY 1 OUTPUT: Top 5 Users by Spend ---")
query1 = """
SELECT u.id, u.name, u.email, SUM(o.total) as total_spent
FROM users u
JOIN orders o ON u.id = o.user_id
GROUP BY u.id
ORDER BY total_spent DESC
LIMIT 5;
"""
print(pd.read_sql_query(query1, conn).to_string(index=False))
print("\n")

# 3. Run Query 2
print("--- TASK 1, QUERY 2 OUTPUT: Users with No Orders ---")
query2 = """
SELECT u.id, u.name, u.email
FROM users u
LEFT JOIN orders o ON u.id = o.user_id
WHERE o.id IS NULL
ORDER BY u.id ASC;
"""
print(pd.read_sql_query(query2, conn).to_string(index=False))
print("\n")
