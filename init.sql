create table applications (
    id int primary key auto_increment,
    first_name varchar(105) not null,
    last_name varchar(105) not null,
    dob date not null,
    gender enum('male', 'female') not null,
    title varchar(105) not null,
    status enum('open', 'closed', 'cancelled') not null default 'open',
    created_at datetime not null default current_timestamp
) engine=InnoDb char set=utf8mb4;

create table services (
    id int primary key auto_increment,
    name varchar(155) not null,
    description text,
    available tinyint(1) not null,
    created_at datetime not null default current_timestamp,
    updated_at datetime
);

create table users (
   id int primary key auto_increment,
   email varchar(255) not null,
   password varchar(255) not null,
   first_name varchar(105) not null,
   last_name varchar(105) not null,
   created_at datetime not null default current_timestamp
);

create table countries (
   id int primary key auto_increment,
   iso2 varchar(4) not null,
   name varchar(55) not null
);

/**
  Here we have junction table that will establish connection:
  One Service can be placed in multiple Countries and One Country can have multiple Services.
 */
create table service_countries (
   id int primary key auto_increment,
   country_id int not null,
   service_id int not null,
   foreign key (country_id) references countries (id),
   foreign key (service_id) references services (id),
   unique key (country_id, service_id)
);

/*
 Here we have junction table that will establish connection:
 One Application can use multiple Country Services and One Country Service can be used by multiple Applications.
 */
create table application_services (
    id int primary key auto_increment,
    application_id int not null,
    country_service_id int not null,
    requested_by int not null,
    foreign key (application_id) references applications (id),
    foreign key (country_service_id) references service_countries (id),
    foreign key (requested_by) references users (id),
    unique key (application_id, country_service_id)
);