/* assuming that only one category is desired (based on "the category") being used even if multiple categories, with the most number of jobs, share the same job count */
SELECT category_name FROM (
	SELECT cat_id, count(*) job_count
	FROM `jobs`
	GROUP BY cat_id
	ORDER BY job_count desc
	LIMIT 1
) job_counts
LEFT JOIN categories on categories.id = job_counts.cat_id


/* assuming that all categories that have the most number of jobs should be returned in the result set */
SELECT counted_categories.category_name FROM (
	SELECT categories.category_name, count(*) job_count, max_job_count.job_max max_job_count
	FROM `jobs`
	LEFT JOIN categories on categories.id = jobs.cat_id
	LEFT JOIN ( 
			SELECT  max(job_count) job_max FROM (
				SELECT count(*) job_count
				FROM `jobs`
				GROUP BY cat_id
			) counted_job_categories
		) max_job_count
	ON 1=1
	GROUP BY jobs.cat_id
) counted_categories
WHERE counted_categories.job_count = counted_categories.max_job_count
