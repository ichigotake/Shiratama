
create table account (
    id integer not null primary key autoincrement,
    name text unique not null,
    mail text unique not null
);


