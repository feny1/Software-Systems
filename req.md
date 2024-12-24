## Functional Requirements

### General Requirements
1. **Login/Registration:**
   - Users must be able to create an account or log in using email and password.
   - Support for password recovery.
2. **Edit Profile:**
   - Users must be able to update their profile information, such as name, contact details, and other relevant information.

### Individual Users (Based on Role/Flag)
1. **Filter Jobs:**
   - Ability to search and filter job listings based on location, job type, salary range, and other criteria.
2. **Apply for Jobs:**
   - Submit job applications with a personalized cover letter and uploaded resume.
3. **View Requests:**
   - Access to a list of job application statuses (e.g., pending, accepted, rejected).

### Organizations
1. **Post a Job:**
   - Create and publish job postings with details such as title, description, qualifications, and salary.
2. **View History:**
   - View a history of past job postings and applications received.
3. **View Requests:**
   - See a list of applications received for each job posting.
4. **Manage Applications:**
   - Accept, reject, or mark applications as pending.

### Admin
1. **Assign Roles/Flags:**
   - Manage user roles (Admin, Employee, User, Owner).
   - Update role/flag assignments for both individuals and organizations.

## Non-Functional Requirements
1. **Performance:**
   - The system should handle up to 10,000 concurrent users without significant performance degradation.
2. **Usability:**
   - Intuitive and user-friendly interface for all roles.
3. **Security:**
   - Data encryption for sensitive information (e.g., passwords, personal details).
   - Role-based access control to ensure only authorized users can perform specific actions.
4. **Scalability:**
   - The system must support adding new features and scaling infrastructure as the user base grows.
5. **Reliability:**
   - Ensure 99.9% uptime with proper error handling and recovery mechanisms.
6. **Compliance:**
   - Adhere to GDPR and other relevant data privacy regulations.

## Use Cases

### Use Case 1: User Login
**Actors:** Individual, Organization, Admin

**Precondition:**
- The user has an existing account.

**Main Flow:**
1. User enters email and password.
2. System authenticates the credentials.
3. User is redirected to their dashboard based on role/flag.

**Alternate Flow:**
- If authentication fails, display error message and allow retry.

**Exceptions:**
- Account locked due to multiple failed login attempts.
- User account does not exist.

### Use Case 2: Job Posting (Organization)
**Actors:** Organization Owner

**Precondition:**
- User is logged in as an Organization Owner.

**Main Flow:**
1. User navigates to the "Post a Job" section.
2. Enters job details such as title, description, qualifications, and salary.
3. Submits the form.
4. System saves the job posting and makes it visible to Individual users.

**Alternate Flow:**
- If validation fails (e.g., missing required fields), display error messages and allow corrections.

**Exceptions:**
- Network failure during submission.
- Exceeding job posting limit for the account.

### Use Case 3: Apply for a Job (Individual)
**Actors:** Individual User

**Precondition:**
- User is logged in as an Individual with Employee or User role.

**Main Flow:**
1. User browses or filters job listings.
2. Selects a job and clicks on "Apply."
3. Uploads resume and adds a cover letter.
4. System submits the application to the corresponding Organization.

**Alternate Flow:**
- If the application fails to submit, display an error message and retain data for retry.

**Exceptions:**
- File upload exceeds allowed size or format restrictions.
- Application limit exceeded for the job.

### Use Case 4: Manage Applications (Organization)
**Actors:** Organization Owner

**Precondition:**
- User is logged in as an Organization Owner and has active job postings.

**Main Flow:**
1. User navigates to the "View Requests" section.
2. Selects an application to review.
3. Accepts, rejects, or marks the application as pending.
4. System updates the application status and notifies the applicant.

**Exceptions:**
- Network failure during status update.
- Unauthorized access attempt by a non-owner.

### Use Case 5: Assign Roles (Admin)
**Actors:** Admin

**Precondition:**
- User is logged in as Admin.

**Main Flow:**
1. Admin navigates to the "Manage Users" section.
2. Searches for a user by name or email.
3. Selects a user and assigns or updates their role/flag.
4. System saves the changes and updates the user’s permissions.

**Alternate Flow:**
- If user details are not found, display an error message.

**Exceptions:**
- Role assignment fails due to database error.
- Admin lacks sufficient privileges to assign certain roles.

This document provides a structured overview of functional and non-functional requirements along with key use cases and exceptions for the system.