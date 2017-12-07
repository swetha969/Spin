# Problem 2
Solution to a coding challenge by SG Interactive

Problem 2: Implement a basic spin results end point
- Description
  - Slot Machine Spin Results is our server end point that updates all player data and features when a spin is completed on the client. We do hundreds of millions of these requests per day, and we would like to see you make a very basic MySQL driven version.
  - This can be just a normal PHP file that gets called, or you can implement more modern routing if you would like
- Data Storage
  - Create a MySQL database that contains a player table with the following fields:
    - Player ID
    - Name
    - Credits
    - Lifetime Spins
    - Salt Value
- Code
  - Your code should validate the following request data: hash, coins won, coins bet, player ID
  - Update the player data in MySQL if the data is valid
  - Generate a JSON response with the following data:
    - Player ID
    - Name
    - Credits
    - Lifetime Spins
    - Lifetime Average Return
  - You can assume that the client making the request has the salt value to make the hash.
- Submission
  - Please upload your code and MySQL schema to either Bit Bucket or Github
