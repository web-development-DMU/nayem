-- Database schema and sample data for the Student Course Hub
-- This script creates the necessary tables and inserts a handful of
-- sample records so you can get started quickly.  Run this on your
-- MySQL server before running the application.

DROP DATABASE IF EXISTS student_course_hub;
CREATE DATABASE student_course_hub;
USE student_course_hub;

-- Levels table holds course level names
CREATE TABLE Levels (
    LevelID INT PRIMARY KEY,
    LevelName VARCHAR(50) NOT NULL
);

-- Staff table holds academic staff details
CREATE TABLE Staff (
    StaffID INT PRIMARY KEY,
    Name VARCHAR(120) NOT NULL,
    Email VARCHAR(255) DEFAULT NULL,
    Bio TEXT DEFAULT NULL
);

-- Modules table defines all course modules
CREATE TABLE Modules (
    ModuleID INT PRIMARY KEY,
    ModuleName VARCHAR(160) NOT NULL,
    ModuleLeaderID INT,
    Description TEXT,
    FOREIGN KEY (ModuleLeaderID) REFERENCES Staff(StaffID)
);

-- Programmes table defines degree programmes
CREATE TABLE Programmes (
    ProgrammeID INT PRIMARY KEY AUTO_INCREMENT,
    ProgrammeName VARCHAR(160) NOT NULL,
    Description TEXT,
    Image VARCHAR(255),
    LevelID INT,
    ProgrammeLeaderID INT,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (LevelID) REFERENCES Levels(LevelID),
    FOREIGN KEY (ProgrammeLeaderID) REFERENCES Staff(StaffID)
);

-- ProgrammeModules joins programmes and modules with study year
CREATE TABLE ProgrammeModules (
    ProgrammeID INT,
    ModuleID INT,
    Year INT,
    PRIMARY KEY (ProgrammeID, ModuleID, Year),
    FOREIGN KEY (ProgrammeID) REFERENCES Programmes(ProgrammeID),
    FOREIGN KEY (ModuleID) REFERENCES Modules(ModuleID)
);

-- Students table stores user accounts for login
CREATE TABLE Students (
    StudentID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100) NOT NULL,
    Email VARCHAR(255) UNIQUE NOT NULL,
    PasswordHash VARCHAR(255) NOT NULL
);

-- InterestedStudents records expressions of interest
CREATE TABLE InterestedStudents (
    InterestedID INT PRIMARY KEY AUTO_INCREMENT,
    ProgrammeID INT NOT NULL,
    StudentName VARCHAR(100) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    RegisteredAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ProgrammeID) REFERENCES Programmes(ProgrammeID)
);

-- Insert sample levels
INSERT INTO Levels (LevelID, LevelName) VALUES
    (1, 'Undergraduate'),
    (2, 'Postgraduate');

-- Insert sample staff
INSERT INTO Staff (StaffID, Name, Email, Bio) VALUES
    (1, 'Dr. Alice Johnson', 'alice@example.edu', 'Lecturer in Computer Science'),
    (2, 'Dr. Brian Lee', 'brian@example.edu', 'Senior Lecturer in Software Engineering'),
    (3, 'Dr. Carol White', 'carol@example.edu', 'Professor of Artificial Intelligence'),
    (4, 'Dr. David Green', 'david@example.edu', 'Professor of Cyber Security');

-- Insert sample modules
INSERT INTO Modules (ModuleID, ModuleName, ModuleLeaderID, Description) VALUES
    (1, 'Introduction to Programming', 1, 'Learn basic programming concepts in Python and Java.'),
    (2, 'Mathematics for Computer Science', 2, 'Study discrete mathematics and linear algebra.'),
    (3, 'Computer Systems & Architecture', 3, 'Explore how computers work at a low level.'),
    (4, 'Databases', 4, 'Introduction to relational databases and SQL.'),
    (5, 'Software Engineering', 2, 'Learn software development lifecycles and project management.'),
    (6, 'Cyber Security Fundamentals', 4, 'Basics of network security and cryptography.');

-- Insert sample programmes
INSERT INTO Programmes (ProgrammeName, Description, Image, LevelID, ProgrammeLeaderID, is_published) VALUES
    ('BSc Computer Science', 'A broad CS degree covering programming, AI, security, and software engineering.', '', 1, 1, 1),
    ('BSc Software Engineering', 'Specialised degree focusing on software development lifecycle.', '', 1, 2, 1),
    ('BSc Artificial Intelligence', 'Focus on machine learning and AI applications.', '', 1, 3, 1),
    ('BSc Cyber Security', 'Topics in network security, ethical hacking, and forensics.', '', 1, 4, 1),
    ('MSc Cyber Security', 'Advanced study of cyber security and digital forensics.', '', 2, 4, 1);

-- Map modules to programmes for year 1
INSERT INTO ProgrammeModules (ProgrammeID, ModuleID, Year) VALUES
    (1, 1, 1), (1, 2, 1), (1, 3, 1), (1, 4, 1),
    (2, 1, 1), (2, 2, 1), (2, 3, 1), (2, 4, 1),
    (3, 1, 1), (3, 2, 1), (3, 3, 1), (3, 4, 1),
    (4, 1, 1), (4, 2, 1), (4, 3, 1), (4, 4, 1),
    (5, 1, 1), (5, 2, 1), (5, 3, 1), (5, 6, 1);

-- Admins table stores administrator accounts for secure login
CREATE TABLE Admins (
    AdminID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100) NOT NULL,
    Email VARCHAR(255) UNIQUE NOT NULL,
    PasswordHash VARCHAR(255) NOT NULL
);

-- Insert default admin account (email: admin@example.com, password: admin123)
INSERT INTO Admins (Name, Email, PasswordHash) VALUES
    ('Administrator', 'admin@example.com', '0192023a7bbd73250516f069df18b500');