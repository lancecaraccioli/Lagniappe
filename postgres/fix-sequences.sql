--running this script will generate sql which will fix broken sequences for a postgres database... (tested on postgres 8.4)

select 'SELECT setval('''||ns.nspname||'.'||cs.relname||''', max("'||attname||'")) FROM "'||ns.nspname||'"."'||c.relname||'";' from pg_class c, pg_class cs, pg_attribute a, pg_attrdef d, pg_namespace ns where c.relnamespace = ns.oid and cs.relkind = 'S' and d.adsrc ~ cs.relname and c.oid = a.attrelid and c.oid = d.adrelid and d.adnum = a.attnum;

