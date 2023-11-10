CREATE OR REPLACE TABLE counties (
    county_code VARCHAR(2) PRIMARY KEY,
    county_name VARCHAR(255) NOT NULL
);

-- save file to MySQL data path
LOAD DATA INFILE "/var/lib/mysql-files/coduri-judete.csv"
INTO TABLE counties
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
