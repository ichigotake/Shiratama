
create table account (
    id int unsigned not null primary key auto_increment,
    name varchar(255) unique not null,
    mail varchar(255) unique not null
) engine=innodb default character set utf8;


