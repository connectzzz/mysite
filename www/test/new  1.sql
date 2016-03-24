

select country.Name,city.Name ,Code,count(city.name)
from country
 inner join city
 on country.Code=city.CountryCode
 where country.Code in('FIN','DNK') 
group by country.Name, city.Name with rollup;

-- Список стран у которых есть города милионеры
select  country.name  ,count(country.name) -- , city.name, city.population -- 
from country
inner join city
on country.code=city.countryCode
where city.population >=1000000
 group by country.name
;

-- Список стран в которых нет городов милионеров
/*
select  country.name  ,count(country.name) -- , city.name, city.population -- 
from country
inner join city
on country.code=city.countryCode
where   city.population >=1000000
 group by country.name
;
*/
select country.name 
from country -- ,city  при добовленнии сити получается бред почему>????????
where country.Code not in(
					select  distinct country.code 
					from country
					inner join city
					on country.code=city.countryCode
					where city.population >=1000000)
;




-- Создайте просмотр стран АЗии
DROP VIEW IF EXISTS azia;	
CREATE VIEW azia AS
	SELECT name,code
	FROM country
	WHERE continent='Asia'
	;


