# WebAudit
WebAudit was a project created by myself as partial fulfilment of the requirements for an honours degree at Plymouth University. 

The idea of Web Audit project was to identify security pitfalls of websites and to recommend solutions to the problems it found. It aimed to be as user friendly as possible and would be made so that those with little technical background could understand the solutions it proposed.

The application was split into two components. The first component being a Python application that would do most of the scanning work. The second component is a PHP website that allows users to add websites, start scans and view scan reports.

# Website component

This repository contains the website that was produced. It was built on the CakePHP framework as I had used it previously on other projects. As the website was not the main focus of the project it is not very feature rich, but it does the job.

Both components share the same MySQL database. The schema can be found here: https://github.com/benscobie/webaudit-website/blob/master/config/install.sql

# Python component

The repository for the python component can be found here: https://github.com/benscobie/webaudit-py
