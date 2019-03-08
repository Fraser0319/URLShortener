create table `shortend_urls` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key', 
    `short_url_key` varchar(255) UNIQUE NOT NULL COMMENT 'short url key', 
    `original_url` varchar(255) NOT NULL COMMENT 'original url', 
    PRIMARY KEY (`id`)
);