#ifndef __CTRL_H_
#define __CTRL_H_

#include <stdio.h>

// ===== PROGRAM INFOS ===== //

typedef enum 
{
	APP_SUCCESS = 0,
	APP_NOT_ENOUTH_ARGS,
	APP_TOO_MUCH_ARGS,
	APP_FILE_OPEN_ERROR,
	APP_ALLOC_ERROR,
	APP_READ_ERROR,
	APP_BAD_FILE_FORMAT,
	APP_BAD_INSTRUCTION
} app_status;

typedef struct
{
	const char *inputFile;
} app_args;

#ifdef DEBUG
#define debugf(a ...) printf("DEBUG::" a)
#else
#define debugf(...)
#endif // DEBUG



// ===== ROBOT INFOS ===== //

typedef enum 
{
	NORTH = 'N',
	WEST = 'W',
	SOUTH = 'S',
	EAST = 'E',
} robot_direction;

typedef enum 
{
	RIGHT   = 'R',
	LEFT    = 'L',
	FORWARD = 'F',
} robot_instruction;

typedef struct 
{
	size_t x;
	size_t y;
	robot_direction direction;
} robot_t;



// ===== WORLD INFOS ===== //

typedef struct 
{
	size_t width;
	size_t height;
} world_t;



// ===== FUNCTIONS DECLARATIONS ===== //
// utilities
app_status app_get_args(app_args *pArgs, int argc, const char *argv[]);
app_status app_read_all(char **pBuffer, const char *filename);
// simulation.c
app_status app_simulation_init(char **pBuffer);
app_status app_simulate(char *buffer);
// robot.c
void robot_do_right(robot_t *robot);
void robot_do_left(robot_t *robot);
void robot_do_forward(robot_t *robot, const world_t *world);

#endif