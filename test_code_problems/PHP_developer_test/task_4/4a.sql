/*assuming that the 4a task description of "userid" actually referes to the jobs.user_id field*/

SELECT categories.category_name, count(*)
FROM `jobs`
LEFT JOIN categories on categories.id = jobs.cat_id
WHERE jobs.user_id = 94
GROUP BY categories.id