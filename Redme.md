# Supplier Product List Processor
## Introduction
Supplier Product List Processor is a php terminal application that processes different formats of supplier product lists and maps it dynamically into product objects.
## Usage
To run the application, you need to have php installed on your machine. You can run the application by executing the following command in the terminal:
```
php parser.php --file=products_comma_separated.csv --unique-combinations=combination_count.csv
```
The --file argument is required and it is the path to the supplier product list file. The --unique-combinations argument is optional and it is the path to the file where the unique combinations of the products will be saved. If the --unique-combinations argument is not provided, the unique combinations will be saved in output.csv file in the same directory as the parser.php file.
## Supported formats
The application supports the following formats:
- CSV
- XML - future implementation
- JSON - future implementation
- YAML - future implementation