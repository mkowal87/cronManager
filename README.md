# Cron Manager #

Cron tool for scraping data of availability of products, from various pages.

**Supported pages**
1. H&M

**How to use**

run script `./bin/console app:get-product-info-hm productNumber`

It is possible also to add parameter `csv` so information about product and 
availability will be stored in CSV file. 

Example product URL: https://www2.hm.com/pl_pl/productpage.0591466035.html

from there we can obtain a `productNumber` __0591466035__

By default all information are stored in DB, so they can be later read to show
it on frontend page. 


Tool is still in development stage. Things to do later:
1. Fronend page
2. Mailing for availability of products 
3. Check for product size demand by user
4. Possibility of adding new Ids by user, so it can be run on crons with some
default lifetime (30 days).





__For Educational Purposes Only__