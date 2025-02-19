CREATE DATABASE candidate_scoring;
USE candidate_scoring;

-- Users Table (Admin, Interviewer, HR)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'interviewer', 'hr') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Candidates Table
CREATE TABLE candidates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    position_applied VARCHAR(100),
    referred_by VARCHAR(100),
    resume VARCHAR(255),  -- File path for uploaded resumes
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Evaluations Table
CREATE TABLE evaluations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    candidate_id INT,
    interviewer_id INT,
    analytical_skills INT CHECK (analytical_skills BETWEEN 1 AND 5),
    technical_skills INT CHECK (technical_skills BETWEEN 1 AND 5),
    communication_skills INT CHECK (communication_skills BETWEEN 1 AND 5),
    business_acumen INT CHECK (business_acumen BETWEEN 1 AND 5),
    problem_solving INT CHECK (problem_solving BETWEEN 1 AND 5),
    overall_score FLOAT,
    comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (candidate_id) REFERENCES candidates(id) ON DELETE CASCADE,
    FOREIGN KEY (interviewer_id) REFERENCES users(id) ON DELETE CASCADE
);
