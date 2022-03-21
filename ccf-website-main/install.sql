
create table `persons` (
    `id` int not null primary key auto_increment,
    `firstname` varchar(200) not null default '',
    `lastname` varchar(200) not null default '',
    `birthdate` date default null,
    `gender` enum('m', 'f', 'o') default null
) engine=InnoDB default character set 'UTF8MB4';

create table `contracts` (
    `id` int not null primary key auto_increment,
    `person` int not null,
    `start` date not null,
    `end` date default null,
    `position` varchar(200) not null,
    `vacations` int not null default 0,
    `salary` numeric not null
) engine=InnoDB default character set 'UTF8MB4';

create table `vacations` (
    `day` date not null,
    `person` int not null,
    `type` enum('paid', 'unpaid', 'sick') default null,
    `approved` boolean default null,
    primary key(`day`, `person`)
) engine=InnoDB default character set 'UTF8MB4';

create table `users` (
    `login` varchar(50) not null primary key,
    `pwd` text not null
) engine=InnoDB default character set 'UTF8MB4';

alter table `contracts`
add constraint `fk_contracts_person`
foreign key (`person`)
references `persons`(`id`)
on delete restrict on update cascade;

alter table `vacations`
add constraint `fk_vacations_person`
foreign key (`person`)
references `persons`(`id`)
on delete restrict on update cascade;
