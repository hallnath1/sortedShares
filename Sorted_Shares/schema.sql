DROP TABLE Users;
CREATE TABLE Users(UserID INTEGER PRIMARY KEY, fName varchar(30), lName varchar(30), username varchar(30), email varchar(50), password varchar(20), salt varchar(20), profileLink varChar(10), color varchar(30), paypalLink varchar(20));

DROP TABLE Relations;
CREATE TABLE Relations(RelationID INTEGER PRIMARY KEY, UserID int, FriendID int, FOREIGN KEY(UserID) REFERENCES Users(UserID), FOREIGN KEY(FriendID) REFERENCES Users(UserID));

DROP TABLE Groups;
CREATE TABLE Groups(GroupID INTEGER PRIMARY KEY, name varchar(30), groupType varchar(10));

DROP TABLE Users_Groups;
CREATE TABLE Users_Groups(UserID int, GroupID int, FOREIGN KEY(UserID) REFERENCES Users(UserID), FOREIGN KEY(GroupID) REFERENCES Groups(GroupsID));

DROP TABLE Bills;
CREATE TABLE Bills(BillID INTEGER PRIMARY KEY, title varchar(30),amount REAL, UserID int, PayeeID int, status varchar(20), createdDate DATETIME, FOREIGN KEY(UserID) REFERENCES Users(UserID));

DROP TABLE Messages;
CREATE TABLE Messages(UserID int, ToID int, message text, sentTimeDate DATETIME, type text, BillID int, FOREIGN KEY(UserID) REFERENCES Users(UserID), FOREIGN KEY(ToID) REFERENCES Users(UserID));