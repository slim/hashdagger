create table canvass (id varchar(50) primary key, user_id varchar(50), volunteer_id varchar(50), person_id varchar(50), place_id varchar(50), begin datetime, end datetime, opened_door datetime, answered_questions datetime);
create table place (id varchar(50) primary key, region varchar(50), district varchar(50), street varchar(50), building varchar(5), level varchar(5), house varchar(5));
create table person (id varchar(50) primary key, name varchar(50), age int, phone varchar(50), mail varchar(50), place_id varchar(50));
create table opinion (id varchar(50) primary key, person_id varchar(50), will_vote datetime, for_party datetime, for_independent datetime, reason varchar(150), is_supporter datetime, is_volunteer datetime, note varchar(150));
