/* TASK 1 - QUERY 1: Top 5 Users by Total Order Amount 
Explanation: 
I joined the `users` and `orders` tables on `user_id` to link users with their orders.
Then, I used `GROUP BY` on the user's details and calculated the sum of their order totals using `SUM(orders.total)`.
Finally, I ordered the results by `total_spent` in descending order and limited the output to the top 5 records.
*/
SELECT 
    u.id AS user_id,
    u.name,
    u.email,
    SUM(o.total) AS total_spent
FROM 
    users u
JOIN 
    orders o ON u.id = o.user_id
GROUP BY 
    u.id, u.name, u.email
ORDER BY 
    total_spent DESC
LIMIT 5;
