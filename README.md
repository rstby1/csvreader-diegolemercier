# Practical Activity - Laravel Develop
## 1.1	Instruction
Sales System.

## 1.2	Context
A client has requested the construction of a system that allows the local staff of the company to import batches of sales data from an external system and extend functionalities existing in the legacy system.

## 1.3	Analysis
According to the requirements analysis carried out, it is observed that the external system can export to a CSV file with the following format:
- Row 1: Header
- Rows 2 onwards: Payload

The CSV file is a text file separated by semicolons (;) with variable-length information with the following data:
- Column 1: Date: String formatted as DD/MM/YYYY
- Column 2: Invoice type: Char with the following values: A, B
- Column 3: Point of sale number: varchar(5) for example: 00001
- Column 4: Invoice number: varchar(10) for example: 0000000137
- Column 5: Sales amount: Double (15,2)
- Column 6: Customer CUIT: BIGINT
- Column 7: Company Name varchar(30)
- Column 8: Customer number int(11) (Number of customers in the external system)

## 1.4	Solution Requirement
The system to be developed should allow attaching a file with the described format and import the information into a destination table called import_sales, whose structure should be sufficient to store said information.

With each import performed, a second task should be triggered, which will consist of creating clients on which the following should be carried out:
- Previous creation of the Client with existing basic data: CUIT / Company Name / Customer number
- A field called YTD (Year to date or year-to-date) must be updated in the table, which should store the accumulated sales of the last year up to the date based on the registered sales. A new field in the client table called "tier" should also be updated, which will take values 1, 2, or 3 according to the amount of sales: Tier 1: Sales up to 1M, Tier 2: Sales between 1M and 3M, and Tier 3: Sales over 3M.

As a third requirement of the application, clients should be able to be manually added/modified by entering the following basic data:
- Column 6: Customer CUIT: BIGINT
- Column 7: Company Name varchar(30)
- Column 8: Customer number int(11)

Minimal validations should be implemented to ensure data consistency:
- The CUIT cannot be repeated among clients.
- The customer number must be unique.
- Duplicate invoices (Type and Number) cannot be imported.
- An invoice cannot have a zero value.
- The date of an invoice cannot be in the future.
- Others: Any other type of validation is left to the discretion of the student.
