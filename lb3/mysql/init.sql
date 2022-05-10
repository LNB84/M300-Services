Use MYSQL_DATABASE;
drop table if exists `users`;
create table `users` (
    id int not null auto_increment,
    username text not null,
    password text not null,
    primary key (id)
);
insert into `users` (username, password) values
    ("Administrator","password"),
    ("Testuser","this is my password"),
    ("Job","12345678");