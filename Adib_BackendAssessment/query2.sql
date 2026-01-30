/* TASK 1 - QUERY 2: Users Who Haven't Placed Any Orders 
Explanation: 
I used a `LEFT JOIN` between `users` and `orders` tables. This preserves all records from the `users` table.
Then, I filtered the results using `WHERE o.id IS NULL`, which identifies row where there is no matching record in the `orders` table (i.e., the user has no orders).
Finally, sort the results by `user_id` ASC as requested.
*/
SELECT 
    u.id AS user_id,
    u.name,
    u.email
FROM 
    users u
LEFT JOIN 
    orders o ON u.id = o.user_id
WHERE 
    o.id IS NULL
ORDER BY 
    u.id ASC;
