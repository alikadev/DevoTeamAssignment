#include <stdio.h>
#include <stdlib.h>
#include <ctype.h>

#include "app.h"


world_t world;
robot_t robot;


app_status app_simulate(char *buffer)
{
	// Iterate each instruction
	while(*buffer && !isspace(*buffer))
	{
		// Check instruction
		switch (*buffer++)
		{
		case RIGHT: 
			robot_do_right(&robot);
			break;
		case LEFT: 
			robot_do_left(&robot);
			break;
		case FORWARD: 
			robot_do_forward(&robot, &world);
			break;
		default:
			return APP_BAD_INSTRUCTION;
		}
		debugf("Step %ldx%ld %c\n", robot.x, robot.y, robot.direction);
	}

	return APP_SUCCESS;
}

#define SKIP_SPACES(buffer) while(isspace(*(buffer))) (buffer)++
app_status app_simulation_init(char **pBuffer)
{
	char *start;

	// Get the world width
	start = *pBuffer;
	world.width = strtol(start, pBuffer, 10);
	if (*pBuffer == start) return APP_BAD_FILE_FORMAT;
	SKIP_SPACES(*pBuffer);

	// Get the world height
	start = *pBuffer;
	world.height = strtol(start, pBuffer, 10);
	if (*pBuffer == start) return APP_BAD_FILE_FORMAT;
	SKIP_SPACES(*pBuffer);

	debugf("World %ldx%ld\n", world.width, world.height);

	// Get the robot x position
	start = *pBuffer;
	robot.x = strtol(start, pBuffer, 10);
	if (*pBuffer == start) return APP_BAD_FILE_FORMAT;
	SKIP_SPACES(*pBuffer);

	// Get the robot y position
	start = *pBuffer;
	robot.y = strtol(start, pBuffer, 10);
	if (*pBuffer == start) return APP_BAD_FILE_FORMAT;
	SKIP_SPACES(*pBuffer);

	robot.direction = *(*pBuffer)++;
	SKIP_SPACES(*pBuffer);

	debugf("Robot %ldx%ld %c\n", robot.x, robot.y, robot.direction);

	return APP_SUCCESS;
}
#undef SKIP_SPACES