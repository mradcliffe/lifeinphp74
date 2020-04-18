# Life in PHP 7.4

Code kata for Conway's Game of Life using PHP 7.4.

## Features

We want to demonstrate the following features of PHP 7.4:

- [x] Typed Properties
- [x] Arrow Functions
- [x] (Limited) Return Type Covariance and Argument Type Contravariance
- [x] Null-Coalescing assignment operator
- [ ] Unpacking Inside Arrays (Spread Operator)

## Game of Life

The rules for posterity:

   1. Any live cell with fewer than two live neighbours dies, as if caused by underpopulation.
   2. Any live cell with more than three live neighbours dies, as if by overcrowding.
   3. Any live cell with two or three live neighbours lives on to the next generation.
   4. Any dead cell with exactly three live neighbours becomes a live cell.
   
Take in an argument of a text file that looks like this:

```
Generation 1:
4 8
........
....*...
...**...
........
```

Each cell interacts with its eight neighbors (orthagonal and diagnol directions) each tick. The second generation would look like this:

```
Generation 2:
4 8
........
...**...
...**...
........
```