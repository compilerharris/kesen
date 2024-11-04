# Process Management System

The **Process Management System** is a comprehensive tool designed to streamline and automate operations for KeSen Language Bureau. This web application simplifies complex workflows, enabling seamless tracking and management across various departments. The solution is crafted to enhance productivity, reduce manual effort, and improve communication with clients and employees, ultimately reducing the estimate generation time from 25 minutes to just 5 minutes.

## Features
The system is designed to provide robust management capabilities through multiple specialized modules:

- **Estimate Management:** Quickly create, modify, and track estimates with streamlined processes, reducing time and improving accuracy.
- **Job Card Register and Management:** Manage job cards efficiently with a clear record of each project, its status, and detailed requirements.
- **Employee Management:** Centralize employee records, assign roles, and monitor workload distribution, helping optimize workforce productivity.
- **Writer Management:** Efficiently manage writers' information, including assignments, workloads, and performance metrics.
- **Client Management:** Maintain a detailed client database, track communication, and ensure all client requirements are documented and addressed.
- **Language Management:** Manage and organize data related to languages offered, allowing easy access for project assignments and client interactions.
- **Workload Reports:** Generate reports to assess workload distribution among team members, enabling better resource allocation.
- **Workdone Reports:** Track project progress and completion rates with detailed reports to help monitor efficiency and adherence to deadlines.

## Technology Stack
The project leverages a robust stack to ensure high performance, reliability, and scalability:
- **Backend:** Laravel, PHP
- **Frontend:** jQuery, Ajax
- **Database:** MySQL
- **Hosting Server:** Windows Server 2012 R2

## Getting Started
### Prerequisites
- PHP (Version 7.4 or later)
- Composer
- MySQL
- Windows Server (for deployment)

### Installation
1. **Clone the Repository**  
   ```bash
   git clone https://github.com/compilerharris/kesen.git
   cd kesen

2. **Install Dependencies**  
   ```bash
   composer install

3. **Setup Database**  
    - Create a MySQL database.
    - Configure your .env file with the database connection details.

4. **Run Migrations**  
   ```bash
   php artisan migrate

5. **Start the Application**  
   ```bash
   php artisan serve

### Usage
 - **Estimate Management:** Navigate to the Estimates module to create new estimates, view previous estimates, and update or delete entries.
 - **Job Card Register and Management:** Access the Job Cards module to manage all active job cards. Track status updates and add comments for project milestones.
 - **Employee Management:** Under Employees, add or remove team members, assign roles, and monitor assigned jobs and workloads.
 - **Writer Management:** Access the Writers module to manage assignments, track workloads, and evaluate performance metrics.
 - **Client Management:** Use the Clients module to manage client details, track projects associated with each client, and maintain contact records.
 - **Language Management:** Manage supported languages and assign them to projects or clients as needed.
 - **Workload Reports:** Access workload reports for insights into team distribution and project assignments.
 - **Workdone Reports:** View completed projects and analyze project timelines and completion rates.

### Deployment
The application is designed to be deployed on Windows Server 2012 R2:
1. **Copy Files to Server:** Transfer the project files to your server.
2. **Set Up Database Connection:** Ensure the MySQL database is accessible from your server and configure the database credentials in the ```.env``` file.
3. **Start Laravel Application:** Use IIS or Apache configured for PHP to run the Laravel application on Windows Server.

### Contributing
We welcome contributions to improve functionality or add features:
1. Fork the repository.
2. Create a feature branch (```git checkout -b feature/NewFeature```).
3. Commit changes (```git commit -m 'Add new feature'```).
4. Push to the branch (```git push origin feature/NewFeature```).
5. Open a pull request.

### License
This project is licensed under the [MIT](https://opensource.org/licenses/MIT) License.

### Contact
For any questions or inquiries, please contact Haris Shaikh at compilerharris@gmail.com.

### Author
Haris Shaikh – [LinkedIn](https://www.linkedin.com/in/compilerharris) – [GitHub](https://github.com/compilerharris)