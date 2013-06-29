
create table account (
    id int unsigned not null primary key,
    name text unique not null,
    mail text unique not null
);


